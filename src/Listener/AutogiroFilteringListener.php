<?php
/**
 * This file is part of byrokrat\giroapp.
 *
 * byrokrat\giroapp is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Mapper\SettingsMapper;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use byrokrat\banking\BankgiroFactory;

/**
 * Filter NodeEvents where payee information does not match local registry
 */
class AutogiroFilteringListener
{
    /**
     * @var BankgiroFactory
     */
    private $bankgiroFactory;

    /**
     * @var SettingsMapper
     */
    private $settingsMapper;

    public function __construct(BankgiroFactory $bankgiroFactory, SettingsMapper $settingsMapper)
    {
        $this->bankgiroFactory = $bankgiroFactory;
        $this->settingsMapper = $settingsMapper;
    }

    public function onMandateResponseReceived(NodeEvent $event, string $eventName, Dispatcher $dispatcher): void
    {
        $appBg = $this->bankgiroFactory->createAccount($this->settingsMapper->findByKey('bankgiro'));
        $nodeBg = $event->getNode()->getChild('payee_bankgiro')->getAttribute('account');

        if (!$nodeBg->equals($appBg)) {
            $dispatcher->dispatch(
                Events::ERROR,
                new LogEvent(
                    'File contains invalid payee bankgiro account number',
                    ['bankgiro' => (string)$nodeBg]
                )
            );

            $event->stopPropagation();
        }
    }
}
