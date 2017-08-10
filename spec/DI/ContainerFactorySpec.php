<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\DI;

use byrokrat\giroapp\DI\ContainerFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContainerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContainerFactory::CLASS);
    }

    function it_creates_containers(OutputInterface $output)
    {
        $this->createContainer($output)->shouldHaveType(ContainerInterface::CLASS);
    }
}
