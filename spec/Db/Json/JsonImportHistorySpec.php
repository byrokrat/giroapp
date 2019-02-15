<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\Json\JsonImportHistory;
use byrokrat\giroapp\Db\Json\JsonDriverFactory;
use byrokrat\giroapp\Db\ImportHistoryInterface;
use byrokrat\giroapp\Utils\SystemClock;
use spec\byrokrat\giroapp\Db\ImportHistorySpecTrait;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonImportHistorySpec extends ObjectBehavior
{
    use ImportHistorySpecTrait;

    private $testDirectory;

    public function __construct()
    {
        $this->testDirectory = sys_get_temp_dir() . '/giroapp_JsonImportHistorySpec_' . microtime();
    }

    public function __destruct()
    {
        if (is_dir($this->testDirectory)) {
            exec("rm -rf '{$this->testDirectory}'");
        }
    }

    function createImportHistory(): ImportHistoryInterface
    {
        return (new JsonDriverFactory(new SystemClock))->createDriver($this->testDirectory)->getImportHistory();
    }
}
