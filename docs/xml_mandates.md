# Importing online mandates in the XML format

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
