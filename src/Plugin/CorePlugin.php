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
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Console;
use byrokrat\giroapp\Db;
use byrokrat\giroapp\Filter;
use byrokrat\giroapp\Formatter;
use byrokrat\giroapp\Sorter;
use byrokrat\giroapp\State;

final class CorePlugin extends Plugin
{
    public function __construct(
        Console\AddCommand $addCommand,
        Console\EditCommand $editCommand,
        Console\ExportCommand $expotCommand,
        Console\ImportCommand $importCommand,
        Console\LsCommand $lsCommand,
        Console\MigrateCommand $migrateCommand,
        Console\PauseCommand $pauseCommand,
        Console\PurgeCommand $purgeCommand,
        Console\RemoveCommand $removeCommand,
        Console\RevokeCommand $revokeCommand,
        Console\ShowCommand $showCommand,
        Console\StatusCommand $statusCommand,
        Console\ValidateCommand $validateCommand,
        Db\Json\JsonDriverFactory $jsonDriverFactory,
        Filter\ActiveFilter $activeFilter,
        Filter\InactiveFilter $incativeFilter,
        Filter\ExportableFilter $exportableFilter,
        Filter\ErrorFilter $errorFilter,
        Filter\PausedFilter $pausedFilter,
        Filter\PurgeableFilter $purgeableFilter,
        Filter\AwaitingResponseFilter $awaitingFilter,
        Formatter\ListFormatter $listFormatter,
        Formatter\CsvFormatter $csvFormatter,
        Formatter\HumanFormatter $humanFormatter,
        Formatter\JsonFormatter $jsonFormatter,
        Sorter\NullSorter $nullSorter,
        Sorter\NameSorter $nameSorter,
        Sorter\StateSorter $stateSorter,
        Sorter\PayerNumberSorter $payerSorter,
        Sorter\AmountSorter $amountSorter,
        Sorter\CreatedSorter $createdSorter,
        Sorter\UpdatedSorter $updatedSorter,
        State\ActiveState $activeState,
        State\ErrorState $errorState,
        State\InactiveState $inactiveState,
        State\NewMandateState $newMandateState,
        State\NewDigitalMandateState $newDigitalMandateState,
        State\MandateSentState $mandateSentState,
        State\MandateApprovedState $mandateApprovedState,
        State\RevokeMandateState $revokeMandateState,
        State\RevocationSentState $revocationSentState,
        State\PauseMandateState $pauseMandateState,
        State\PauseSentState $pauseSentState,
        State\PausedState $pausedState
    ) {
        parent::__construct(...func_get_args());
    }
}
