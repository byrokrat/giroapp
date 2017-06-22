Import checks
-------------
Must check that the correct bgc-customer-number and bg-number is used on import...
In ImportAction???

Event model
-----------
Should `ApproveMandateEvent` (and others) extend `AbstractDonorEvent`?
And wrap a `Donor` object instead of a `MandateResponseNode`

Add support for hooks
---------------------
* Runner that scans filesystem and executes hooks..
* Filenames like `.giroapp/hooks/approved-mandate/sendmail.php`
* Implement using flysystem
* `sendmail.php` should return a callable
* Each hook should get appropriate payload
* Hook callables should get the dispatcher for advanced hooking...

Add a database
--------------
* yaysondb? Is there something better??
* `.giroapp/data/settings.json`
* `.giroapp/data/donors.json`
* `.giroapp/data/transactions.json`

Creating autogiro files
-----------------------
Implement the `export` command using `autogiro\Writer\Writer`
