Feature: Pause mandates
  In order to manage autogiro donors
  As a user
  I need to be able to pause donor mandates

  Scenario: I pause a mandate
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "pause 12345"
    Then there is no error
    And the database contains donor "12345" with "state" matching "PAUSE_MANDATE"

 Scenario: I try to pause a mandate that is not active
   Given a fresh installation
   And there are donors:
     | payer-number | state  |
     | 12345        | PAUSED |
   When I run "pause 12345"
   Then I get an error

  Scenario: I restart a mandate
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | PAUSED |
    When I run "pause 12345 --restart"
    Then there is no error
    And the database contains donor "12345" with "state" matching "MANDATE_APPROVED"

 Scenario: I try to restart a mandate that is not paused
   Given a fresh installation
   And there are donors:
     | payer-number | state  |
     | 12345        | ACTIVE |
   When I run "pause 12345 --restart"
   Then I get an error
