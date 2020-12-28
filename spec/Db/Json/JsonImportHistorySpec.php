<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\Json\JsonImportHistory;
use byrokrat\giroapp\Db\Json\JsonDriverFactory;
use spec\byrokrat\giroapp\Db\ImportHistorySpecTrait;
use PhpSpec\ObjectBehavior;

class JsonImportHistorySpec extends ObjectBehavior
{
    use ImportHistorySpecTrait;

    private $testDirectory;

    function let()
    {
        $this->testDirectory = sys_get_temp_dir() . '/giroapp_JsonImportHistorySpec_' . microtime();

        $this->beConstructedThrough(function () {
            return (new JsonDriverFactory())->createDriver($this->testDirectory)->getImportHistory(
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
        $this->shouldHaveType(JsonImportHistory::class);
    }
}
