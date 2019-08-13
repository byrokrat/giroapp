Feature: Editing donation amounts
  In order to manage autogiro donors
  As a user
  I need to be able to edit donation amounts

  Scenario: I edit a donation amount
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "edit-amount 12345 --new-amount 666"
    Then the database contains donor "12345" with "amount" matching "666"
    And the database contains donor "12345" with "state" matching "AWAITING_TRANSACTION_UPDATE"

  Scenario: I export an updated amount
    Given a fresh installation
    And there are donors:
      | payer-number | state  |
      | 12345        | AWAITING_TRANSACTION_UPDATE |
    When I run "export"
    Then the database contains donor "12345" with "state" matching "TRANSACTION_UPDATE_SENT"

  Scenario: I import an autogiro file confirming transaction removal
    Given a fresh installation
    And a configuration file:
      """
      org_id = 1234567897
      org_bgc_nr = 123456
      org_bg = 58056201
      """
    And there are donors:
      | payer-number | state                   |
      | 12345        | TRANSACTION_UPDATE_SENT |
    When I import:
      """
      01AUTOGIRO              20190424            MAKULERING/ÄNDRING  1234560058056201
      2320190429000000000001234582000000020000REFERENS00000000AAAAAAAAAAAAAAAA12
      09201904249900              000000000000000000000001000000000002000å000000000000
      """
    Then the database contains donor "12345" with "state" matching "AWAITING_TRANSACTION_REGISTRATION"
