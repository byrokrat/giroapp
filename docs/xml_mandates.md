# Importing online mandates in the XML format

Giroapp supports importing xml formatted mandates through the
`import-xml-mandate` command. When you create an online mandate form you may
specify custom data fields, this data is saved as donor attributes on import.
Teach giroapp the semantics of these attributes by using ini-directivies or
plugins.

## INI-directives

The following ini-directives regulates how giroapp handles imported xml mandates.
Se also `giroapp.ini.dist`.

```ini
; Strategy for setting payer number when importing xml mandates
; Possible values 'personal-id' or 'ignore'
; personal-id: force payer number as personal id of donor
; ignore: do nothing, use value as specified in xml
xml_mandate_payer_nr_strategy = "ignore"

; Name of attribute to read dontation amount from (ignored if missing)
xml_mandate_donation_amount_from_attribute = "amount"

; Name of attribute to read phone number from (ignored if missing)
xml_mandate_phone_from_attribute = "phone"

; Name of attribute to read e-mail address from (ignored if missing)
xml_mandate_email_from_attribute = "email"

; Name of attribute to read comment from (ignored if missing)
xml_mandate_comment_from_attribute = "comment"
```

## Plugins

For more specific needs use plugins. The following example sets a custom donor
name.

<!-- @example xml-customdata-plugin -->
```php
use byrokrat\giroapp\Plugin\Plugin;
use byrokrat\giroapp\Xml\CompilerPassInterface;
use byrokrat\giroapp\Xml\XmlMandate;

return new Plugin(
    new class() implements CompilerPassInterface
    {
        function processMandate(XmlMandate $mandate): XmlMandate
        {
            $mandate->name = "PLUGIN";
            return $mandate;
        }
    }
);
```
