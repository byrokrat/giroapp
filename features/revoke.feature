Feature: Revoking mandates
  In order to manage autogiro donors
  As a user
  I need to be able to revoke donor mandates

  Scenario: I revoke a mandate
    Given a fresh installation
    And there are donors:
      | payer-number | state       |
      | 12345        | ActiveState |
    When I run "revoke 12345"
    Then there is no error
    And the donor database contains:
      | payer-number | state              |
      | 12345        | RevokeMandateState |
