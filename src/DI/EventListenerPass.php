<?php
/**
 * This file is part of byrokrat\giroapp.
 *
 * byrokrat\giroapp is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\DI;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Register event listeners with the event_listener tag
 */
class EventListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('event_dispatcher')) {
            return;
        }

        $definition = $container->findDefinition('event_dispatcher');

        foreach ($container->findTaggedServiceIds('event_listener') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addListener',
                    [
                        constant("\byrokrat\giroapp\Events::{$attributes['event']}"),
                        new Reference($id),
                        $attributes['priority']
                    ]
                );
            }
        }
    }
}
