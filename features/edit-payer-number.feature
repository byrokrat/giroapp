Feature: Editing payer numbers
  In order to manage autogiro donors
  As a user
  I need to be able to edit payer numbers

  Background:
    Given a fresh installation
    And a configuration file:
      """
      org_id = 1234567897
      org_bgc_nr = 123456
      org_bg = 58056201
      """

  Scenario: I edit a payer number
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I run "edit-payer-number 12345 --new-payer-number 666"
    Then the database contains donor "666" with "state" matching "AWAITING_PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE"
    And the database contains donor "666" with attribute "old_payer_number" matching "12345"

  Scenario: I export a payer number transaction update
    Given there are donors:
      | payer-number | state                                           |
      | 666          | AWAITING_PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE |
    When I run "export"
    Then the database contains donor "666" with "state" matching "PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE_SENT"

  Scenario: I import an autogiro file confirming transaction removal
    Given there are donors:
      | payer-number | state                                       |
      | 666          | PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE_SENT |
    When I import:
      """
      01AUTOGIRO              20190424            MAKULERING/ÄNDRING  1234560058056201
      2320190429000000000000066682000000020000REFERENS00000000AAAAAAAAAAAAAAAA12
      09201904249900              000000000000000000000001000000000002000å000000000000
      """
    Then the database contains donor "666" with "state" matching "AWAITING_PAYER_NUMBER_CHANGE"

  Scenario: I export a payer number change
    Given there are donors:
      | payer-number | state                        |
      | 666          | AWAITING_PAYER_NUMBER_CHANGE |
    When I run "edit 666 --attr-key old_payer_number --attr-value 12345"
    And I run "export"
    Then the database contains donor "666" with "state" matching "PAYER_NUMBER_CHANGE_SENT"

  Scenario: I import an autogiro file approving a payer number change request
    Given there are donors:
      | payer-number | state                    |
      | 666          | PAYER_NUMBER_CHANGE_SENT |
    When I import:
      """
      01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
      73005805620100000000000006665000000001111116198203232775     043220170817
      092017081799000000001
      """
    Then the database contains donor "666" with "state" matching "AWAITING_TRANSACTION_REGISTRATION"
