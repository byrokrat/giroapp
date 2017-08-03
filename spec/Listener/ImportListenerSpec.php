<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ImportListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\ImportEvent;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\autogiro\Parser\Parser;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Tree\FileNode;
use byrokrat\autogiro\Tree\Record\Response\MandateResponseNode;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportListenerSpec extends ObjectBehavior
{
    function let(Parser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportListener::CLASS);
    }

    function a_tree(Node $node, $type = '', ...$children)
    {
        $node->getType()->willReturn($type);
        $node->getChildren()->willReturn($children);

        return $node;
    }

    function it_parses_content(
        ImportEvent $event,
        Parser $parser,
        FileNode $fileNode,
        EventDispatcherInterface $dispatcher
    ) {
        $event->getContents()->willReturn('foobar');
        $parser->parse('foobar')->willReturn($this->a_tree($fileNode));
        $this->onImportEvent($event, '', $dispatcher);
    }

    function it_dispatches_approved_mandate_events(
        ImportEvent $event,
        Parser $parser,
        FileNode $fileNode,
        EventDispatcherInterface $dispatcher,
        MandateResponseNode $node
    ) {
        $event->getContents()->willReturn('foobar');

        $parser->parse('foobar')->willReturn(
            $this->a_tree(
                $fileNode,
                '',
                $this->a_tree($node, 'MandateResponseNode')
            )
        );

        $dispatcher->dispatch(Events::MANDATE_RESPONSE_EVENT, Argument::type(NodeEvent::CLASS))->shouldBeCalled();

        $this->onImportEvent($event, '', $dispatcher);
    }
}
