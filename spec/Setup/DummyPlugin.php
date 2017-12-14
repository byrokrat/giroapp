<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Setup;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DummyPlugin implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [];
    }
}
