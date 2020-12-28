<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DriverFactoryCollection;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use PhpSpec\ObjectBehavior;

class DriverFactoryCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DriverFactoryCollection::class);
    }

    function it_can_add_driver_factories(DriverFactoryInterface $driverFactory)
    {
        $driverFactory->getDriverName()->willReturn('foobar');
        $this->addDriverFactory($driverFactory);
        $this->getDriverFactory('foobar')->shouldReturn($driverFactory);
    }

    function it_can_get_driver_names(DriverFactoryInterface $driverFactory)
    {
        $driverFactory->getDriverName()->willReturn('foobar');
        $this->addDriverFactory($driverFactory);
        $this->getItemKeys()->shouldContain('foobar');
    }
}
