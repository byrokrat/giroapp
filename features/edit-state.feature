Feature: Editing donor state

  Scenario: I edit a donor and change state
    Given a fresh installation
    And there are donors:
      | payer-number | state                         |
      | 1            | TRANSACTION_REGISTRATION_SENT |
    When I run "edit-state 1 --new-state ACTIVE"
    Then there is no error
    And the database contains donor "1" with "state" matching "ACTIVE"
