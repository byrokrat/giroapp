Import checks
-------------
Must check that the correct bgc-customer-number and bg-number is used on import...
In ImportAction???

Event model
-----------
`ApproveMandateEvent` ska vara `NodeEvent` och helt enkelt komma med en node. Det blir det enklaste..

Events::MANDATE_RESPONSE
Events::MANDATE_APPROVED
Events::MANDATE_REJECTED

MandateResponseAction => reagerar på response, hämtar Donor. Uppdaterar. Skickar nytt event...

Spara alla event typer i Events så att det blir tydligt för Plugins vilka som finns...

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
bin/giroapp init ??
