Import checks
-------------
Must check that the correct bgc-customer-number and bg-number is used on import...
In ImportAction? Needs settings table in db..

Event model
-----------
MandateResponseAction => respond to MANDATE_RESPONSE events. Fetch Donor from db.
Update. Dispatch new events (Events::MANDATE_APPROVED, Events::MANDATE_REJECTED)

DataMapper
----------
* DictionaryMapper for settings
* DonorMapper (+ add fields to Model/Donor)
* TransactionMapper (+ define a Model)

Creating autogiro files
-----------------------
Implement the `export` command using `autogiro\Writer\Writer`
