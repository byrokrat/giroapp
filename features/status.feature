Feature: Examine database status
  In order to manage autogiro donors
  As a user
  I need to be able to examine the current state of the database

  Background:
    Given a fresh installation
    And there are donors:
      | payer-number | state                             | id          | amount |
      | 1            | ACTIVE                            | 840821-3067 | 100    |
      | 3            | AWAITING_TRANSACTION_REGISTRATION | 550319-1016 | 100    |
      | 5            | NEW_DIGITAL_MANDATE               | 650211-5097 | 100    |
      | 6            | NEW_MANDATE                       | 950819-4058 | 100    |
      | 8            | AWAITING_REVOCATION               | 890121-5742 | 100    |

  Scenario: I check the donor count
    When I run "status --show donor-count"
    Then the output contains a line like "/^1$/"

  Scenario: I check the amount count
    When I run "status --show monthly-amount"
    Then the output contains a line like "/^100$/"

  Scenario: I check the exportable count
    When I run "status --show exportable-count"
    Then the output contains a line like "/^4$/"
