<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Model\DonorFactory;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\State\ActiveState;
use byrokrat\giroapp\State\ErrorState;
use byrokrat\banking\AccountFactory;
use byrokrat\id\PersonalIdFactory;

trait DriverTestEnvironmentTrait
{
    /** @var DriverEnvironment */
    private $driverEnvironment;

    protected function getDriverEnvironment(): DriverEnvironment
    {
        $stateCollection = new StateCollection;
        $stateCollection->addState(new ActiveState);
        $stateCollection->addState(new ErrorState);

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
