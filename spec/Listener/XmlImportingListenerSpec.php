<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\XmlImportingListener;
use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Model\NewDonor;
use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlObject;
use League\Tactician\CommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlImportingListenerSpec extends ObjectBehavior
{
    function let(XmlMandateParser $parser, CommandBus $commandBus)
    {
        $this->beConstructedWith($parser);
        $this->setCommandBus($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlImportingListener::CLASS);
    }

    function it_dispatches_added_mandates(
        $parser,
        $commandBus,
        XmlEvent $event,
        XmlObject $xml,
        NewDonor $newDonor
    ) {
        $event->getXmlObject()->willReturn($xml);
        $parser->parse($xml)->willReturn([$newDonor]);

        $commandBus->handle(new AddDonor($newDonor->getWrappedObject()))->shouldBeCalled();

        $this->onXmlFileImported($event);
    }
}
