<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ImportingAutogiroListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Utils\File;
use byrokrat\autogiro\Parser\Parser;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Tree\FileNode;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportingAutogiroListenerSpec extends ObjectBehavior
{
    function let(Parser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportingAutogiroListener::CLASS);
    }

    function a_tree(Node $node, $type = '', ...$children)
    {
        $node->getType()->willReturn($type);
        $node->getChildren()->willReturn($children);

        return $node;
    }

    function it_parses_content(
        FileEvent $event,
        File $file,
        Parser $parser,
        FileNode $fileNode,
        EventDispatcherInterface $dispatcher
    ) {
        $event->getFile()->willReturn($file);
        $file->getContent()->willReturn('foobar');
        $parser->parse('foobar')->willReturn($this->a_tree($fileNode));
        $this->onImportAutogiroEvent($event, '', $dispatcher);
    }

    function it_dispatches_approved_mandate_events(
        FileEvent $event,
        File $file,
        Parser $parser,
        FileNode $fileNode,
        EventDispatcherInterface $dispatcher,
        Node $node
    ) {
        $event->getFile()->willReturn($file);
        $file->getContent()->willReturn('foobar');

        $parser->parse('foobar')->willReturn(
            $this->a_tree(
                $fileNode,
                '',
                $this->a_tree($node, 'MandateResponseNode')
            )
        );

        $dispatcher->dispatch(Events::MANDATE_RESPONSE_EVENT, Argument::type(NodeEvent::CLASS))->shouldBeCalled();

        $this->onImportAutogiroEvent($event, '', $dispatcher);
    }
}
