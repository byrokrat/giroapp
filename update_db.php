<?php

// Edit to configure

define('DONOR_EVENTS_FILE', 'donor_events.json_lines');
define('DONORS_FILE', 'donors.json');
define('DONORS_FILE_TARGET', 'donors_fixed.json');

$stateTranslations = [
    'NEW_MANDATE' => 'NEW_MANDATE',
    'NEW_DIGITAL_MANDATE' => 'NEW_DIGITAL_MANDATE',
    'MANDATE_SENT' => 'MANDATE_SENT',
    'MANDATE_APPROVED' => 'AWAITING_TRANSACTION_REGISTRATION',
    'ACTIVE' => 'ACTIVE',
    'REVOKE_MANDATE' => 'AWAITING_REVOCATION',
    'REVOCATION_SENT' => 'REVOCATION_SENT',
    'INACTIVE' => 'REVOKED',
    'PAUSE_MANDATE' => 'AWAITING_PAUSE',
    'PAUSE_SENT' => 'PAUSE_SENT',
    'PAUSED' => 'PAUSED',
    'REMOVED' => 'REMOVED',
    'ERROR' => 'ERROR',
];

// Setup

include __DIR__ . "/vendor/autoload.php";

if (!isset($argv[1])) {
    die("Usage: php update_db.php <path-to-json-database-directory>\n");
}

$dbDir = realpath($argv[1]);

if (!$dbDir) {
    die("Invalid directory\n");
}

// Pre-checks

$donorsFileName =  $dbDir . "/" . DONORS_FILE;
$donorsFileTargetName =  $dbDir . "/" . DONORS_FILE_TARGET;
$eventsFileName = $dbDir . "/" . DONOR_EVENTS_FILE;

if (!file_exists($donorsFileName)) {
    die("Unable to locate '$donorsFileName'.\n");
}

if (file_exists($donorsFileTargetName)) {
    die("Unable to create '$donorsFileTargetName', file already exists.\n");
}

if (file_exists($eventsFileName)) {
    die("Unable to create '$eventsFileName', file already exists.\n");
}

// Perform state translations

$oldData = json_decode(file_get_contents($donorsFileName), true);

$newData = [];

foreach ($oldData as $key => $item) {
    unset($item['state_desc']);

    if (!isset($stateTranslations[$item['state']])) {
        throw new \Exception("Unknown state {$item['state']} in item $key");
    }

    $item['state'] = $stateTranslations[$item['state']];

    $newData[$key] = $item;
}

file_put_contents($donorsFileTargetName, json_encode($newData, JSON_PRETTY_PRINT)."\n");

// Hack for event store..

use byrokrat\giroapp\Domain\DonorFactory;
use byrokrat\giroapp\Domain\Donor;

class HackDonor extends Donor
{
    public $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }
}

class HackDonorFactory extends DonorFactory
{
    public function __construct()
    {
    }

    public function createDonor(
        string $mandateKey = '',
        string $state = '',
        string $mandateSource = '',
        string $payerNumber = '',
        string $accountNumber = '',
        string $donorId = '',
        string $name = '',
        array $address = [],
        string $email = '',
        string $phone = '',
        string $donationAmount = '0',
        string $comment = '',
        string $created = '',
        string $updated = '',
        array $attributes = []
    ): Donor {
        return new HackDonor([
            'mandate_key' => $mandateKey,
            'state' => $state,
            'mandate_source' => $mandateSource,
            'payer_number' => $payerNumber,
            'account' => $accountNumber,
            'donor_id' => $donorId,
            'name' => $name,
            'address' => [
                'line1' => trim($address[0]),
                'line2' => trim($address[1]),
                'line3' => trim($address[2]),
                'postal_code' => trim($address[3]),
                'postal_city' => trim($address[4]),
            ],
            'email' => $email,
            'phone' => $phone,
            'donation_amount' => $donationAmount,
            'comment' => $comment,
            'created' => $created,
            'updated' => $updated,
            'attributes' => $attributes,
        ]);
    }
}

// Generate event store

use byrokrat\giroapp\Db\Json\JsonDriverFactory;
use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Utils\SystemClock;

$driver = (new JsonDriverFactory)->createDriver($dbDir);

$envir = new DriverEnvironment(new SystemClock, new HackDonorFactory);

$donorRepo = $driver->getDonorRepository($envir);
$eventStore = $driver->getDonorEventStore($envir);

use byrokrat\giroapp\Db\DonorEventEntry;

$entries = [];

foreach ($donorRepo->findAll() as $donor) {
    $created = new \DateTimeImmutable($donor->values['created']);
    $updated = new \DateTimeImmutable($donor->values['updated']);

    unset($donor->values['created']);
    unset($donor->values['updated']);

    $currentState = $donor->values['state'];
    $donor->values['state'] = $stateTranslations['NEW_MANDATE'];

    $donor->values['attributes']['event_generated_from_donor_repository'] = 'yes';

    $entries[] = new DonorEventEntry(
        $donor->values['mandate_key'],
        'DONOR_ADDED',
        $created,
        $donor->values
    );

    $entries[] = new DonorEventEntry(
        $donor->values['mandate_key'],
        'DONOR_STATE_UPDATED',
        $updated,
        [
            'state' => $currentState,
            'state_update_description' => 'Event generated from donor repository (date may be false)',
        ]
    );
}

usort($entries, function ($left, $right) {
    return $left->getDateTime() <=> $right->getDateTime();
});

foreach ($entries as $entry) {
    $eventStore->addDonorEventEntry($entry);
}

$driver->commit();
