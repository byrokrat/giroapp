<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Builder;

use byrokrat\giroapp\Builder\MandateKeyBuilder;
use byrokrat\id\IdInterface;
use byrokrat\banking\AccountNumber;
use Hashids\Hashids;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandateKeyBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MandateKeyBuilder::CLASS);
    }

    function it_creates_keys_for_short_input(IdInterface $id, AccountNumber $account)
    {
        $id->format('Ss')->willReturn('1');
        $account->get16()->willReturn('11');

        $this->buildKey($id, $account)->shouldBeString();
    }

    function it_creates_keys_for_long_input(IdInterface $id, AccountNumber $account)
    {
        $id->format('Ss')->willReturn('999999999');
        $account->get16()->willReturn('9999999999999999');

        $this->buildKey($id, $account)->shouldBeString();
    }

    function it_fails_if_key_is_not_of_desired_length(Hashids $hashEngine, IdInterface $id, AccountNumber $account)
    {
        $hashEngine->encode('11')->willReturn('this-is-not-16-chars');
        $this->setHashEngine($hashEngine);

        $id->format('Ss')->willReturn('1');
        $account->get16()->willReturn('11');

        $this->shouldThrow(\LogicException::CLASS)->duringBuildKey($id, $account);
    }
}
