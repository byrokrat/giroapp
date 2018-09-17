<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\AutogiroImportingListener;
use byrokrat\giroapp\AutogiroVisitor;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Exception\InvalidAutogiroFileException;
use byrokrat\giroapp\Utils\File;
use byrokrat\autogiro\Parser\ParserInterface;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Exception as AutogiroException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutogiroImportingListenerSpec extends ObjectBehavior
{
    function let(ParserInterface $parser, AutogiroVisitor $visitor)
    {
        $this->beConstructedWith($parser, $visitor);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AutogiroImportingListener::CLASS);
    }

    function it_parses_content($parser, $visitor, FileEvent $event, File $file, Node $tree)
    {
        $event->getFile()->willReturn($file);
        $file->getContent()->willReturn('autogiro');
        $parser->parse('autogiro')->willReturn($tree);
        $tree->accept($visitor)->shouldBeCalled();
        $this->onAutogiroFileImported($event);
    }

    function it_throws_on_autogiro_exception($parser, FileEvent $event, File $file)
    {
        $event->getFile()->willReturn($file);
        $file->getContent()->willReturn('autogiro');
        $autogiroException = new class extends \Exception implements AutogiroException {
        };
        $parser->parse('autogiro')->willThrow($autogiroException);
        $this->shouldThrow(InvalidAutogiroFileException::CLASS)->during('onAutogiroFileImported', [$event]);
    }
}
