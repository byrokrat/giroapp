Feature: Revoking mandates
  In order to manage autogiro donors
  As a user
  I need to be able to revoke donor mandates

  Background:
    Given a fresh installation
    And a configuration file:
        """
        org_id = 1234567897
        org_bgc_nr = 123456
        org_bg = 58056201
        """

  Scenario: I revoke a mandate
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "revoke 12345"
    Then there is no error
    And the database contains donor "12345" with "state" matching "AWAITING_REVOCATION"

  Scenario: I export a revocation
    Given there are donors:
      | payer-number | state               |
      | 12345        | AWAITING_REVOCATION |
    When I run "export"
    Then the database contains donor "12345" with "state" matching "REVOCATION_SENT"

  Scenario: I import an autogiro file revoking a mandate
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I import:
      """
      01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
      73005805620100000000000123455000000001111116198203232775     033320170817
      092017081799000000001
      """
    Then the database contains donor "12345" with "state" matching "REVOKED"

  Scenario: I import an autogiro file removing transaction for revoked mandate
    Given there are donors:
      | payer-number | state   |
      | 12345        | REVOKED |
    When I import:
      """
      01AUTOGIRO              20190424            MAKULERING/ÄNDRING  1234560058056201
      2320190429000000000001234582000000020000REFERENS00000000AAAAAAAAAAAAAAAA12
      09201904249900              000000000000000000000001000000000002000å000000000000
      """
    Then there is no error
    And the database contains donor "12345" with "state" matching "REVOKED"

  Scenario: I import transaction and mandate revocation in backwards order
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I import:
      """
      01AUTOGIRO              20190424            MAKULERING/ÄNDRING  1234560058056201
      2320190429000000000001234582000000020000REFERENS00000000AAAAAAAAAAAAAAAA12
      09201904249900              000000000000000000000001000000000002000å000000000000
      """
    And I import:
      """
      01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
      73005805620100000000000123455000000001111116198203232775     033320170817
      092017081799000000001
      """
    Then there is no error
    And the database contains donor "12345" with "state" matching "REVOKED"
