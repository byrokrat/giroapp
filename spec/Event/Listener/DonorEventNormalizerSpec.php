<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\DonorEventNormalizer;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\DonorAdded;
use byrokrat\giroapp\Event\DonorAmountUpdated;
use byrokrat\giroapp\Event\DonorAttributeUpdated;
use byrokrat\giroapp\Event\DonorCommentUpdated;
use byrokrat\giroapp\Event\DonorEmailUpdated;
use byrokrat\giroapp\Event\DonorNameUpdated;
use byrokrat\giroapp\Event\DonorPhoneUpdated;
use byrokrat\giroapp\Event\DonorPostalAddressUpdated;
use byrokrat\giroapp\Event\DonorRemoved;
use byrokrat\giroapp\Event\DonorStateUpdated;
use byrokrat\giroapp\Event\TransactionPerformed;
use byrokrat\giroapp\Event\TransactionFailed;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;

class DonorEventNormalizerSpec extends ObjectBehavior
{
    function let(Donor $donor)
    {
        $donor->getMandateKey()->willReturn('mandate_key');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorEventNormalizer::class);
    }

    function it_throws_on_unknown_event(DonorEvent $event)
    {
        $this->shouldThrow(\LogicException::class)->duringNormalizeEvent($event);
    }

    function it_normalizes_donor_added($donor, AccountNumber $account, IdInterface $id)
    {
        $donor->getMandateKey()->willReturn('mandate_key');
        $donor->getPayerNumber()->willReturn('payer_number');

        $donor->getState()->willReturn(new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'state';
            }

            public function getDescription(): string
            {
                return '';
            }
        });

        $donor->getMandateSource()->willReturn('source');

        $account->getNumber()->willReturn('account');
        $donor->getAccount()->willReturn($account);

        $id->format('S-sk')->willReturn('id');
        $donor->getDonorId()->willReturn($id);

        $donor->getName()->willReturn('name');
        $donor->getPostalAddress()->willReturn(new PostalAddress('foo', 'bar', 'baz', '12345', 'city'));
        $donor->getEmail()->willReturn('email');
        $donor->getPhone()->willReturn('phone');
        $donor->getDonationAmount()->willReturn(new SEK('666'));
        $donor->getComment()->willReturn('comment');
        $donor->getAttributes()->willReturn(['key' => 'value']);

        $this->normalizeEvent(new DonorAdded($donor->getWrappedObject()))->shouldReturn([
            'mandate_key' => 'mandate_key',
            'state' => 'state',
            'mandate_source' => 'source',
            'payer_number' => 'payer_number',
            'account' => 'account',
            'donor_id' => 'id',
            'name' => 'name',
            'address' => [
                'line1' => 'foo',
                'line2' => 'bar',
                'line3' => 'baz',
                'postal_code' => '12345',
                'postal_city' => 'city',
            ],
            'email' => 'email',
            'phone' => 'phone',
            'donation_amount' => '666',
            'comment' => 'comment',
            'attributes' => [
                'key' => 'value',
            ],
        ]);
    }

    function it_normalizes_amount_updated($donor)
    {
        $this->normalizeEvent(new DonorAmountUpdated($donor->getWrappedObject(), new SEK('666')))->shouldReturn([
            'donation_amount' => '666'
        ]);
    }

    function it_normalizes_attribute_updated($donor)
    {
        $this->normalizeEvent(new DonorAttributeUpdated($donor->getWrappedObject(), 'foo', 'bar'))->shouldReturn([
            'attributes' => ['foo' => 'bar']
        ]);
    }

    function it_normalizes_comment_updated($donor)
    {
        $this->normalizeEvent(new DonorCommentUpdated($donor->getWrappedObject(), 'foo'))->shouldReturn([
            'comment' => 'foo'
        ]);
    }

    function it_normalizes_email_updated($donor)
    {
        $this->normalizeEvent(new DonorEmailUpdated($donor->getWrappedObject(), 'foo'))->shouldReturn([
            'email' => 'foo'
        ]);
    }

    function it_normalizes_name_updated($donor)
    {
        $this->normalizeEvent(new DonorNameUpdated($donor->getWrappedObject(), 'foo'))->shouldReturn([
            'name' => 'foo'
        ]);
    }

    function it_normalizes_phone_updated($donor)
    {
        $this->normalizeEvent(new DonorPhoneUpdated($donor->getWrappedObject(), 'foo'))->shouldReturn([
            'phone' => 'foo'
        ]);
    }

    function it_normalizes_postal_address_updated($donor)
    {
        $address = new PostalAddress('foo', 'bar', 'baz', '12345', 'city');
        $this->normalizeEvent(new DonorPostalAddressUpdated($donor->getWrappedObject(), $address))->shouldReturn([
            'address' => [
                'line1' => 'foo',
                'line2' => 'bar',
                'line3' => 'baz',
                'postal_code' => '12345',
                'postal_city' => 'city',
            ],
        ]);
    }

    function it_normalizes_donor_removed($donor)
    {
        $this->normalizeEvent(new DonorRemoved($donor->getWrappedObject()))->shouldReturn([]);
    }

    function it_normalizes_state_updated($donor)
    {
        $state = new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'FOO';
            }

            public function getDescription(): string
            {
                return '';
            }
        };

        $this->normalizeEvent(new DonorStateUpdated($donor->getWrappedObject(), $state, 'desc'))->shouldReturn([
            'state' => 'FOO',
            'state_update_description' => 'desc',
        ]);
    }

    function it_normalizes_transaction_performed($donor)
    {
        $this->normalizeEvent(
            new TransactionPerformed($donor->getWrappedObject(), new SEK('100'), new \DateTimeImmutable('20190812'))
        )->shouldReturn([
            'transaction_amount' => '100.00',
            'transaction_date' => '2019-08-12'
        ]);
    }

    function it_normalizes_transaction_failed($donor)
    {
        $this->normalizeEvent(
            new TransactionFailed($donor->getWrappedObject(), new SEK('100'), new \DateTimeImmutable('20190812'))
        )->shouldReturn([
            'transaction_amount' => '100.00',
            'transaction_date' => '2019-08-12'
        ]);
    }
}
