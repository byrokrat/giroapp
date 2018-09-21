# Importing online mandates in the XML format

Giroapp supports importing xml formatted mandates through the `import` command.
When you create an online mandate form you may specify custom data fields. This
data is saved as donor attributes on import. You can tell giroapp how these
values should be handled by creating an implementation of
`XmlFormInterface` in the user directory.

The following example tells giroapp that the content of the custom data field
`phone` should be handled as a phone number.

<!-- @example CustomForm1 -->
```php
use byrokrat\giroapp\Xml\XmlFormInterface;

class CustomForm implements XmlFormInterface
{
    public function getName(): string
    {
        return 'name';
    }

    public function getTranslations(): array
    {
        return [
            'phone' => self::PHONE
        ];
    }
}
```

Custom callbacks may also be used. The above example is equivalent to

<!-- @example CustomForm2 -->
```php
use byrokrat\giroapp\Xml\XmlFormInterface;
use byrokrat\giroapp\Builder\DonorBuilder;

class CustomForm implements XmlFormInterface
{
    public function getName(): string
    {
        return 'name';
    }

    public function getTranslations(): array
    {
        return [
            'phone' => function (DonorBuilder $donorBuilder, string $value) {
                $donorBuilder->setPhone($value);
            }
        ];
    }
}
```

Load the difinition as a plugin. Save a file like the following in the `plugins`
directory. For more information see the plugins section.

<!--
    @example FormPlugin
    @include CustomForm1
-->
```php
use byrokrat\giroapp\Plugin\Plugin;

return new Plugin(new CustomForm);
```
