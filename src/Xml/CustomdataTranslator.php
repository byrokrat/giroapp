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
     * @var XmlMandateMigrationInterface
     */
    private $migrationMap;

    /**
     * @var array Collection of created migration maps
     */
    private $createdMaps = [];

    public function __construct(XmlMandateMigrationInterface $migrationMap)
    {
        $this->migrationMap = $migrationMap;
    }

    /**
     * Write value to donorBuilder using migration map as translation key
     */
    public function writeValue(DonorBuilder $donorBuilder, string $formId, string $key, string $value): void
    {
        $map = $this->getMap($formId);
        isset($map[$key])
            ? $map[$key]($donorBuilder, $value)
            : $donorBuilder->setAttribute($key, $value);
    }

    /**
     * Get cached map for requested form
     */
    private function getMap(string $formId): array
    {
        if (!isset($this->createdMaps[$formId])) {
            $this->createdMaps[$formId] = $this->buildMap($formId);
        }

        return $this->createdMaps[$formId];
    }

    /**
     * @throws InvalidXmlMandateMigrationException if migration map contains invalid value
     */
    private function buildMap(string $formId): array
    {
        $map = [];

        foreach ($this->migrationMap->getXmlMigrationMap($formId) as $key => $value) {
            if (is_callable($value)) {
                $map[$key] = $value;
                continue;
            }

            switch ($value) {
                case XmlMandateMigrationInterface::PHONE:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setPhone($value);
                    };
                    break;
                case XmlMandateMigrationInterface::EMAIL:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setEmail($value);
                    };
                    break;
                case XmlMandateMigrationInterface::DONATION_AMOUNT:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setDonationAmount(new SEK($value));
                    };
                    break;
                case XmlMandateMigrationInterface::COMMENT:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setComment($value);
                    };
                    break;
                default:
                    throw new InvalidXmlMandateMigrationException("Invalid migration for key $key");
            }
        }

        return $map;
    }
}
