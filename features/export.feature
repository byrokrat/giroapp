Feature: Exporting files to autogirot
  In order to manage autogiro donors
  As a user
  I need to be able to export files to autogirot

  Background:
    Given a fresh installation
    And an orgnization 'foo' with bankgiro '58056201' and bgc customer number '111111'

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
    And the database contains donor "12345" with "state" matching "MandateSentState"

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
    And the database contains donor "12345" with "state" matching "MandateSentState"

  Scenario: I register transactions from donor
    Given there are donors:
      | id         | account     | payer-number | state            | amount |
      | 8203232775 | 50001111116 | 12345        | MANDATE_APPROVED | 999    |
    When I run "export"
    Then the output matches:
        """
        01\d{8}AUTOGIRO                                            1111110058056201
        82\d{8}1    00000000000123450000000999000058056201wkjmljAZVk7KQz9w
        """
    And the database contains donor "12345" with "state" matching "ActiveState"

  Scenario: I revoke a donor mandate
    Given there are donors:
      | payer-number | state          |
      | 12345        | REVOKE_MANDATE |
    When I run "export"
    Then the output matches:
        """
        01\d{8}AUTOGIRO                                            1111110058056201
        0300580562010000000000012345
        """
    And the database contains donor "12345" with "state" matching "RevocationSentState"
