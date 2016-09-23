Feature: Importing files from autogirot
  In order to manage autogiro donators
  As a user
  I need to be able to import files from autogirot

  Scenario: I import a new donor from a file
    Given an empty database
    When I import a file containing "new" donor "12345"
    Then the database contains donor "12345" with state "NewDigitalMandateState"

  Scenario: I import a new donor that already exists
    Given a database containing donor "12345"
    When I import a file containing "new" donor "12345"
    Then I get an error

  Scenario: I import a donor rejection
    Given a database containing donor "12345" with state "MandateSentState"
    When I import a file containing "rejected" donor "12345"
    Then the database contains donor "12345" with state "InactiveState"

  Scenario: I import a donor approval
    Given a database containing donor "12345" with state "MandateSentState"
    When I import a file containing "approved" donor "12345"
    Then the database contains donor "12345" with state "MandateApprovedState"

  Scenario: I import a donor revocation
    Given a database containing donor "12345"
    When I import a file containing "revoked" donor "12345"
    Then the database contains donor "12345" with state "InactiveState"
