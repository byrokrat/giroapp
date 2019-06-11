# Importing online mandates in the XML format

Giroapp supports importing xml formatted mandates through the `import` command.
When you create an online mandate form you may specify custom data fields, this
data is saved as donor attributes on import. Teach giroapp the semantics of
these attributes by using plygins.

The following example tells giroapp that the content of the custom data field
`phone` should be handled as a phone number.

<!-- @example xml-customdata-plugin -->
```php
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Event\DonorAdded;
use byrokrat\giroapp\CommandBus\UpdatePhone;

return new class implements PluginInterface {
    public function loadPlugin(EnvironmentInterface $env): void
    {
        $env->registerListener(function (DonorAdded $event) use ($env) {
            $donor = $event->getDonor();

            if ($donor->hasAttribute('phone')) {
                $env->getCommandBus()->handle(
                    new UpdatePhone($donor, $donor->getAttribute('phone'))
                );
            }
        });
    }
};
```
