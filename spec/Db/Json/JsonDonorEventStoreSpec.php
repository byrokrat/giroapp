<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\Json\JsonDonorEventStore;
use byrokrat\giroapp\Db\Json\JsonDriverFactory;
use spec\byrokrat\giroapp\Db\DonorEventStoreSpecTrait;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonDonorEventStoreSpec extends ObjectBehavior
{
    use DonorEventStoreSpecTrait;

    private $testDirectory;

    function let()
    {
        $this->testDirectory = sys_get_temp_dir() . '/giroapp_JsonDonorEventStoreSpec_' . microtime();

        $this->beConstructedThrough(function () {
            return (new JsonDriverFactory)->createDriver($this->testDirectory)->getDonorEventStore(
                $this->getDriverEnvironment()
            );
        });
    }

    function letGo()
    {
        if (is_dir($this->testDirectory)) {
            exec("rm -rf '{$this->testDirectory}'");
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(JsonDonorEventStore::CLASS);
    }
}
