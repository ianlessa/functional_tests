#features/create_magento_product.feature

Feature: Create Product
  In order to create a new product
  As a magento addmin
  I need to be able to create a new product

  Background:
    Given I am on "/admin"
    When I fill in "username" with "admin"
    And I fill in "login" with "123teste"
    And I click in element "input[type='submit']"
    And I wait for element "img[src*='skin/adminhtml/default/default/images/logo.gif']" to appear
  
  @javascript
  Scenario:
   When I follow the element "a[href*='admin/catalog_product/']" href
   #And I wait for element "button.add" to appear
   And I click in element "button.add"
   And I click in element "button.save"
   And I fill in "name" with "FP CC - Autorizado"
   And I fill in "description" with "Produto autorizado"
   And I fill in "short_description" with "Produto autorizado"
   And I fill in "sku" with "fpcc-autorizado"
   And I fill in "weight" with "1"
   And I select "1" from "status"

   And I click in element "a[title*='Prices']"
   And I wait for element "input[id='price']" to appear
   And I fill in "price" with "14.90"
   And I select "0" from "tax_class_id"
 
   And I click in element "a[name*='inventory']"
   And I wait for element "select[id*='inventory_manage_stock']" to appear
   And I uncheck "inventory_use_config_manage_stock"
   And I select "0" from "inventory_manage_stock"   
 
   And I click in element "button.save"
   Then I should see "fpcc-autorizado" appear

   And I wait for element "só pra esperar existente" to appear
