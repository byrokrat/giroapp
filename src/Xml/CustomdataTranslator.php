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

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Exception\InvalidXmlMandateMigrationException;
use byrokrat\amount\Currency\SEK;

/**
 * Write data to donor builder based on xml mandate migration map
 */
class CustomdataTranslator
{
    /**
     * @var callable[]
     */
    private $migrationMap;

    /**
     * @throws InvalidXmlMandateMigrationException if migration map contains invalid value
     */
    public function __construct(XmlMandateMigrationInterface $migrationMap)
    {
        foreach ($migrationMap->getXmlMigrationMap() as $key => $value) {
            if (is_callable($value)) {
                $this->migrationMap[$key] = $value;
                continue;
            }

            switch ($value) {
                case XmlMandateMigrationInterface::PHONE:
                    $this->migrationMap[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setPhone($value);
                    };
                    break;
                case XmlMandateMigrationInterface::EMAIL:
                    $this->migrationMap[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setEmail($value);
                    };
                    break;
                case XmlMandateMigrationInterface::DONATION_AMOUNT:
                    $this->migrationMap[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setDonationAmount(new SEK($value));
                    };
                    break;
                case XmlMandateMigrationInterface::COMMENT:
                    $this->migrationMap[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setComment($value);
                    };
                    break;
                default:
                    throw new InvalidXmlMandateMigrationException("Invalid migration for key $key");
            }
        }
    }

    /**
     * Write value to donorBuilder using migration map as translation key
     */
    public function writeValue(DonorBuilder $donorBuilder, string $key, string $value)
    {
        if (isset($this->migrationMap[$key])) {
            return (unset)$this->migrationMap[$key]($donorBuilder, $value);
        }

        return (unset)$donorBuilder->setAttribute($key, $value);
    }
}
