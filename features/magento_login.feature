# features/magento_login.feature
Feature: Login
  In order to see a user general panel
  As a user magento usere
  I need to be able to login on magento


  @javascript 
  Scenario: Login into magento.
    Given I am on "/customer/account/login"
    When I fill in "email" with "test@test.com"
    And I fill in "pass" with "test12"
    And I press "send"    
    Then I wait for url to become "/customer/account/"


