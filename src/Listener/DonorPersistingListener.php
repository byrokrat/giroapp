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

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorEvent;

/**
 * Manipulate donor persistent storage
 */
class DonorPersistingListener
{
    /**
     * @var DonorRepositoryInterface
     */
    private $donorRepository;

    public function __construct(DonorRepositoryInterface $donorRepository)
    {
        $this->donorRepository = $donorRepository;
    }

    public function onDonorAdded(DonorEvent $event): void
    {
        $this->donorRepository->addNewDonor($event->getDonor());
    }

    public function onDonorUpdated(DonorEvent $event): void
    {
        $donor = $event->getDonor();

        $this->donorRepository->updateDonorName($donor, $donor->getName());
        $this->donorRepository->updateDonorState($donor, $donor->getState());
        $this->donorRepository->updateDonorPayerNumber($donor, $donor->getPayerNumber());
        $this->donorRepository->updateDonorAmount($donor, $donor->getDonationAmount());
        $this->donorRepository->updateDonorAddress($donor, $donor->getPostalAddress());
        $this->donorRepository->updateDonorEmail($donor, $donor->getEmail());
        $this->donorRepository->updateDonorPhone($donor, $donor->getPhone());
        $this->donorRepository->updateDonorComment($donor, $donor->getComment());

        foreach ($donor->getAttributes() as $key => $value) {
            $this->donorRepository->setDonorAttribute($donor, $key, $value);
        }
    }
}
