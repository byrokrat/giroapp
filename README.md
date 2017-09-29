# ງir໐คpp

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/giroapp.svg?style=flat-square)](https://packagist.org/packages/byrokrat/giroapp)
[![Build Status](https://img.shields.io/travis/byrokrat/giroapp/master.svg?style=flat-square)](https://travis-ci.org/byrokrat/giroapp)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/giroapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/giroapp)
[![Dependency Status](https://img.shields.io/gemnasium/byrokrat/giroapp.svg?style=flat-square)](https://gemnasium.com/byrokrat/giroapp)

Command line app for managing autogiro donations.

Installation
------------
1. Download the [composer](https://getcomposer.org/) dependency manager.

2. `cd` to the desired installation directory (for example `cd /opt`).

3. Install using composer

```shell
composer create-project byrokrat/giroapp --stability=alpha --no-interaction --no-dev
```

4. Add `/opt/giroapp/bin` to your environment `PATH`.

5. Optionally change your user directory path. See below.

6. Setup your local installation using `giroapp init`.

### Changing the user directory path

By default giroapp keeps database and other installation specific files in a
directory named `giroapp` in current working directory. This might not be
optimal for a number of reasons (something like `/var/lib/giroapp` would
for example be better from a security perspective).

Change the user directory path by creating a `GIROAPP_PATH` environment variable
pointing to the desired directory.

Writing plugins
---------------
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
            Events::ERROR_EVENT => ['onError', 100]
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
            Events::MANDATE_APPROVED_EVENT => 'onApprovedDonor'
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

### On event listener priorities

When subscribing to events you may optionally set a priority to manage the call
order of registered listeners. The higher the priority, the earlier a listener
is executed. Internally giroapp event listeners use priorities ranging from `-10`
to `10`. This means that if you set a plugin priority to a value higher than `10`
it will be executed before the event is handled internally (and you may stop
event propagation if needed). If you set a plugin priority to a value lower than
`-10` the plugin will be executed after the event has been handled internally.
