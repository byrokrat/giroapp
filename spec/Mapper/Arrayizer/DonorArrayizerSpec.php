<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Arrayizer;

use byrokrat\giroapp\Mapper\Arrayizer\DonorArrayizer;
use byrokrat\giroapp\Mapper\Arrayizer\PostalAddressArrayizer;
use byrokrat\giroapp\Model\DonorState\DonorStateFactory;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorArrayizerSpec extends ObjectBehavior
{
    function let(
        PostalAddressArrayizer $postalAddressArrayizer,
        DonorStateFactory $donorStateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->beConstructedWith(
            $postalAddressArrayizer,
            $donorStateFactory,
            $accountFactory,
            $idFactory
        );
    }  
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorArrayizer::CLASS);
    }
}
