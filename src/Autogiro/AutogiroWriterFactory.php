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
 * Copyright 2016-20 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\Autogiro;

use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\autogiro\Writer\WriterFactory;
use byrokrat\autogiro\Writer\WriterInterface;
use byrokrat\banking\AccountNumber;

class AutogiroWriterFactory
{
    /**
     * @var WriterFactory
     */
    private $decorated;

    public function __construct(WriterFactory $decorated)
    {
        $this->decorated = $decorated;
    }

    public function createWriter(ConfigInterface $bgcNr, AccountNumber $bankgiro): WriterInterface
    {
        return $this->decorated->createWriter($bgcNr->getValue(), $bankgiro);
    }
}
