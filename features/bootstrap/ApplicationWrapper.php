<?php

declare(strict_types = 1);

use Symfony\Component\Finder\Finder;

/**
 * Wrapper around an application setup
 */
class ApplicationWrapper
{
    /**
     * @var string Full path to directory where test data is stored
     */
    private $directory;

    /**
     * @var string Path to giroapp user directory
     */
    private $userDir;

    /**
     * @var string Path to executable
     */
    private $executable;

    /**
     * @var callable
     */
    private $debugDump;

    public function __construct(string $executable, bool $debug)
    {
        $this->directory = sys_get_temp_dir() . '/giroapp_acceptance_tests_' . microtime();
        mkdir($this->directory);
        $this->userDir = $this->directory . '/giroapp_path';
        mkdir($this->userDir);
        $this->executable = realpath(getcwd() . '/' . $executable);

        $this->createIniFile(
            file_get_contents(__DIR__ . '/../../giroapp.ini.dist')
            . "\norg_bgc_nr = 111111\norg_bg = 58056201\norg_id = 835000-0892"
        );

        putenv("GIROAPP_INI={$this->userDir}/giroapp.ini");

        if ($debug) {
            $this->debugDump = function (string $str, string $pre = '') {
                foreach (explode(PHP_EOL, $str) as $line) {
                    if (!empty($line)) {
                        echo "$pre $line\n";
                    }
                }
            };
        } else {
            $this->debugDump = function () {
            };
        }
    }

    public function __destruct()
    {
        if (is_dir($this->directory)) {
            exec("rm -rf {$this->directory}");
        }
    }

    public function __call(string $command , array $arguments): Result
    {
        return $this->executeVerbose("$command " . implode(' ', $arguments));
    }

    public function executeVerbose(string $command): Result
    {
        return $this->execute("$command -vvv");
    }

    public function execute(string $command): Result
    {
        ($this->debugDump)($command, '$');

        $process = proc_open(
            "{$this->executable} $command --no-interaction --no-ansi",
            [
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ],
            $pipes,
            $this->directory
        );

        $output = stream_get_contents($pipes[1]);
        $errorOutput = stream_get_contents($pipes[2]);

        ($this->debugDump)($output, '>');
        ($this->debugDump)($errorOutput, 'error:');

        fclose($pipes[1]);
        fclose($pipes[2]);

        $returnCode = proc_close($process);

        return new Result($returnCode, $output, $errorOutput);
    }

    public function createIniFile(string $content): void
    {
        file_put_contents("{$this->userDir}/giroapp.ini", $content);
    }

    public function createFile(string $content): string
    {
        $filename = uniqid();
        file_put_contents("{$this->directory}/$filename", $content);

        return $filename;
    }

    public function createPlugin(string $content): void
    {
        mkdir($this->userDir . '/plugins');
        file_put_contents(
            $this->userDir . '/plugins/' . uniqid() . '.php',
            "<?php $content"
        );
    }

    public function getLastExportedFile(): string
    {
        $splFileInfo = null;

        foreach ((new Finder)->files()->in($this->userDir . '/var/exports')->sortByName() as $splFileInfo) {
        }

        return $splFileInfo ? $splFileInfo->getContents() : '';
    }
}
