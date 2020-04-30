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

use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\CommandBus\UpdateAttribute;
use byrokrat\giroapp\CommandBus\UpdateName;
use byrokrat\giroapp\CommandBus\UpdatePostalAddress;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\NewMandate;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\giroapp\Validator;
use byrokrat\giroapp\Xml\XmlMandate;
use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlObject;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Streamer\Stream;

final class ImportXmlMandateConsole implements ConsoleInterface
{
    use DependencyInjection\AccountFactoryProperty,
        DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty,
        DependencyInjection\DonorRepositoryProperty,
        DependencyInjection\IdFactoryProperty;

    /** @var FilesystemInterface */
    private $filesystem;

    /** @var XmlMandateParser */
    private $xmlMandateParser;

    public function __construct(FilesystemInterface $filesystem, XmlMandateParser $xmlMandateParser)
    {
        $this->filesystem = $filesystem;
        $this->xmlMandateParser = $xmlMandateParser;
    }

    public function configure(Command $command): void
    {
        $command
            ->setName('import-xml-mandate')
            ->setDescription('Import an xml formatted mandate')
            ->setHelp('Import one or more xml formatted mandates from autogirot')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to import'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $files = [];

        $paths = (array)$input->getArgument('path');

        if (empty($paths) && defined('STDIN')) {
            $files[] = new Sha256File('STDIN', (new Stream(STDIN))->getContent());
        }

        foreach ($paths as $path) {
            if ($this->filesystem->isFile($path)) {
                $files[] = $this->filesystem->readFile($path);
                continue;
            }

            foreach ($this->filesystem->readDir($path) as $file) {
                $files[] = $file;
            }
        }

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        foreach ($files as $file) {
            $this->dispatcher->dispatch(new LogEvent("Importing from XML file {$file->getFilename()}"));

            $xmlObject = XmlObject::fromString($file->getContent());

            foreach ($this->xmlMandateParser->parseXml($xmlObject) as $xmlMandate) {
                $this->dispatcher->dispatch(new LogEvent("Importing new mandate"));
                $this->processMandate($xmlMandate, $inputReader);
            }
        }
    }

    private function processMandate(XmlMandate $xmlMandate, Helper\InputReader $inputReader): void
    {
        $inputReader->readOptionalInput(
            'donorId',
            $xmlMandate->donorId->format('CS-sk'),
            new Validator\ValidatorCollection(
                new Validator\IdValidator,
                new Validator\CallbackValidator(function (string $value) use (&$xmlMandate) {
                    $xmlMandate->donorId = $this->idFactory->createId($value);
                })
            )
        );

        $xmlMandate->payerNumber = $inputReader->readOptionalInput(
            'payer-number',
            $xmlMandate->payerNumber ?: $xmlMandate->donorId->format('Ssk'),
            new Validator\PayerNumberValidator
        );

        $inputReader->readOptionalInput(
            'account',
            $xmlMandate->account->prettyprint(),
            new Validator\ValidatorCollection(
                new Validator\AccountValidator,
                new Validator\CallbackValidator(function (string $value) use (&$xmlMandate) {
                    $xmlMandate->account = $this->accountFactory->createAccount($value);
                })
            )
        );

        $xmlMandate->name = $inputReader->readOptionalInput(
            'name',
            $xmlMandate->name,
            new Validator\ValidatorCollection(
                new Validator\StringValidator,
                new Validator\NotEmptyValidator
            )
        );

        $xmlMandate->address['line1'] = $inputReader->readOptionalInput(
            'address1',
            $xmlMandate->address['line1'],
            new Validator\StringValidator
        );

        $xmlMandate->address['line2'] = $inputReader->readOptionalInput(
            'address2',
            $xmlMandate->address['line2'],
            new Validator\StringValidator
        );

        $xmlMandate->address['line3'] = $inputReader->readOptionalInput(
            'address3',
            $xmlMandate->address['line3'],
            new Validator\StringValidator
        );

        $xmlMandate->address['postalCode'] = $inputReader->readOptionalInput(
            'postal-code',
            $xmlMandate->address['postalCode'],
            new Validator\PostalCodeValidator
        );

        $xmlMandate->address['postalCity'] = $inputReader->readOptionalInput(
            'postal-city',
            $xmlMandate->address['postalCity'],
            new Validator\StringValidator
        );

        foreach ($xmlMandate->attributes as $attrKey => $attrValue) {
            $xmlMandate->attributes[$attrKey] =
                $inputReader->readOptionalInput("attribute.$attrKey", $attrValue, new Validator\StringValidator);
        }

        $this->commandBus->handle(
            new AddDonor(
                new NewDonor(
                    MandateSources::MANDATE_SOURCE_ONLINE_FORM,
                    $xmlMandate->payerNumber,
                    $xmlMandate->account,
                    $xmlMandate->donorId,
                    Money::SEK('0')
                )
            )
        );

        $donor = $this->donorRepository->requireByPayerNumber($xmlMandate->payerNumber);

        $this->commandBus->handle(new UpdateState($donor, NewMandate::getStateId(), 'Mandate added from xml'));

        $this->commandBus->handle(new UpdateName($donor, $xmlMandate->name));

        $this->commandBus->handle(new UpdatePostalAddress($donor, new PostalAddress(
            $xmlMandate->address['line1'],
            $xmlMandate->address['line2'],
            $xmlMandate->address['line3'],
            $xmlMandate->address['postalCode'],
            $xmlMandate->address['postalCity'],
        )));

        foreach ($xmlMandate->attributes as $attrKey => $attrValue) {
            $this->commandBus->handle(new UpdateAttribute($donor, $attrKey, $attrValue));
        }
    }
}
