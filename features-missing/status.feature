Feature: Examine database status
  In order to manage autogiro donors
  As a user
  I need to be able to examine the current state of the database

  Background:
    Given a fresh installation
    And there are donors:
      | payer-number | state                  | amount |
      | 1            | ActiveState            | 100    |
      | 2            | InactiveState          | 100    |
      | 3            | MandateApprovedState   | 100    |
      | 4            | MandateSentState       | 100    |
      | 5            | NewDigitalMandateState | 100    |
      | 6            | NewMandateState        | 100    |
      | 7            | RevocationSentState    | 100    |
      | 8            | RevokeMandateState     | 100    |

  Scenario: I check the exportable count
    When I run "status --exportable-count"
    Then the output matches "/^4$/"

  Scenario: I check the donor count
    When I run "status --donor-count"
    Then the output matches "/^8$/"

  Scenario: I check the active donor count
    When I run "status --active-donor-count"
    Then the output matches "/^1$/"

  Scenario: I check the amount count
    When I run "status --monthly-amount"
    Then the output matches "/^100$/"
