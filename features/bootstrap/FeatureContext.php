<?php

declare(strict_types = 1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use byrokrat\giroapp\Model\Donor;

class FeatureContext implements Context
{
    const DEFAULT_DONOR_ROW = [
        'source' => Donor::MANDATE_SOURCE_PAPER,
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
     * @var callable
     */
    private $debugDump;

    /**
     * @var Result Result from the last app invocation
     */
    private $result;

    public function __construct(bool $debug)
    {
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

    /**
     * @Given a fresh installation
     */
    public function aFreshInstallation(): void
    {
        $this->app = new ApplicationWrapper;
        $this->iRun("init --org-name foo --org-number 8350000892 --bankgiro 58056201 --bgc-customer-number 123456");
    }

    /**
     * @Given a payee with :setting :value
     */
    public function aPayeeWith($setting, $value): void
    {
        $this->iRun("init --$setting='$value'");
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

            $this->iRun(sprintf('edit %s --state %s', $row['payer-number'], $row['state']));

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
     * @When I run :command
     */
    public function iRun($command): void
    {
        $this->result = $this->app->execute($command);
        ($this->debugDump)($command, '$');
        ($this->debugDump)($this->result->getOutput(), '>');
        ($this->debugDump)($this->result->getErrorOutput(), 'error:');
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
     * @Then the database contains donor :donor with :field matching :expected
     */
    public function theDatabaseContainsDonorWithMatching($donor, $field, $expected): void
    {
        $this->iRun("show $donor --$field");
        $this->thereIsNoError();
        $this->theOutputContains($expected);
    }

    /**
     * @Then the exported file matches:
     */
    public function theExportedFileMatches(PyStringNode $string): void
    {
        $this->multilinePregMatch(
            explode("\n", (string)$string),
            explode("\n", $this->app->getLastExportedFile())
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
