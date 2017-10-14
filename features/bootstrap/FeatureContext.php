<?php

declare(strict_types = 1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

class FeatureContext implements Context
{
    const DEFAULT_DONOR_ROW = [
        'payer-number' => '1',
        'state' => 'ACTIVE',
        'account' => '50001111116',
        'id' => '8203232775',
        'name' => 'name',
        'email' => 'email',
        'phone' => 'phone',
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
        $this->result = $this->app->init();
    }

    /**
     * @Given an orgnization :name with bankgiro :bg and bgc customer number :custNr
     */
    public function anOrgnizationWithBankgiroAndBgcCustomerNumber($name, $bg, $custNr)
    {
        $this->result = $this->app->init("--org-name='$name' --bankgiro='$bg' --bgc-customer-number='$custNr'");
    }

    /**
     * @Given an orgnization :name with bankgiro :bg and organization id :id
     */
    public function anOrgnizationWithBankgiroAndOrganizationId($name, $bg, $id)
    {
        $this->result = $this->app->init("--org-name='$name' --bankgiro='$bg' --org-number='$id'");
    }

    /**
     * @Given the explicit payer number strategy
     */
    public function theExplicitPayerNumberStrategy()
    {
        $this->result = $this->app->init('--payer-number-strategy explicit');
    }

    /**
     * @Given the ID payer number strategy
     */
    public function theIdPayerNumberStrategy()
    {
        $this->result = $this->app->init('--payer-number-strategy id');
    }

    /**
     * @Given there are donors:
     */
    public function thereAreDonors(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $row = array_merge(self::DEFAULT_DONOR_ROW, $row);

            $this->iRun(sprintf(
                'add --payer-number %s --account %s --id %s --name %s --email %s --phone %s --amount %s --comment %s',
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
