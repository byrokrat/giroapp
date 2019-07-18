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

namespace byrokrat\giroapp\Db;

class DonorEventEntry
{
    /** @var string */
    private $mandateKey;

    /** @var string */
    private $type;

    /** @var \DateTimeImmutable */
    private $datetime;

    /** @var string[] */
    private $data;

    public function __construct(string $mandateKey, string $type, \DateTimeImmutable $datetime, array $data)
    {
        $this->mandateKey = $mandateKey;
        $this->type = $type;
        $this->datetime = $datetime;
        $this->data = $data;
    }

    /**
     * Key of referenced mandate
     */
    public function getMandateKey(): string
    {
        return $this->mandateKey;
    }

    /**
     * The type of event recorded
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Time of recording
     */
    public function getDateTime(): \DateTimeImmutable
    {
        return $this->datetime;
    }

    /**
     * @return string[] Type dependent event data
     */
    public function getData(): array
    {
        return $this->data;
    }
}
