<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Domain\DonorFactory;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\giroapp\Domain\State\StateCollection;
use byrokrat\giroapp\Domain\State\Active;
use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Money\SekNoSubunitMoneyFormatter;
use byrokrat\giroapp\Money\SekNoSubunitMoneyParser;
use byrokrat\banking\AccountFactory;
use byrokrat\id\PersonalIdFactory;

trait DriverTestEnvironmentTrait
{
    /** @var DriverEnvironment */
    private $driverEnvironment;

    protected function getDriverEnvironment(): DriverEnvironment
    {
        if (!isset($this->driverEnvironment)) {
            $stateCollection = new StateCollection;
            $stateCollection->addState(new Active);
            $stateCollection->addState(new Error);

            $this->driverEnvironment = new DriverEnvironment(
                new SystemClock,
                new DonorFactory(
                    $stateCollection,
                    new AccountFactory,
                    new PersonalIdFactory,
                    new SekNoSubunitMoneyParser
                ),
                new SekNoSubunitMoneyFormatter
            );
        }

        return $this->driverEnvironment;
    }
}
