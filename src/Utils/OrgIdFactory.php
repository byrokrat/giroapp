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

namespace byrokrat\giroapp\Utils;

use byrokrat\id\IdFactoryInterface;
use byrokrat\id\IdInterface;
use byrokrat\id\Exception\UnableToCreateIdException;

class OrgIdFactory implements IdFactoryInterface
{
    /**
     * @var IdFactoryInterface
     */
    private $decorated;

    public function __construct(IdFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function createId(string $number): IdInterface
    {
        try {
            return $this->decorated->createId($number);
        } catch (UnableToCreateIdException $e) {
            return new MissingOrgId;
        }
    }
}
