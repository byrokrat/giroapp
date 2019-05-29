<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Model\DonorFactory;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\State\Active;
use byrokrat\giroapp\State\Error;
use byrokrat\banking\AccountFactory;
use byrokrat\id\PersonalIdFactory;

trait DriverTestEnvironmentTrait
{
    /** @var DriverEnvironment */
    private $driverEnvironment;

    protected function getDriverEnvironment(): DriverEnvironment
    {
        $stateCollection = new StateCollection;
        $stateCollection->addState(new Active);
        $stateCollection->addState(new Error);

        if (!isset($this->driverEnvironment)) {
            $this->driverEnvironment = new DriverEnvironment(
                new SystemClock,
                new DonorFactory(
                    $stateCollection,
                    new AccountFactory,
                    new PersonalIdFactory
                )
            );
        }

        return $this->driverEnvironment;
    }
}
