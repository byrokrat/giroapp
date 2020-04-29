<?php

declare(strict_types = 1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use byrokrat\giroapp\Domain\MandateSources;

class FeatureContext implements Context
{
    const DEFAULT_DONOR_ROW = [
        'source' => MandateSources::MANDATE_SOURCE_PAPER,
        'payer-number' => '1',
        'state' => 'ACTIVE',
        'account' => '50001111116',
        'id' => '8203232775',
        'name' => 'name',
        'email' => 'email@host.com',
        'phone' => '1234',
        'amount' => '0',
        'comment' => 'comment'
    ];

    /**
     * @var ApplicationWrapper
     */
    private $app;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var string
     */
    private $executable;

    /**
     * @var Result Result from the last app invocation
     */
    private $result;

    public function __construct(bool $debug, string $executable)
    {
        $this->debug = $debug;
        $this->executable = $executable;
    }

    /**
     * @Given an executable
     */
    public function anExecutable()
    {
        $this->app = new ApplicationWrapper($this->executable, $this->debug);
    }

    /**
     * @Given a fresh installation
     */
    public function aFreshInstallation(): void
    {
        $this->anExecutable();

        $this->app->createIniFile(
            file_get_contents(__DIR__ . '/../../giroapp.ini.dist')
            . "\norg_bgc_nr = 111111\norg_bg = 58056201\norg_id = 835000-0892"
        );
    }

    /**
     * @Given a configuration file:
     */
    public function aConfigurationFile(PyStringNode $ini)
    {
        $this->app->createIniFile(
            file_get_contents(__DIR__ . '/../../giroapp.ini.dist')
            . "\n"
            . (string)$ini
        );
    }

    /**
     * @Given there are donors:
     */
    public function thereAreDonors(TableNode $table): void
    {
        foreach ($table->getHash() as $row) {
            $row = array_merge(self::DEFAULT_DONOR_ROW, $row);

            $this->iRun(sprintf(
                'add --source %s --payer-number %s --account %s --id %s --name %s --email %s --phone %s --amount %s --comment %s',
                $row['source'],
                $row['payer-number'],
                $row['account'],
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone'],
                $row['amount'],
                $row['comment']
            ));

            $this->thereIsNoError();

            $this->iRun(sprintf('edit-state %s --new-state %s', $row['payer-number'], $row['state']));

            $this->thereIsNoError();
        }
    }

    /**
     * @Given a plugin:
     */
    public function aPlugin(PyStringNode $content): void
    {
        $this->app->createPlugin((string)$content);
    }

    /**
     * @Given a file named :filename:
     */
    public function aFileNamed($filename, PyStringNode $content): void
    {
        $this->app->renameFile(
            $this->app->createFile((string)$content),
            $filename
        );
    }

    /**
     * @When I run :command
     */
    public function iRun($command): void
    {
        $this->result = $this->app->execute($command);
    }

    /**
     * @When i run raw command :command
     */
    public function iRunRawCommand($command)
    {
        $this->result = $this->app->executeRaw($command);
    }

    /**
     * @When I import:
     */
    public function iImport(PyStringNode $content): void
    {
        $this->result = $this->app->import(
            $this->app->createFile((string)$content)
        );
    }

    /**
     * @When I import using STDIN:
     */
    public function iImportUsingStdin(PyStringNode $content)
    {
        $this->result = $this->app->executeRaw("echo '$content' | " . $this->app::EXECUTABLE_PLACEHOLDER . " import");
    }

    /**
     * @Then there is no error
     */
    public function thereIsNoError(): void
    {
        if ($this->result->isError()) {
            throw new \Exception("Error: {$this->result->getErrorOutput()}");
        }
    }

    /**
     * @Then I get an error
     */
    public function iGetAnError(): void
    {
        if (!$this->result->isError()) {
            throw new \Exception('App invocation should result in an error');
        }
    }

    /**
     * @Then I get a :error error
     */
    public function iGetAError($error)
    {
        $expectedCode = constant("byrokrat\giroapp\Exception::$error");

        if ($expectedCode != $this->result->getReturnCode()) {
            throw new \Exception(sprintf(
                'Expected return code %s (%s), found %s',
                $expectedCode,
                $error,
                $this->result->getReturnCode()
            ));
        }
    }

    /**
     * @Then the database contains donor :donor
     */
    public function theDatabaseContainsDonor($donor)
    {
        $this->result = $this->app->show("$donor --format=json");
        $this->thereIsNoError();
    }

    /**
     * @Then the database contains donor :donor with :field matching :expected
     */
    public function theDatabaseContainsDonorWithMatching($donor, $field, $expected): void
    {
        $this->theDatabaseContainsDonor($donor);
        $data = json_decode($this->result->getOutput(), true);

        if (!isset($data[$field])) {
            throw new \Exception("Database field $field does not exist");
        }

        $current = str_replace("\n", '', print_r($data[$field] ?? '', true));

        if ($current != $expected) {
            throw new \Exception("Unable to find $field: $expected in database (found: $current)");
        }
    }

    /**
     * @Then the database contains donor :donor with attribute :attr matching :expected
     */
    public function theDatabaseContainsDonorWithAttributeMatching($donor, $attr, $expected): void
    {
        $this->theDatabaseContainsDonor($donor);
        $data = json_decode($this->result->getOutput(), true);
        $attributes = $data['attributes'] ?? [];
        if (!isset($attributes[$attr]) || $attributes[$attr] != $expected) {
            throw new \Exception("Unable to find attribute $attr: $expected in database");
        }
    }

    /**
     * @Then the output matches:
     */
    public function theOutputMatches(PyStringNode $string): void
    {
        $this->multilinePregMatch(
            explode("\n", (string)$string),
            explode("\n", $this->result->getOutput())
        );
    }

    /**
     * @Then the output contains a line like :regexp
     */
    public function theOutputContainsALineLike($regexp): void
    {
        $output = explode("\n", $this->result->getOutput());

        foreach ($output as $line) {
            if (preg_match($regexp, $line)) {
                return;
            }
        }

        throw new \Exception("Unable to find $regexp in {$this->result->getOutput()}");
    }

    /**
     * @Then the output contains :string
     */
    public function theOutputContains($string): void
    {
        if (!preg_match("/$string/i", $this->result->getOutput())) {
            throw new \Exception("Unable to find $string in output {$this->result->getOutput()}");
        }
    }

    /**
     * @Then the output does not contain :string
     */
    public function theOutputDoesNotContain($string): void
    {
        if (preg_match("/$string/i", $this->result->getOutput())) {
            throw new \Exception("$string should not be in output");
        }
    }

    /**
     * @Then there is a file named :filename
     */
    public function thereIsAFileNamed(string $filename)
    {
        if (!$this->app->fileExists($filename)) {
            throw new \Exception("File '$filename' should exist but does not");
        }
    }

    private function multilinePregMatch(array $regexes, array $strings): void
    {
        if (count($regexes) != count($strings)) {
            $source = implode("\n", $strings);
            throw new \Exception("Not the same number of regexes as lines in '$source'");
        }

        foreach ($regexes as $lineNr => $regexp) {
            if (!preg_match("/^$regexp\s*$/", $strings[$lineNr])) {
                throw new \Exception("Unable to find '$regexp' in '{$strings[$lineNr]}'");
            }
        }
    }
}
