#features/customer_self_creation.feature

Feature: Customer self Creation
  In order to access the customer page
  As a magento visitor
  I need to be able to create a new customer

  @javascript
  Scenario:
    Given I am on "/customer/account/create"
    When I fill in "firstname" with "Test"
    And I fill in "middlename" with "Test"
    And I fill in "lastname" with "Test"
    And I fill in "email_address" with "test@test.com"
    And I fill in "password" with "test12"
    And I fill in "confirmation" with "test12"
    And I click in element "div.buttons-set button.button"
    Then I wait for element "ul.messages li.success-msg" to appear

