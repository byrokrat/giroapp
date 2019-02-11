<?php

declare(strict_types = 1);

use byrokrat\giroapp\Config\ArrayRepository;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\IniRepository;
use Symfony\Component\Finder\Finder;

class ApplicationWrapper
{
    /** @var string */
    private $cwd;

    /** @var string */
    private $iniFilename;

    /** @var string */
    private $executable;

    /** @var callable */
    private $debugDump;

    /** @var ConfigManager */
    private $configs;

    public function __construct(string $executable, bool $debug)
    {
        $this->cwd = sys_get_temp_dir() . '/giroapp_test_' . microtime();
        mkdir($this->cwd);
        $baseDir = "{$this->cwd}/giroapp";
        mkdir($baseDir);
        $this->configs = new ConfigManager(new ArrayRepository(['base_dir' => $baseDir]));
        $this->iniFilename = "$baseDir/giroapp.ini";
        putenv("GIROAPP_INI={$this->iniFilename}");

        $this->createIniFile(
            file_get_contents(__DIR__ . '/../../giroapp.ini.dist')
            . "\norg_bgc_nr = 111111\norg_bg = 58056201\norg_id = 835000-0892"
        );

        $this->executable = realpath(getcwd() . '/' . $executable);

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
        if (is_dir($this->cwd)) {
            exec("rm -rf {$this->cwd}");
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
            $this->cwd
        );

        $output = stream_get_contents($pipes[1]);
        $errorOutput = stream_get_contents($pipes[2]);

        ($this->debugDump)($output, '>');
        ($this->debugDump)($errorOutput, 'err:');

        fclose($pipes[1]);
        fclose($pipes[2]);

        $returnCode = proc_close($process);

        return new Result($returnCode, $output, $errorOutput);
    }

    public function createIniFile(string $ini): void
    {
        $this->configs->loadRepository(new IniRepository($ini));
        file_put_contents($this->iniFilename, $ini);
    }

    public function createFile(string $content): string
    {
        $filename = uniqid();
        file_put_contents("{$this->cwd}/$filename", $content);

        return $filename;
    }

    public function createPlugin(string $content): void
    {
        mkdir($this->configs->getConfigValue('plugins_dir'));
        file_put_contents(
            $this->configs->getConfigValue('plugins_dir') . DIRECTORY_SEPARATOR . uniqid() . '.php',
            "<?php $content"
        );
    }

    public function getLastExportedFile(): string
    {
        $splFileInfo = null;

        $exports = (new Finder)->files()->in($this->configs->getConfigValue('exports_dir'))->sortByName();

        foreach ($exports as $splFileInfo) {
        }

        return $splFileInfo ? $splFileInfo->getContents() : '';
    }
}
