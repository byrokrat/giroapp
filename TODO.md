src/ContainerFactory

DataMapper
----------
* DonorMapper (+ add fields to Model/Donor)
* TransactionMapper (+ define a Model)

Fixa skal för detta. Enkla klasser med rätt dependencies...

Döp om State till Model/DonorState ...

Event model
-----------
MandateResponseAction => respond to MANDATE_RESPONSE events. Fetch Donor from db.
Update. Dispatch new events (Events::MANDATE_APPROVED, Events::MANDATE_REJECTED)

Log
---
LogAction som lyssnar på log events och skriver till @db_log_collection

Creating autogiro files
-----------------------
Implement the `export` command using `autogiro\Writer\Writer`
