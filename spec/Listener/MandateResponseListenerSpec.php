<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MandateResponseListener;
use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\id\Id;
use byrokrat\banking\AccountNumber;
use byrokrat\autogiro\Tree\Node;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandateResponseListenerSpec extends ObjectBehavior
{
    function let(DonorMapper $donorMapper)
    {
        $this->beConstructedWith($donorMapper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandateResponseListener::CLASS);
    }

    function it_fails_if_mandate_key_and_payer_number_does_not_match(
        NodeEvent $event,
        Id $id,
        AccountNumber $account,
        Node $node,
        Donor $donor,
        EventDispatcherInterface $dispatcher,
        $donorMapper
    ) {
        $this->setup_mandate_response('node-value', $event, $id, $account, $node, $donor, $donorMapper);

        $donor->getPayerNumber()->willReturn('not-the-same-as-payer-number-node-value');

        $this->shouldThrow(\RuntimeException::CLASS)->during('__invoke', [$event, '', $dispatcher]);
    }

    private function setup_mandate_response(
        string $nodeValue,
        NodeEvent $event,
        Id $id,
        AccountNumber $account,
        Node $node,
        Donor $donor,
        $donorMapper,
        string $madateKey = 'some-mandate-key'
    ) {
        $event->getNode()->willReturn($node);

        $node->getChild('id')->willReturn($node);
        $node->getChild('account')->willReturn($node);
        $node->getChild('payer_number')->willReturn($node);
        $node->getChild('info')->willReturn($node);
        $node->getChild('comment')->willReturn($node);

        $node->getAttribute('id')->willReturn($id);
        $node->getAttribute('account')->willReturn($account);

        $node->getValue()->willReturn($nodeValue);

        $keyBuilder->buildKey($id, $account)->willReturn($madateKey);

        $donorMapper->findByKey($madateKey)->willReturn($donor);

        $donor->getPayerNumber()->willReturn($nodeValue);
    }
}
