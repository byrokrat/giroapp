<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\Transaction;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::CLASS);
    }
}
