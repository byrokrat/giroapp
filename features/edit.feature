Feature: Editing donors
  In order to manage autogiro donors
  As a user
  I need to be able to edit donors

  Scenario: I edit a donor identified by mandate key
    Given a fresh installation
    And there are donors:
      | id         | account     | payer-number | name |
      | 8203232775 | 50001111116 | 1            | foo  |
    When I run "edit wkjmljAZVk7KQz9w --name bar"
    Then there is no error
    And the donor database contains:
      | mandate-key      | payer-number | name |
      | wkjmljAZVk7KQz9w | 1            | bar  |

  Scenario: I edit a donor identified by payer number
    Given a fresh installation
    And there are donors:
      | id         | account     | payer-number | name |
      | 8203232775 | 50001111116 | 1            | foo  |
    When I run "edit 1 --name bar"
    Then there is no error
    And the donor database contains:
      | mandate-key      | payer-number | name |
      | wkjmljAZVk7KQz9w | 1            | bar  |

  Scenario: I edit a donor and force identification by payer number
    Given a fresh installation
    And there are donors:
      | id         | account     | payer-number | name |
      | 8203232775 | 50001111116 | 1            | foo  |
    And there are donors:
      | payer-number     | name |
      | wkjmljAZVk7KQz9w | foo  |
    When I run "edit wkjmljAZVk7KQz9w --force-payer-number --name bar"
    Then there is no error
    And the donor database contains:
      | payer-number     | name |
      | wkjmljAZVk7KQz9w | bar  |
      | 1                | foo  |

  Scenario: I edit a donor and set a lot of values
    Given a fresh installation
    And there are donors:
      | payer-number | name | co-address | address1 | address2 | postal-code | postal-city | email | phone | amount | comment |
      | 1            | foo  | foo        | foo      | foo      | foo         | foo         | foo   | foo   | 0      | foo     |
    When I run "edit 1 --name=bar --co-address=co --address1=adr1 --address2=adr2 --postal-code=123 --postal-city=cty --email=hej@hoj.se --phone=789 --amount=100 --comment=updated"
    Then there is no error
    And the donor database contains:
      | payer-number | name | co-address | address1 | address2 | postal-code | postal-city | email      | phone | amount | comment |
      | 1            | bar  | co         | adr1     | adr2     | 123         | cty         | hej@hoj.se | 789   | 100    | updated |

  Scenario: I edit a donor and change state
    Given a fresh installation
    And there are donors:
      | payer-number | state            |
      | 1            | MandateSentState |
    When I run "edit 1 --state active"
    Then there is no error
    And the donor database contains:
      | payer-number | state       |
      | 1            | ActiveState |
