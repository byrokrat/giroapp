Feature: Purge incative donors
  In order to manage autogiro donors
  As a user
  I need to be able to remove inactive donors from the database

  Scenario: I purge donors
    Given a fresh installation
    And there are donors:
      | payer-number | state               | id          | amount |
      | 1            | ACTIVE              | 840821-3067 | 100    |
      | 2            | INACTIVE            | 820828-6966 | 100    |
      | 3            | INACTIVE            | 550319-1016 | 100    |
    When I run "purge"
    And I run "status --purgeable-count"
    Then the output contains a line like "/^0$/"
