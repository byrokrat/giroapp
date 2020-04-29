<?php

declare(strict_types = 1);

use byrokrat\giroapp\Config\ArrayRepository;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\IniRepository;

class ApplicationWrapper
{
    const EXECUTABLE_PLACEHOLDER = '@giroapp@';
    const GIROAPP_INSTALL_PATH =  __DIR__ . '/../../';

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
            exec("rm -rf '{$this->cwd}'");
        }
    }

    public function __call(string $command, array $arguments): Result
    {
        return $this->execute($command . ' ' . implode(' ', $arguments));
    }

    public function execute(string $command): Result
    {
        return $this->executeRaw(self::EXECUTABLE_PLACEHOLDER . ' ' . $command);
    }

    public function executeRaw(string $command): Result
    {
        $command = str_replace(self::EXECUTABLE_PLACEHOLDER, $this->executable, $command)
            . ' -v --no-interaction --no-ansi';

        ($this->debugDump)($command, '$');

        $env = getenv();
        $env['GIROAPP_INI'] = $this->iniFilename;
        $env['GIROAPP_INSTALL_PATH'] = self::GIROAPP_INSTALL_PATH;

        $process = proc_open(
            $command,
            [
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ],
            $pipes,
            $this->cwd,
            $env
        );

        $output = stream_get_contents($pipes[1]);
        $errorOutput = stream_get_contents($pipes[2]);

        ($this->debugDump)($output, '>');
        ($this->debugDump)($errorOutput, ':');

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

    public function renameFile(string $oldName, string $newName): void
    {
        rename("{$this->cwd}/$oldName", "{$this->cwd}/$newName");
    }

    public function createPlugin(string $content): void
    {
        mkdir($this->configs->getConfigValue('plugins_dir'));
        file_put_contents(
            $this->configs->getConfigValue('plugins_dir') . DIRECTORY_SEPARATOR . uniqid() . '.php',
            "<?php $content"
        );
    }

    public function fileExists(string $filename): bool
    {
        return file_exists("{$this->cwd}/$filename");
    }
}
