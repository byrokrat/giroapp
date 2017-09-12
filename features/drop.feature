Feature: Dropping mandates
  In order to manage autogiro donors
  As a user
  I need to be able to drop inactive donor mandates from database

  Scenario: I drop an inactive mandate
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | INACTIVE |
    When I run "drop 12345"
    And I run "show 12345"
    Then I get an error
