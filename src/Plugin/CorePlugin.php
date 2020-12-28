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

declare(strict_types=1);

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Console;
use byrokrat\giroapp\Db;
use byrokrat\giroapp\Filter;
use byrokrat\giroapp\Formatter;
use byrokrat\giroapp\Sorter;

final class CorePlugin extends Plugin
{
    public function __construct(
        Console\AddConsole $addConsole,
        Console\ConfConsole $confConsole,
        Console\DeleteAttributeConsole $deleteAttributeConsole,
        Console\EditConsole $editConsole,
        Console\EditAmountConsole $editAmountConsole,
        Console\EditPayerNumberConsole $editPayerNumberConsole,
        Console\EditStateConsole $editStateConsole,
        Console\ExportConsole $expotConsole,
        Console\HistoryConsole $historyConsole,
        Console\ImportConsole $importConsole,
        Console\ImportXmlMandatesConsole $importXmlMandatesConsole,
        Console\InitConsole $initConsole,
        Console\ListConsole $listConsole,
        Console\PauseConsole $pauseConsole,
        Console\RemoveConsole $removeConsole,
        Console\RevokeConsole $revokeConsole,
        Console\ShowConsole $showConsole,
        Console\StatusConsole $statusConsole,
        Db\Json\JsonDriverFactory $jsonDriverFactory,
        Filter\ActiveFilter $activeFilter,
        Filter\RevokedFilter $revokedFilter,
        Filter\ExportableFilter $exportableFilter,
        Filter\ErrorFilter $errorFilter,
        Filter\PausedFilter $pausedFilter,
        Filter\AwaitingResponseFilter $awaitingFilter,
        Formatter\ListFormatter $listFormatter,
        Formatter\CsvFormatter $csvFormatter,
        Formatter\HumanFormatter $humanFormatter,
        Formatter\JsonFormatter $jsonFormatter,
        Formatter\MailStringFormatter $mailStringFormatter,
        Sorter\NullSorter $nullSorter,
        Sorter\NameSorter $nameSorter,
        Sorter\StateSorter $stateSorter,
        Sorter\PayerNumberSorter $payerSorter,
        Sorter\AmountSorter $amountSorter,
        Sorter\CreatedSorter $createdSorter,
        Sorter\UpdatedSorter $updatedSorter
    ) {
        parent::__construct(...func_get_args());
    }
}
