# Writing plugins

Giroapp plugins are `.php` or `.phar` files in the user directory under `plugins/`.

The plugin must return a `PluginInterface` instance.

Plugins may register

* Event subscribers
* XML form difinitions
* Commands
* Donor filters
* Donor formatters
* Donor sorters
* Donor states

Here is an example plugin that sends notifications on application error:

<!-- @example Full-plugin -->
```php
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
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
            Events::ERROR => ['onError', 100]
        ];
    }

    public function onError(LogEvent $logEvent)
    {
        send_sms_to_admin(
            $logEvent->getMessage(),
            $logEvent->getContext()
        );
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

> For a list of possible event names see [Events](../src/Events.php).

## Listener priorities

When subscribing to events you may optionally set a priority to manage the call
order of registered listeners. The higher the priority, the earlier a listener
is executed. Internally giroapp event listeners use priorities ranging from `-10`
to `10`. This means that if you set a plugin priority to a value higher than `10`
it will be executed before the event is handled internally (and you may stop
event propagation if needed). If you set a plugin priority to a value lower than
`-10` the plugin will be executed after the event has been handled internally.
