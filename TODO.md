Import checks
-------------
Must check that the correct bgc-customer-number and bg-number is used on import...
In ImportAction???

Event model
-----------
MandateResponseAction => respond to MANDATE_RESPONSE events. Fetch Donot from db.
Update. Dispatch new events (Events::MANDATE_APPROVED, Events::MANDATE_REJECTED)

Add a database
--------------
* yaysondb? Is there something better??
* `.giroapp/data/settings.json`
* `.giroapp/data/donors.json`
* `.giroapp/data/transactions.json`

Creating autogiro files
-----------------------
Implement the `export` command using `autogiro\Writer\Writer`

Setup
-----
Needs a system to create default files and directories..
InitCommand??
