# features/magento_admin_login.feature
Feature: Admin Login 
  In order to see a user general panel
  As a magento admin 
  I need to be able to login on admin dashboard


  @javascript 
  Scenario: Login into magento's admin dashboard
    Given I am on "/admin"
    When I fill in "username" with "admin"
    And I fill in "login" with "123teste"
    And I click in element "input[type='submit']"    
    Then I wait for element "img[src*='skin/adminhtml/default/default/images/logo.gif']" to appear


