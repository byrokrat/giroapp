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

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\Model\Builder\DonorBuilder;
use byrokrat\giroapp\Exception\InvalidXmlFormException;
use byrokrat\amount\Currency\SEK;

/**
 * Write data to donor builder based on form translations
 */
class XmlFormTranslator
{
    /**
     * @var XmlFormInterface[]
     */
    private $xmlForms = [];

    /**
     * @var array
     */
    private $createdMaps = [];

    public function addXmlForm(XmlFormInterface $xmlForm)
    {
        $this->xmlForms[] = $xmlForm;
    }

    /**
     * Write translated value to donorBuilder
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
     * @throws InvalidXmlFormException if map contains invalid value
     */
    private function buildMap(string $formId): array
    {
        $map = [];
        $translations = [];

        foreach ($this->xmlForms as $xmlForm) {
            if ($xmlForm->getName() == $formId) {
                $translations = $xmlForm->getTranslations();
                break;
            }
        }

        foreach ($translations as $key => $value) {
            if (is_callable($value)) {
                $map[$key] = $value;
                continue;
            }

            switch ($value) {
                case XmlFormInterface::PHONE:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setPhone($value);
                    };
                    break;
                case XmlFormInterface::EMAIL:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setEmail($value);
                    };
                    break;
                case XmlFormInterface::DONATION_AMOUNT:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setDonationAmount(new SEK($value));
                    };
                    break;
                case XmlFormInterface::COMMENT:
                    $map[$key] = function ($donorBuilder, $value) {
                        $donorBuilder->setComment($value);
                    };
                    break;
                default:
                    throw new InvalidXmlFormException("Invalid translation for key $key");
            }
        }

        return $map;
    }
}
