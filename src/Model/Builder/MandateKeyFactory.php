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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Model\Builder;

use byrokrat\id\IdInterface;
use byrokrat\banking\AccountNumber;
use Hashids\Hashids;

class MandateKeyFactory
{
    /**
     * Number of chars in created keys
     */
    const KEY_LENGTH = 16;

    /**
     * @var Hashids
     */
    private $hashEngine;

    /**
     * Set internal hash engine (must create keys of the desired length!)
     */
    public function __construct(Hashids $hashEngine = null)
    {
        $this->hashEngine = $hashEngine ?: new Hashids(
            '',
            self::KEY_LENGTH,
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );
    }

    /**
     * Create a unique mandate key
     */
    public function createMandateKey(IdInterface $id, AccountNumber $account): string
    {
        $key = $this->hashEngine->encode($id->format('Ss') . substr($account->get16(), 0, -1));

        if (strlen($key) != self::KEY_LENGTH) {
            throw new \LogicException('Mandate key of wrong key size.');
        }

        return $key;
    }
}
