# Writing plugins

Giroapp plugins are `.php` or `.phar` files in the plugins directory.

The plugin must return a `PluginInterface` instance.

Plugins may register

* Event subscribers
* Console commands
* Donor filters
* Donor formatters
* Donor sorters
* Donor states
* Database drivers

Here is an example plugin that sends notifications on application error:

<!-- @example Full-plugin -->
```php
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

return new class implements PluginInterface {
    public function loadPlugin(EnvironmentInterface $env): void
    {
        $env->registerSubscriber(new ErrorNotifyingSubscriber);
    }
};

class ErrorNotifyingSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            LogEvent::CLASS => ['onLogEvent', 100]
        ];
    }

    public function onLogEvent(LogEvent $event)
    {
        if ($event->getSeverity() == LogLevel::ERROR) {
            send_sms_to_admin($event->getMessage());
        }
    }
}
```

For a more condensed syntax you may use the `Plugin` class that automatically
registers objects into the environment.

Here is an example that sends mails to added donors:

<!-- @example Condensed-plugin -->
```php
use byrokrat\giroapp\Plugin\Plugin;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

return new Plugin(
    new class implements EventSubscriberInterface
    {
        public static function getSubscribedEvents()
        {
            return [
                Events::MANDATE_APPROVED => 'onApprovedDonor'
            ];
        }

        public function onApprovedDonor(DonorEvent $donorEvent)
        {
            send_mail_to_donor(
                $donorEvent->getDonor()->getEmail(),
                "Welcome {$donorEvent->getDonor()->getName()}, you are now a donor!"
            );
        }
    }
);
```

## Listener priorities

When subscribing to events you may optionally set a priority to manage the call
order of registered listeners. The higher the priority, the earlier a listener
is executed. Internally giroapp event listeners use priorities ranging from `-10`
to `10`. This means that if you set a plugin priority to a value higher than `10`
it will be executed before the event is handled internally (and you may stop
event propagation if needed). If you set a plugin priority to a value lower than
`-10` the plugin will be executed after the event has been handled internally.

## Specifying the supported giroapp api version

A plugin may specify the giroapp version it supports using version constraints
with the same syntax as the composer package manager, either by calling
`assertApiVersion()` on the environment or by passing an `ApiVersionConstraint`
directly. The constraint takes two arguments: a plugin name used for better
error reporting and the actual constraint. The following examples are equal:

<!-- @example version-constraint-full -->
```php
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Plugin\ApiVersionConstraint;

return new class implements PluginInterface {
    public function loadPlugin(EnvironmentInterface $env): void
    {
        $env->assertApiVersion(new ApiVersionConstraint('MyPlugin', '^1.0'));
    }
};
```

<!-- @example version-constraint-condensed -->
```php
use byrokrat\giroapp\Plugin\Plugin;
use byrokrat\giroapp\Plugin\ApiVersionConstraint;

return new Plugin(
    new ApiVersionConstraint('MyPlugin', '^1.0')
);
```
