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
        Console\AddConsole $addConsole,
        Console\EditConsole $editConsole,
        Console\EditStateConsole $editStateConsole,
        Console\ExportConsole $expotConsole,
        Console\ImportConsole $importConsole,
        Console\LsConsole $lsConsole,
        Console\PauseConsole $pauseConsole,
        Console\RemoveConsole $removeConsole,
        Console\RevokeConsole $revokeConsole,
        Console\ShowConsole $showConsole,
        Console\StatusConsole $statusConsole,
        Db\Json\JsonDriverFactory $jsonDriverFactory,
        Filter\ActiveFilter $activeFilter,
        Filter\InactiveFilter $incativeFilter,
        Filter\ExportableFilter $exportableFilter,
        Filter\ErrorFilter $errorFilter,
        Filter\PausedFilter $pausedFilter,
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
        State\Active $activeState,
        State\Error $errorState,
        State\Inactive $inactiveState,
        State\NewMandate $newMandateState,
        State\NewDigitalMandate $newDigitalMandateState,
        State\MandateSent $mandateSentState,
        State\MandateApproved $mandateApprovedState,
        State\RevokeMandate $revokeMandateState,
        State\RevocationSent $revocationSentState,
        State\PauseMandate $pauseMandateState,
        State\PauseSent $pauseSentState,
        State\Paused $pausedState
    ) {
        parent::__construct(...func_get_args());
    }
}
