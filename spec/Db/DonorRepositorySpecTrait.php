<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Exception\DonorAlreadyExistsException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\DonorCollection;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Domain\State\Active;
use Money\Money;

trait DonorRepositorySpecTrait
{
    use DriverTestEnvironmentTrait;

    protected function createDonor(...$args): Donor
    {
        return $this->getDriverEnvironment()->getDonorFactory()->createDonor(...$args);
    }

    function it_is_a_donor_repository()
    {
        $this->shouldHaveType(DonorRepositoryInterface::class);
    }

    function it_returns_null_on_find_missing_mandate_key()
    {
        $this->findByMandateKey('does-not-exist')->shouldReturn(null);
    }

    function it_throws_on_require_missing_mandate_key()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringRequireByMandateKey('does-not-exist');
    }

    function it_returns_null_on_find_missing_payer_number()
    {
        $this->findByPayerNumber('does-not-exist')->shouldReturn(null);
    }

    function it_throws_on_require_missing_payer_number()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringRequireByPayerNumber('does-not-exist');
    }

    function it_can_add_a_donor()
    {
        $this->addNewDonor($this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'));
        $this->requireByMandateKey('m-key')->shouldReturnDonorWithMandateKey('m-key');
    }

    function it_throws_on_adding_a_mandate_key_duplicate()
    {
        $this->addNewDonor($this->createDonor('m-key', Active::getStateId(), '', 'A', '50001111116', '820323-2775'));
        $this->shouldThrow(DonorAlreadyExistsException::class)->duringAddNewDonor(
            $this->createDonor('m-key', Active::getStateId(), '', 'B', '50001111116', '820323-2783')
        );
    }

    function it_throws_on_adding_a_personal_id_duplicate()
    {
        $this->addNewDonor($this->createDonor('A', Active::getStateId(), '', 'A', '50001111116', '820323-2783'));
        $this->shouldThrow(DonorAlreadyExistsException::class)->duringAddNewDonor(
            $this->createDonor('B', Active::getStateId(), '', 'B', '50001111116', '820323-2783')
        );
    }

    function it_throws_on_adding_a_payer_number_duplicate()
    {
        $this->addNewDonor($this->createDonor('A', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'));
        $this->shouldThrow(DonorAlreadyExistsException::class)->duringAddNewDonor(
            $this->createDonor('B', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2783')
        );
    }

    function it_can_find_all_donors()
    {
        $this->addNewDonor($this->createDonor('A', Active::getStateId(), '', 'A', '50001111116', '820323-2775'));
        $this->addNewDonor($this->createDonor('B', Active::getStateId(), '', 'B', '50001111116', '820323-2783'));
        $this->findAll()->shouldReturnNrOfDonors(2);
    }

    function it_throws_on_delete_missing_donor()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringDeleteDonor(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775')
        );
    }

    function it_can_delete_donor()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->deleteDonor($donor);
        $this->findAll()->shouldReturnNrOfDonors(0);
    }

    function it_throws_on_missing_updateDonorName()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorName(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            ''
        );
    }

    function it_can_update_name()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->updateDonorName($donor, 'foobar');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getName', 'foobar');
    }

    function it_throws_on_missing_updateDonorState()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorState(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            new Error(),
            ''
        );
    }

    function it_can_update_state()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $error = new Error();
        $this->updateDonorState($donor, $error);
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getState', $error);
    }

    function it_throws_on_missing_updateDonorPayerNumber()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorPayerNumber(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            ''
        );
    }

    function it_can_update_payer_number()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->updateDonorPayerNumber($donor, 'payer-number');
        $this->requireByPayerNumber('payer-number')->shouldReturnDonorWithPayerNumber('payer-number');
    }

    function it_throws_on_updating_to_a_payer_number_that_already_exists()
    {
        $donorA = $this->createDonor('A', Active::getStateId(), '', 'A', '50001111116', '820323-2775');
        $donorB = $this->createDonor('B', Active::getStateId(), '', 'B', '50001111116', '820323-2783');
        $this->addNewDonor($donorA);
        $this->addNewDonor($donorB);
        $this->shouldThrow(DonorAlreadyExistsException::class)->duringUpdateDonorPayerNumber($donorA, 'B');
    }

    function it_throws_on_missing_updateDonorAmount()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorAmount(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            Money::SEK('0')
        );
    }

    function it_can_update_amount()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $newAmount = Money::SEK('66600');
        $this->updateDonorAmount($donor, $newAmount);
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getDonationAmount', $newAmount);
    }

    function it_throws_on_missing_updateDonorAddress()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorAddress(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            new PostalAddress()
        );
    }

    function it_can_update_address()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $newAddress = new PostalAddress('foo', 'bar');
        $this->updateDonorAddress($donor, $newAddress);
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getPostalAddress', $newAddress);
    }

    function it_throws_on_missing_updateDonorEmail()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorEmail(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            ''
        );
    }

    function it_can_update_email()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->updateDonorEmail($donor, 'foobar');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getEmail', 'foobar');
    }

    function it_throws_on_missing_updateDonorPhone()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorPhone(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            ''
        );
    }

    function it_can_update_phone()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->updateDonorPhone($donor, 'foobar');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getPhone', 'foobar');
    }

    function it_throws_on_missing_updateDonorComment()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringUpdateDonorComment(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            ''
        );
    }

    function it_can_update_comment()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->updateDonorComment($donor, 'foobar');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getComment', 'foobar');
    }

    function it_throws_on_missing_setDonorAttribute()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringSetDonorAttribute(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            '',
            ''
        );
    }

    function it_can_set_attribute()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->setDonorAttribute($donor, 'foo', 'bar');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getAttributes', ['foo' => 'bar']);
    }

    function it_can_set_multiple_attributes()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->setDonorAttribute($donor, 'foo', 'bar');
        $this->setDonorAttribute($donor, 'baz', 'qux');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getAttributes', ['foo' => 'bar', 'baz' => 'qux']);
    }

    function it_throws_on_missing_deleteDonorAttribute()
    {
        $this->shouldThrow(DonorDoesNotExistException::class)->duringDeleteDonorAttribute(
            $this->createDonor('m-key', Active::getStateId(), '', 'p-nr', '50001111116', '820323-2775'),
            ''
        );
    }

    function it_can_delete_attribute()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->setDonorAttribute($donor, 'foo', 'bar');
        $this->setDonorAttribute($donor, 'baz', 'qux');
        $this->deleteDonorAttribute($donor, 'baz');
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getAttributes', ['foo' => 'bar']);
    }

    function it_only_updates_requested_field()
    {
        $donor = $this->createDonor('m-key', Active::getStateId(), '', '', '50001111116', '820323-2775');
        $this->addNewDonor($donor);
        $this->updateDonorEmail($donor, 'mail');
        $this->updateDonorPhone($donor, 'phone');
        // email should be mail even though a donor object with other values is used in updateDonorPhone
        $this->requireByMandateKey('m-key')->shouldReturnDonorWith('getEmail', 'mail');
    }

    function getMatchers(): array
    {
        return [
            'returnDonorWithMandateKey' => function (Donor $donor, $mandateKey) {
                return $donor->getMandateKey() == $mandateKey;
            },
            'returnDonorWithPayerNumber' => function (Donor $donor, $payerNumber) {
                return $donor->getPayerNumber() == $payerNumber;
            },
            'returnDonorWith' => function (Donor $donor, $method, $expected) {
                return $donor->$method() == $expected;
            },
            'returnNrOfDonors' => function (DonorCollection $collection, int $count) {
                return count(iterator_to_array($collection)) == $count;
            },
        ];
    }
}
