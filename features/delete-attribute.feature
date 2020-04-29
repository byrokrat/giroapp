Feature: Deleting donor attributes

  Scenario: I delete an attribute
    Given a fresh installation
    And there are donors:
      | id         | account     | payer-number | name |
      | 8203232775 | 50001111116 | 1            | foo  |
    When I run "edit wkjmljAZVk7KQz9w --attr-key foo --attr-value bar"
    And I run "delete-attribute wkjmljAZVk7KQz9w --attr-key foo"
    Then there is no error
    And the database contains donor "1" with "attributes" matching "Array()"
