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
        'state' => 'ActiveState',
        'mandate-source' => 'MANDATE_SOURCE_PAPER',
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
        $container = $this->app->getContainer();

        foreach ($table->getHash() as $row) {
            $row = array_merge(self::DEFAULT_DONOR_ROW, $row);

            $donor = $container->get('donor_builder')
                ->setMandateSource(constant("byrokrat\\giroapp\\Model\\Donor::{$row['mandate-source']}"))
                ->setPayerNumber($row['payer-number'])
                ->setId($container->get('id_factory')->create($row['id']))
                ->setAccount($container->get('account_factory')->createAccount($row['account']))
                ->setName($row['name'])
                ->setEmail($row['email'])
                ->setPhone($row['phone'])
                ->setDonationAmount(new byrokrat\amount\Currency\SEK($row['amount']))
                ->setComment($row['comment'])
                ->buildDonor();

            $stateClass = "byrokrat\\giroapp\\Model\\DonorState\\{$row['state']}";

            $donor->setState(new $stateClass);

            $container->get('donor_mapper')->save($donor);
            $container->get('db_handle')->commit();
        }
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
     * @Then the donor database contains:
     */
    public function theDonorDatabaseContains(TableNode $table)
    {
        $container = $this->app->getContainer();
        $container->get('db_donors_collection')->reset();

        foreach ($table->getHash() as $row) {
            foreach ($container->get('donor_mapper')->findAll() as $donor) {
                if (isset($row['mandate-source']) && $donor->getMandateSource() != constant("byrokrat\\giroapp\\Model\\Donor::{$row['mandate-source']}")) {
                    continue;
                }

                if (isset($row['payer-number']) && $donor->getPayerNumber() != $row['payer-number']) {
                    continue;
                }

                if (isset($row['mandate-key']) && $donor->getMandateKey() != $row['mandate-key']) {
                    continue;
                }

                if (isset($row['id']) && (string)$donor->getDonorId() != (string)$container->get('id_factory')->create($row['id'])) {
                    continue;
                }

                if (isset($row['account']) && !$donor->getAccount()->equals($container->get('account_factory')->createAccount($row['account']))) {
                    continue;
                }

                if (isset($row['name']) && $donor->getName() != $row['name']) {
                    continue;
                }

                if (isset($row['email']) && $donor->getEmail() != $row['email']) {
                    continue;
                }

                if (isset($row['phone']) && $donor->getPhone() != $row['phone']) {
                    continue;
                }

                if (isset($row['amount']) && !$donor->getDonationAmount()->equals(new byrokrat\amount\Currency\SEK($row['amount']))) {
                    continue;
                }

                if (isset($row['comment']) && $donor->getComment() != $row['comment']) {
                    continue;
                }

                if (isset($row['state'])) {
                    $stateClass = "byrokrat\\giroapp\\Model\\DonorState\\{$row['state']}";
                    if (!$donor->getState() instanceof $stateClass) {
                        continue;
                    }
                }

                return true;
            }

            throw new Exception("Unable to find donor in database");
        }
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
     * @Then the output matches:
     */
    public function theOutputMatches(PyStringNode $string)
    {
        $output = explode("\n", $this->result->getOutput());
        $regexes = explode("\n", (string)$string);

        if (count($output) != count($regexes)) {
            throw new \Exception("Not the same number of regexes as lines in output");
        }

        foreach ($regexes as $lineNr => $regexp) {
            if (!preg_match("/^$regexp\s*$/", $output[$lineNr])) {
                throw new \Exception("Unable to find $regexp in {$output[$lineNr]}");
            }
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
