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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Xml;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ViewXmlMandatesConsole implements ConsoleInterface
{
    use DependencyInjection\MoneyFormatterProperty;

    /** @var Helper\FileOrStdinInputLocator */
    private $inputLocator;

    /** @var Xml\XmlMandateCompiler */
    private $xmlMandateCompiler;

    public function __construct(
        Helper\FileOrStdinInputLocator $inputLocator,
        Xml\XmlMandateCompiler $xmlMandateCompiler
    ) {
        $this->inputLocator = $inputLocator;
        $this->xmlMandateCompiler = $xmlMandateCompiler;
    }

    public function configure(Command $command): void
    {
        $command
            ->setName('view-xml-mandates')
            ->setDescription('View xml formatted mandates')
            ->setHelp('View the contents of one or more xml formatted mandates')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to import'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $xmlMandateDumper = new Xml\HumanDumper($this->moneyFormatter);

        foreach ($this->inputLocator->getFiles((array)$input->getArgument('path')) as $file) {
            foreach ($this->xmlMandateCompiler->compileFile($file) as $xmlMandate) {
                $output->writeln($xmlMandateDumper->dump($xmlMandate));
            }
        }
    }
}
