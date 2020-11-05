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

namespace byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\NewMandate;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Exception\DonorAlreadyExistsException;
use byrokrat\giroapp\Xml\XmlMandateCompiler;

final class ImportXmlMandateFileHandler
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty,
        DependencyInjection\DonorRepositoryProperty;

    /** @var XmlMandateCompiler */
    private $xmlMandateCompiler;

    public function __construct(XmlMandateCompiler $xmlMandateCompiler)
    {
        $this->xmlMandateCompiler = $xmlMandateCompiler;
    }

    public function handle(ImportXmlMandateFile $command): void
    {
        $this->dispatcher->dispatch(
            new Event\InfoEvent(
                "<info>Importing mandates from {$command->getFile()->getFilename()}</info>",
                ['filename' => $command->getFile()->getFilename()]
            )
        );

        foreach ($this->xmlMandateCompiler->compileFile($command->getFile()) as $xmlMandate) {
            try {
                $this->commandBus->handle(
                    new AddDonor(
                        new NewDonor(
                            MandateSources::MANDATE_SOURCE_ONLINE_FORM,
                            $xmlMandate->payerNumber,
                            $xmlMandate->account,
                            $xmlMandate->donorId,
                            $xmlMandate->donationAmount
                        )
                    )
                );
            } catch (DonorAlreadyExistsException $exception) {
                // Dispatching error means that failure can be picked up in an outer layer
                $this->dispatcher->dispatch(
                    new Event\ErrorEvent(
                        $exception->getMessage(),
                        [
                            'payer_number' => $xmlMandate->payerNumber,
                            'donor_id' => $xmlMandate->donorId->format('CS-sk')
                        ]
                    )
                );

                continue;
            }

            $donor = $this->donorRepository->requireByPayerNumber($xmlMandate->payerNumber);

            $this->commandBus->handle(
                new UpdateState($donor, NewMandate::getStateId(), 'Mandate added from xml')
            );

            $this->commandBus->handle(new UpdateName($donor, $xmlMandate->name));

            $this->commandBus->handle(new UpdatePostalAddress($donor, new PostalAddress(
                $xmlMandate->address['line1'],
                $xmlMandate->address['line2'],
                $xmlMandate->address['line3'],
                $xmlMandate->address['postalCode'],
                $xmlMandate->address['postalCity']
            )));

            $this->commandBus->handle(new UpdateEmail($donor, $xmlMandate->email));

            $this->commandBus->handle(new UpdatePhone($donor, $xmlMandate->phone));

            $this->commandBus->handle(new UpdateComment($donor, $xmlMandate->comment));

            foreach ($xmlMandate->attributes as $attrKey => $attrValue) {
                $this->commandBus->handle(new UpdateAttribute($donor, $attrKey, $attrValue));
            }
        }

        $this->dispatcher->dispatch(new Event\XmlMandateFileImported($command->getFile()));
    }
}
