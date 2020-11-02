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

declare(strict_types = 1);

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\Filesystem\FileInterface;

/**
 * Compile XmlMandate objects using a parser and compiler passes
 */
class XmlMandateCompiler
{
    /** @var XmlMandateParser */
    private $parser;

    /** @var array<CompilerPassInterface> */
    private $compilerPasses = [];

    public function __construct(XmlMandateParser $parser)
    {
        $this->parser = $parser;
    }

    public function addCompilerPass(CompilerPassInterface $compilerPass): void
    {
        $this->compilerPasses[] = $compilerPass;
    }

    /**
     * @return array<XmlMandate>
     */
    public function compileFile(FileInterface $file): array
    {
        $xmlObject = XmlObject::fromString($file->getContent());

        if (!$xmlObject) {
            throw new \RuntimeException("Unable to parse XML from file {$file->getFilename()}");
        }

        return $this->compileMandates($xmlObject);
    }

    /**
     * @return array<XmlMandate>
     */
    public function compileMandates(XmlObject $xmlRoot): array
    {
        $raw = $this->parser->parseXml($xmlRoot);
        $processed = [];

        foreach ($raw as $mandate) {
            foreach ($this->compilerPasses as $pass) {
                $mandate = $pass->processMandate($mandate);
            }

            $processed[] = $mandate;
        }

        return $processed;
    }
}
