Feature: Display history information

  Background:
    Given a fresh installation
    And a configuration file:
        """
        org_id = 1234567897
        org_bgc_nr = 123456
        org_bg = 58056201
        """

  Scenario: I display transactions from a donor
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I import:
        """
        01AUTOGIRO              20190701113835820825BET. SPEC & STOPP TK1234560058056201
        15000000000000000000033000082032327752019070100010000000000000010000   00000002
        82201907011    00000000000123450000000100000058056201AAAAAAAAAAAAAAAA          0
        09201907019900000001000000000001000000000000000000000000000000000000
        """
    And I run "history 12345 --transactions"
    Then the output contains a line like "/[^0-9]+100\.00[^0-9]+2019-07-01/"

  Scenario: I display failed transactions from a donor
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I import:
        """
        01AUTOGIRO              20190701113835820825BET. SPEC & STOPP TK1234560058056201
        15000000000000000000033000082032327752019070100010000000000000010000   00000002
        82201907011    00000000000123450000000100000058056201AAAAAAAAAAAAAAAA          1
        09201907019900000001000000000000000000000000000000000000000000000000
        """
    And I run "history 12345 --type TRANSACTION_FAILED"
    Then the output contains a line like "/[^0-9]+100\.00[^0-9]+2019-07-01/"
