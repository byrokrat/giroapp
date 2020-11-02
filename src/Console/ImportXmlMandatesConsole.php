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

use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\NewMandate;
use byrokrat\giroapp\Validator;
use byrokrat\giroapp\Xml;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Streamer\Stream;

final class ImportXmlMandatesConsole implements ConsoleInterface
{
    use DependencyInjection\AccountFactoryProperty,
        DependencyInjection\CommandBusProperty,
        DependencyInjection\DonorRepositoryProperty,
        DependencyInjection\MoneyFormatterProperty,
        DependencyInjection\MoneyParserProperty,
        DependencyInjection\IdFactoryProperty;

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
            ->setName('import-xml-mandates')
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
        $xmlMandateDumper = new Xml\HumanDumper($this->moneyFormatter);

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        foreach ($this->inputLocator->getFiles((array)$input->getArgument('path')) as $file) {
            $output->writeln("<info>Importing mandates from {$file->getFilename()}</info>");

            foreach ($this->xmlMandateCompiler->compileFile($file) as $xmlMandate) {
                $output->writeln('<info>New mandate:</info>');

                $output->writeln($xmlMandateDumper->dump($xmlMandate));

                if ($inputReader->confirm("Edit [<info>y/N</info>]? ", false)) {
                    $this->processMandate($xmlMandate, $inputReader);
                }

                $this->storeMandate($xmlMandate);
            }
        }
    }

    private function processMandate(Xml\XmlMandate $xmlMandate, Helper\InputReader $inputReader): void
    {
        $inputReader->readOptionalInput(
            self::OPTION_ID,
            $xmlMandate->donorId->format('CS-sk'),
            new Validator\ValidatorCollection(
                new Validator\IdValidator,
                new Validator\CallbackValidator(function (string $value) use (&$xmlMandate) {
                    $xmlMandate->donorId = $this->idFactory->createId($value);
                })
            )
        );

        $xmlMandate->payerNumber = $inputReader->readOptionalInput(
            self::OPTION_PAYER_NUMBER,
            $xmlMandate->payerNumber,
            new Validator\PayerNumberValidator
        );

        $inputReader->readOptionalInput(
            self::OPTION_ACCOUNT,
            $xmlMandate->account->prettyprint(),
            new Validator\ValidatorCollection(
                new Validator\AccountValidator,
                new Validator\CallbackValidator(function (string $value) use (&$xmlMandate) {
                    $xmlMandate->account = $this->accountFactory->createAccount($value);
                })
            )
        );

        $xmlMandate->donationAmount = $this->moneyParser->parse(
            $inputReader->readOptionalInput(
                self::OPTION_AMOUNT,
                $this->moneyFormatter->format($xmlMandate->donationAmount),
                new Validator\ValidatorCollection(
                    new Validator\NotEmptyValidator,
                    new Validator\NumericValidator
                )
            ),
            'SEK'
        );

        $xmlMandate->name = $inputReader->readOptionalInput(
            self::OPTION_NAME,
            $xmlMandate->name,
            new Validator\ValidatorCollection(
                new Validator\StringValidator,
                new Validator\NotEmptyValidator
            )
        );

        $xmlMandate->address['line1'] = $inputReader->readOptionalInput(
            self::OPTION_ADDRESS1,
            $xmlMandate->address['line1'],
            new Validator\StringValidator
        );

        $xmlMandate->address['line2'] = $inputReader->readOptionalInput(
            self::OPTION_ADDRESS2,
            $xmlMandate->address['line2'],
            new Validator\StringValidator
        );

        $xmlMandate->address['line3'] = $inputReader->readOptionalInput(
            self::OPTION_ADDRESS3,
            $xmlMandate->address['line3'],
            new Validator\StringValidator
        );

        $xmlMandate->address['postalCode'] = $inputReader->readOptionalInput(
            self::OPTION_POSTAL_CODE,
            $xmlMandate->address['postalCode'],
            new Validator\PostalCodeValidator
        );

        $xmlMandate->address['postalCity'] = $inputReader->readOptionalInput(
            self::OPTION_POSTAL_CITY,
            $xmlMandate->address['postalCity'],
            new Validator\StringValidator
        );

        $xmlMandate->email = $inputReader->readOptionalInput(
            self::OPTION_EMAIL,
            $xmlMandate->email,
            new Validator\EmailValidator
        );

        $xmlMandate->phone = $inputReader->readOptionalInput(
            self::OPTION_PHONE,
            $xmlMandate->phone,
            new Validator\PhoneValidator
        );

        $xmlMandate->comment = $inputReader->readOptionalInput(
            self::OPTION_COMMENT,
            $xmlMandate->comment,
            new Validator\StringValidator
        );

        foreach ($xmlMandate->attributes as $attrKey => $attrValue) {
            $xmlMandate->attributes[$attrKey] =
                $inputReader->readOptionalInput("attribute.$attrKey", $attrValue, new Validator\StringValidator);
        }
    }

    private function storeMandate(Xml\XmlMandate $xmlMandate): void
    {
        $this->commandBus->handle(
            new CommandBus\AddDonor(
                new NewDonor(
                    MandateSources::MANDATE_SOURCE_ONLINE_FORM,
                    $xmlMandate->payerNumber,
                    $xmlMandate->account,
                    $xmlMandate->donorId,
                    $xmlMandate->donationAmount
                )
            )
        );

        $donor = $this->donorRepository->requireByPayerNumber($xmlMandate->payerNumber);

        $this->commandBus->handle(
            new CommandBus\UpdateState($donor, NewMandate::getStateId(), 'Mandate added from xml')
        );

        $this->commandBus->handle(new CommandBus\UpdateName($donor, $xmlMandate->name));

        $this->commandBus->handle(new CommandBus\UpdatePostalAddress($donor, new PostalAddress(
            $xmlMandate->address['line1'],
            $xmlMandate->address['line2'],
            $xmlMandate->address['line3'],
            $xmlMandate->address['postalCode'],
            $xmlMandate->address['postalCity']
        )));

        $this->commandBus->handle(new CommandBus\UpdateEmail($donor, $xmlMandate->email));

        $this->commandBus->handle(new CommandBus\UpdatePhone($donor, $xmlMandate->phone));

        $this->commandBus->handle(new CommandBus\UpdateComment($donor, $xmlMandate->comment));

        foreach ($xmlMandate->attributes as $attrKey => $attrValue) {
            $this->commandBus->handle(new CommandBus\UpdateAttribute($donor, $attrKey, $attrValue));
        }
    }
}
