<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\Json\JsonDonorRepository;
use byrokrat\giroapp\Db\Json\JsonDriverFactory;
use spec\byrokrat\giroapp\Db\DonorRepositorySpecTrait;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonDonorRepositorySpec extends ObjectBehavior
{
    use DonorRepositorySpecTrait;

    private $testDirectory;

    function let()
    {
        $this->testDirectory = sys_get_temp_dir() . '/giroapp_JsonDonorRepositorySpec_' . microtime();

        $this->beConstructedThrough(function () {
            return (new JsonDriverFactory)->createDriver($this->testDirectory)->getDonorRepository(
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
        $this->shouldHaveType(JsonDonorRepository::CLASS);
    }
}
