<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DonorQueryDecorator;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\DonorCollection;
use PhpSpec\ObjectBehavior;

class DonorQueryDecoratorSpec extends ObjectBehavior
{
    function let(DonorQueryInterface $decorated)
    {
        $this->beConstructedWith($decorated);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorQueryDecorator::class);
    }

    function it_can_find_all($decorated, DonorCollection $collection)
    {
        $decorated->findAll()->willReturn($collection);
        $this->findAll()->shouldReturn($collection);
    }

    function it_can_find_by_mandate_key($decorated, Donor $donor)
    {
        $decorated->findByMandateKey('foo')->willReturn($donor);
        $this->findByMandateKey('foo')->shouldReturn($donor);
    }

    function it_can_require_by_mandate_key($decorated, Donor $donor)
    {
        $decorated->requireByMandateKey('foo')->willReturn($donor);
        $this->requireByMandateKey('foo')->shouldReturn($donor);
    }

    function it_can_find_by_payer_number($decorated, Donor $donor)
    {
        $decorated->findByPayerNumber('foo')->willReturn($donor);
        $this->findByPayerNumber('foo')->shouldReturn($donor);
    }

    function it_can_require_by_payer_number($decorated, Donor $donor)
    {
        $decorated->requireByPayerNumber('foo')->willReturn($donor);
        $this->requireByPayerNumber('foo')->shouldReturn($donor);
    }
}
