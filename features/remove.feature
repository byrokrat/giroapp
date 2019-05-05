Feature: Removing donors
  In order to manage autogiro donors
  As a user
  I need to be able to remove inactive donors from database

  Scenario: I remove an inactive donor
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | INACTIVE |
    When I run "remove 12345"
    And I run "show 12345"
    Then I get a "DONOR_DOES_NOT_EXIST_EXCEPTION" error
