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

    public function __construct(string $executable = '')
    {
        $this->directory = sys_get_temp_dir() . '/giroapp_acceptance_tests_' . microtime();
        mkdir($this->directory);
        $this->userDir = $this->directory . '/giroapp_path';
        mkdir($this->userDir);
        putenv("GIROAPP_PATH={$this->userDir}");
        $this->executable = $executable ?: realpath(getcwd() . '/bin/giroapp');
    }

    public function __destruct()
    {
        if (is_dir($this->directory)) {
            exec("rm -rf {$this->directory}");
        }
    }

    public function __call(string $command , array $arguments): Result
    {
        return $this->execute("$command " . implode(' ', $arguments));
    }

    public function execute(string $command): Result
    {
        $process = proc_open(
            "{$this->executable} $command --no-interaction --no-ansi -vvv",
            [
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ],
            $pipes,
            $this->directory
        );

        $output = stream_get_contents($pipes[1]);
        $errorOutput = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $returnCode = proc_close($process);

        return new Result($returnCode, $output, $errorOutput);
    }

    public function createFile(string $content): string
    {
        $filename = uniqid();
        file_put_contents("{$this->directory}/$filename", $content);

        return $filename;
    }

    public function createPlugin(string $content): void
    {
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
