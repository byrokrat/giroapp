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

use byrokrat\giroapp\Exception\InvalidXmlException;

/**
 * Works as a facade to the actual xml processing
 */
class XmlObject
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml;

    /**
     * @throws InvalidXmlException If $content is not valid xml
     */
    public function __construct(string $content)
    {
        try {
            $this->xml = new \SimpleXMLElement($content);
        } catch (\Exception $e) {
            throw new InvalidXmlException($e->getMessage());
        }
    }

    /**
     * Cast to xml string
     */
    public function asXml(): string
    {
        return $this->xml->asXML();
    }

    /**
     * Check if element exists
     */
    public function hasElement(string $path): bool
    {
        return !!$this->xml->xpath($path);
    }

    /**
     * Read the content of the first element matching xpath query
     *
     * @throws InvalidXmlException If no element matching query is found
     */
    public function readElement(string $path): string
    {
        $result = $this->xml->xpath($path);

        if (empty($result)) {
            throw new InvalidXmlException("Unable to find element $path");
        }

        return (string)$result[0];
    }

    /**
     * Generator that yields XmlObject instances with xml subsets
     */
    public function getElements(string $path): iterable
    {
        foreach ($this->xml->xpath($path) as $element) {
            yield new XmlObject($element->asXML());
        }
    }
}
