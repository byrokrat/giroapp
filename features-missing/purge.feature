Feature: Purging inactive donors
  In order to manage autogiro donors
  As a user
  I need to be able to purge inactive donors from db

  Scenario: I purge inactive donors
    Given a fresh installation
    And there are donors:
      | payer-number | state         |
      | 12345        | InactiveState |
    When I run "purge"
    Then the donor database does not contain:
      | payer-number |
      | 12345        |
