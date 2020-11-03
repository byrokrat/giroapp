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

use byrokrat\giroapp\Autogiro\AutogiroVisitor;
use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Exception\UnknownFileException;
use byrokrat\autogiro\Parser\ParserInterface;
use byrokrat\autogiro\Exception as AutogiroException;

final class ImportAutogiroFileHandler
{
    use DispatcherProperty;

    /** @var ParserInterface */
    private $parser;

    /** @var AutogiroVisitor */
    private $visitor;

    public function __construct(ParserInterface $parser, AutogiroVisitor $visitor)
    {
        $this->parser = $parser;
        $this->visitor = $visitor;
    }

    public function handle(ImportAutogiroFile $command): void
    {
        $this->dispatcher->dispatch(
            new Event\InfoEvent(
                "<info>Importing file {$command->getFile()->getFilename()}</info>",
                ['filename' => $command->getFile()->getFilename()]
            )
        );

        try {
            $this->parser->parse($command->getFile()->getContent())->accept($this->visitor);
        } catch (AutogiroException $e) {
            throw new UnknownFileException(
                sprintf(
                    "Unable to import '%s'. %s",
                    $command->getFile()->getFilename(),
                    $e->getMessage()
                )
            );
        }

        $this->dispatcher->dispatch(new Event\AutogiroFileImported($command->getFile()));
    }
}
