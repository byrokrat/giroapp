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
directory named `.giroapp` in the home directory of the current user. This might
not be optimal for a number of reasons (something like `/var/lib/giroapp` would
for example be better from a security perspective).

Change the user directory path by either:

1. Define a `GIROAPP_PATH` environment variable pointing to desired directory.
1. Use the `--path` option to set user directory at runtime (overrides).

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

## Importing online mandates in the XML format

Giroapp supports importing xml formatted mandates through the `import` command.
When you create an online mandate form you may specify custom data fields. This
data is saved as donor attributes on import. You can tell giroapp how these
values should be handled by creating an implementation of
`XmlMandateMigrationInterface` in the user directory.

The following example tells giroapp that the content of the custom data field
`phone` should be handled as a phone number.

The `$formId` parameter may be used to return different maps for different forms.

```php
use byrokrat\giroapp\Xml\XmlMandateMigrationInterface;

class MyCustomMigration implements XmlMandateMigrationInterface
{
    public function getXmlMigrationMap(string $formId): array
    {
        return [
            'phone' => self::PHONE
        ];
    }
}
```

Custom callbacks may also be used. The above example is equivalent to

```php
use byrokrat\giroapp\Xml\XmlMandateMigrationInterface;
use byrokrat\giroapp\Builder\DonorBuilder;

class MyCustomMigration implements XmlMandateMigrationInterface
{
    public function getXmlMigrationMap(string $formId): array
    {
        return [
            'phone' => function (DonorBuilder $donorBuilder, string $value) {
                $donorBuilder->setPhone($value);
            }
        ];
    }
}
```
