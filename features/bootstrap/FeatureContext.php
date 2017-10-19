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
     * @var Result Result from the last app invocation
     */
    private $result;

    /**
     * @Given a fresh installation
     */
    public function aFreshInstallation()
    {
        $this->app = new ApplicationWrapper;
        $this->iRun("init --org-name foo --org-number 8350000892 --bankgiro 58056201 --bgc-customer-number 123456");
    }

    /**
     * @Given a payee with :setting :value
     */
    public function aPayeeWith($setting, $value)
    {
        $this->iRun("init --$setting='$value'");
    }

    /**
     * @Given there are donors:
     */
    public function thereAreDonors(TableNode $table)
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
    public function aPlugin(PyStringNode $content)
    {
        $this->app->createPlugin((string)$content);
    }

    /**
     * @When I run :command
     */
    public function iRun($command)
    {
        $this->result = $this->app->execute($command);
    }

    /**
     * @When I import:
     */
    public function iImport(PyStringNode $content)
    {
        $this->result = $this->app->import(
            $this->app->createFile((string)$content)
        );
    }

    /**
     * @Then there is no error
     */
    public function thereIsNoError()
    {
        if ($this->result->isError()) {
            throw new \Exception("Error: {$this->result->getErrorOutput()}");
        }
    }

    /**
     * @Then I get an error
     */
    public function iGetAnError()
    {
        if (!$this->result->isError()) {
            throw new \Exception('App invocation should result in an error');
        }
    }

    /**
     * @Then the database contains donor :donor with :field matching :expected
     */
    public function theDatabaseContainsDonorWithMatching($donor, $field, $expected)
    {
        $this->iRun("show $donor --$field");
        $this->thereIsNoError();
        $this->theOutputContains($expected);
    }

    /**
     * @Then the output matches:
     */
    public function theOutputMatches(PyStringNode $string)
    {
        $output = explode("\n", $this->result->getOutput());
        $regexes = explode("\n", (string)$string);

        if (count($output) != count($regexes)) {
            throw new \Exception("Not the same number of regexes as lines in output '{$this->result->getOutput()}'");
        }

        foreach ($regexes as $lineNr => $regexp) {
            if (!preg_match("/^$regexp\s*$/", $output[$lineNr])) {
                throw new \Exception("Unable to find '$regexp' in '{$output[$lineNr]}'");
            }
        }
    }

    /**
     * @Then the output matches :regexp
     */
    public function theOutputMatches2($regexp)
    {
        $output = trim($this->result->getOutput());
        if (!preg_match($regexp, $output)) {
            throw new \Exception("Unable to find $regexp in {$output}");
        }
    }

    /**
     * @Then the output contains :string
     */
    public function theOutputContains($string)
    {
        if (!preg_match("/$string/i", $this->result->getOutput())) {
            throw new \Exception("Unable to find $string in output {$this->result->getOutput()}");
        }
    }

    /**
     * @Then the output does not contain :string
     */
    public function theOutputDoesNotContain($string)
    {
        if (preg_match("/$string/i", $this->result->getOutput())) {
            throw new \Exception("$string should not be in output");
        }
    }
}
