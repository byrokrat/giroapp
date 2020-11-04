# Writing plugins

Giroapp plugins are `.php` or `.phar` files in the plugins directory.

The plugin must return a `PluginInterface` instance.

Plugins may register

* psr-14 event listeners and listener providers
* Console commands
* Donor filters
* Donor formatters
* Donor sorters
* Status statistics
* Database drivers
* XML mandate compiler passes
* Other plugins

Here is an example plugin that sends notifications on application error:

<!-- @example Full-plugin -->
```php
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;

return new class implements PluginInterface {
    public function loadPlugin(EnvironmentInterface $env): void
    {
        $env->registerListener(function (LogEvent $event) {
            if ($event->getSeverity() == LogLevel::ERROR) {
                send_sms_to_admin($event->getMessage());
            }
        });
    }
};
```

For a more condensed syntax you may use the `Plugin` class that automatically
registers objects into the environment.

Here is an example that forces the donation amount on added donors to be at
least 100 SEK:

<!-- @example validate-donation-amount -->
```php
use byrokrat\giroapp\Plugin\Plugin;
use byrokrat\giroapp\Event\DonorAdded;
use byrokrat\giroapp\Event\Listener\ListenerInterface;
use Money\Money;

return new Plugin(
    new class() implements ListenerInterface
    {
        function __invoke(DonorAdded $event)
        {
            $donor = $event->getDonor();

            if (!$donor->getDonationAmount()->greaterThanOrEqual(Money::SEK('10000'))) {
                throw new \RuntimeException('Donation amount must be at least 100');
            }
        }
    }
);
```

## Listening to donor state transitions

Use the dedicated `DonorStateListener` to fire on specific donor state transitions:

<!-- @example mandate-approved-listener -->
```php
use byrokrat\giroapp\Plugin\Plugin;
use byrokrat\giroapp\Event\DonorStateUpdated;
use byrokrat\giroapp\Event\Listener\DonorStateListener;
use byrokrat\giroapp\Domain\State\AwaitingTransactionRegistration;

return new Plugin(
    new DonorStateListener(AwaitingTransactionRegistration::CLASS, function (DonorStateUpdated $event) {
        send_mail_to_donor(
            $event->getDonor()->getEmail(),
            "Welcome {$event->getDonor()->getName()}, you are now a donor!"
        );
    })
);
```

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
