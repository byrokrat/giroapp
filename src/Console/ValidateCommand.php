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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\OutputProperty;
use byrokrat\giroapp\Utils\Filesystem;
use JsonSchema\Validator;

/**
 * Command to validate database schema
 */
class ValidateCommand implements CommandInterface
{
    use OutputProperty;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var object
     */
    private $donorSchema;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param Filesystem $filesystem
     * @param object     $donorSchema
     * @param Validator  $validator
     */
    public function __construct(Filesystem $filesystem, $donorSchema, Validator $validator)
    {
        $this->filesystem = $filesystem;
        $this->donorSchema = $donorSchema;
        $this->validator = $validator;
    }

    public static function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('validate');
        $wrapper->setDescription('Validate database schema');
        $wrapper->setHelp('Validate that the database schema is up to date for all items');
    }

    public function execute(): void
    {
        $donorData = json_decode($this->filesystem->readFile('data/donors.json')->getContent());
        $this->validator->validate($donorData, $this->donorSchema);
        $errors = '';

        foreach ($this->validator->getErrors() as $error) {
            $errors .= sprintf("[%s] %s\n", $error['property'], $error['message']);
        }

        if ($errors) {
            throw new \RuntimeException("Donors.json does not validate\n\n$errors");
        }

        $this->output->writeln("<info>Donors.json is valid</info>");
    }
}
