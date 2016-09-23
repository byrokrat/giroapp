Feature: Exporting files to autogirot
  In order to manage autogiro donators
  As a user
  I need to be able to export files to autogirot

  Scenario: I respond to a new donor
    Given a database containing donor "12345" with state "NewMandateState"
    When I export
    Then the output contains a row with "new" donor "12345"
    Then the database contains donor "12345" with state "MandateSentState"

  Scenario: I respond to a new digital donor
    Given a database containing donor "12345" with state "NewDigitalMandateState"
    When I export
    Then the output contains a row with "approved" donor "12345"
    Then the database contains donor "12345" with state "MandateSentState"

  Scenario: I register transactions from donor
    Given a database containing donor "12345" with state "MandateApprovedState"
    When I export
    Then the output contains a row with transactions from donor "12345"
    Then the database contains donor "12345" with state "ActiveState"

  Scenario: I revoke a donor mandate
    Given a database containing donor "12345" with state "RevokeMandateState"
    When I export
    Then the output contains a row with "revoked" donor "12345"
    Then the database contains donor "12345" with state "RevocationSentState"
