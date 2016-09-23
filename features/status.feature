Feature: Examine database status
  In order to manage autogiro donators
  As a user
  I need to be able to examine the current state of the database

  Background:
    Given a database containing:
    | donor | state                  | amount |
    | 1     | ActiveState            | 100    |
    | 2     | InactiveState          | 100    |
    | 3     | MandateApprovedState   | 100    |
    | 4     | MandateSentState       | 100    |
    | 5     | NewDigitalMandateState | 100    |
    | 6     | NewMandateState        | 100    |
    | 7     | RevocationSentState    | 100    |
    | 8     | RevokeMandateState     | 100    |

  Scenario: I check the exportable count
    Given the background
    When I check the status
    Then the output contains "exportable" count "4"

  Scenario: I check the donor count
    Given the background
    When I check the status
    Then the output contains "donor" count "8"

  Scenario: I check the amount count
    Given the background
    When I check the status
    Then the output contains "amount" count "100"

  Scenario: I check all donors
    Given the background
    When I check the verbose status
    Then the output contains donor "1"
    And the output contains donor "2"
    And the output contains donor "3"
    And the output contains donor "4"
    And the output contains donor "5"
    And the output contains donor "6"
    And the output contains donor "7"
    And the output contains donor "8"
