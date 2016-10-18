Feature: Icecat module base tests

  # There is no good testing for wordpress yet. So the following requirements:
  # user: admin
  # pass: pass
  # Also, there should already be credentials in the icecat config page. And
  # icecat should be installed.
  Background:
    Given I am on "/wp-admin"
    And I fill in "Username or Email" with "admin"
    And I fill in "Password" with "pass"
    And I press "Log In"

  Scenario: Icecat module settings page is accessible
    Given I am on "/wp-admin"
    And I follow "Settings"
    And I follow "Icecat Data grabber"
    Then I should see "Account information"

  Scenario Outline: Icecat can fetch a product on save
    Given I am on "/wp-admin/post-new.php?post_type=product"
    And I fill in "Product name" with "Demo name"
    And I fill in "Add an EAN (Required)" with "<ean>"
    And I press "Publish"
    Then the "Product name" field should contain "<title>"
    Then I should see an ".attachment-post-thumbnail" element

    Examples:
      | ean            | title                                   |
      | 08710103576655 | Philips AVENT Natural glass baby bottle |
      | 0745883645039  | Belkin WeMo                             |
