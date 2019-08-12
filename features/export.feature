Feature: Exporting files to autogirot
  In order to manage autogiro donors
  As a user
  I need to be able to export files to autogirot

  Background:
    Given a fresh installation
    And a configuration file:
        """
        org_id = 1234567897
        org_bgc_nr = 111111
        org_bg = 58056201
        """

  Scenario: I export a new paper based mandate
    Given there are donors:
      | payer-number | account     | id         | state       |
      | 12345        | 50001111116 | 8203232775 | NEW_MANDATE |
    When I run "export"
    Then the output matches:
        """
        01\d{8}AUTOGIRO                                            1111110058056201
        04005805620100000000000123455000000001111116\d{2}8203232775
        """
    And the database contains donor "12345" with "state" matching "MANDATE_SENT"

  Scenario: I export to a named file
    Given there are donors:
      | payer-number | account     | id         | state       |
      | 12345        | 50001111116 | 8203232775 | NEW_MANDATE |
    When I run "export --filename=foobar"
    Then there is a file named "foobar"
    And the output does not contain "AUTOGIRO"

  Scenario: I respond to a new digital mandate
    Given there are donors:
      | payer-number | state               |
      | 12345        | NEW_DIGITAL_MANDATE |
    When I run "export"
    Then the output matches:
        """
        01\d{8}AUTOGIRO                                            1111110058056201
        0400580562010000000000012345
        """
    And the database contains donor "12345" with "state" matching "MANDATE_SENT"

  Scenario: I register transactions from donor
    Given there are donors:
      | id         | account     | payer-number | state                             | amount |
      | 8203232775 | 50001111116 | 12345        | AWAITING_TRANSACTION_REGISTRATION | 999    |
    When I run "export"
    Then the output matches:
        """
        01\d{8}AUTOGIRO                                            1111110058056201
        82\d{8}1    00000000000123450000000999000058056201wkjmljAZVk7KQz9w
        """
    And the database contains donor "12345" with "state" matching "ACTIVE"

  Scenario: I revoke a donor mandate
    Given there are donors:
      | payer-number | state               |
      | 12345        | AWAITING_REVOCATION |
    When I run "export"
    Then the output matches:
        """
        01\d{8}AUTOGIRO                                            1111110058056201
        0300580562010000000000012345
        """
    And the database contains donor "12345" with "state" matching "REVOCATION_SENT"
