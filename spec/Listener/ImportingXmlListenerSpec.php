<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ImportingXmlListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportingXmlListenerSpec extends ObjectBehavior
{
    function let(XmlMandateParser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportingXmlListener::CLASS);
    }

    function it_dispatches_added_mandates(
        $parser,
        XmlEvent $event,
        XmlObject $xml,
        Donor $donor,
        EventDispatcherInterface $dispatcher
    ) {
        $event->getXmlObject()->willReturn($xml);
        $parser->parse($xml)->willReturn([$donor]);
        $donor->getName()->willReturn('');
        $donor->getMandateKey()->willReturn('');

        $dispatcher->dispatch(Events::MANDATE_ADDED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();

        $this->onImportXmlEvent($event, '', $dispatcher);
    }
}
