# Writing plugins

Giroapp plugins are Symfony event subscribers in the user directory under `plugins/`.

Here is an example plugin that notifies someone on application error:

```php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;

class ErrorNotifyingPlugin implements EventSubscriberInterface
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

Here is another example plugin that sends mails to added donors:

```php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\donorEvent;

class DonorMailingPlugin implements EventSubscriberInterface
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
```

You can put multiple plugin classes in the same file if desired. Just make sure
that the plugin files are postfixed `.php`

For a list of possible event names see [Events](src/Events.php).

## Listener priorities

When subscribing to events you may optionally set a priority to manage the call
order of registered listeners. The higher the priority, the earlier a listener
is executed. Internally giroapp event listeners use priorities ranging from `-10`
to `10`. This means that if you set a plugin priority to a value higher than `10`
it will be executed before the event is handled internally (and you may stop
event propagation if needed). If you set a plugin priority to a value lower than
`-10` the plugin will be executed after the event has been handled internally.
