Feature: Pause mandates
  In order to manage autogiro donors
  As a user
  I need to be able to pause donor mandates

  Background:
    Given a fresh installation
    And a configuration file:
      """
      org_id = 1234567897
      org_bgc_nr = 123456
      org_bg = 58056201
      """

  Scenario: I pause a mandate
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "pause 12345"
    Then there is no error
    And the database contains donor "12345" with "state" matching "AWAITING_PAUSE"

  Scenario: I export a mandate that is awaiting pause
    Given there are donors:
      | payer-number | state  |
      | 12345        | AWAITING_PAUSE |
    When I run "export"
    Then the database contains donor "12345" with "state" matching "PAUSE_SENT"

  Scenario: I import an autogiro file confirming pause
    Given there are donors:
      | payer-number | state  |
      | 12345        | PAUSE_SENT |
    When I import:
      """
      01AUTOGIRO              20190424            MAKULERING/ÄNDRING  1234560058056201
      2320190429000000000001234582000000020000REFERENS00000000AAAAAAAAAAAAAAAA12
      09201904249900              000000000000000000000001000000000002000å000000000000
      """
    Then the database contains donor "12345" with "state" matching "PAUSED"

  Scenario: I try to pause a mandate that is not active
    Given there are donors:
      | payer-number | state  |
      | 12345        | PAUSED |
    When I run "pause 12345"
    Then I get a "INVALID_STATE_TRANSITION_EXCEPTION" error

  Scenario: I restart a paused mandate
    Given there are donors:
      | payer-number | state  |
      | 12345        | PAUSED |
    When I run "pause 12345 --restart"
    Then there is no error
    And the database contains donor "12345" with "state" matching "AWAITING_TRANSACTION_REGISTRATION"

  Scenario: I try to restart a mandate that is not paused
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "pause 12345 --restart"
    Then I get a "INVALID_STATE_TRANSITION_EXCEPTION" error

  Scenario: I revoke a paused mandate
    Given there are donors:
      | payer-number | state  |
      | 12345        | PAUSED |
    When I run "revoke 12345"
    Then there is no error
    And the database contains donor "12345" with "state" matching "AWAITING_REVOCATION"
