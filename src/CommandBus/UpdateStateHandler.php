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
 * Copyright 2016-21 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\Exception\InvalidStateTransitionException;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\Workflow\Transition;

class UpdateStateHandler
{
    /** @var WorkflowInterface */
    private $workflow;

    public function __construct(WorkflowInterface $workflow)
    {
        $this->workflow = $workflow;
    }

    public function handle(UpdateState $command): void
    {
        $donor = $command->getDonor();

        $transitionId = $command->getTransitionId();

        if (!$this->workflow->can($donor, $transitionId)) {
            throw new InvalidStateTransitionException(sprintf(
                "Unable to perform transition '%s' on donor '%s' (possible values: '%s')",
                $transitionId,
                $donor->getMandateKey(),
                implode(
                    "', '",
                    array_map(
                        function (Transition $transition): string {
                            return $transition->getName();
                        },
                        $this->workflow->getEnabledTransitions($donor)
                    )
                )
            ));
        }

        $this->workflow->apply($donor, $transitionId, ['desc' => $command->getUpdateDescription()]);
    }
}
