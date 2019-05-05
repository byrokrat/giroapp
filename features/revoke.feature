Feature: Revoking mandates
  In order to manage autogiro donors
  As a user
  I need to be able to revoke donor mandates

  Scenario: I revoke a mandate
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "revoke 12345"
    Then there is no error
    And the database contains donor "12345" with "state" matching "REVOKE_MANDATE"
