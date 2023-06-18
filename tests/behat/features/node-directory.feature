@page
@api
@ghnode
@javascript
Feature: test node types
  In order to create a directory node
  As a user of the admin role
  I need to see fill in the following fields

  Scenario: Admin user sees proper fields when logged in
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/directory"
    When I select "Dr." from "Title"
    When I fill in "First name" with "Gregory"
    When I fill in "Middle name(s)" with "Beatle"
    When I fill in "Last name" with "House"
    When I fill in "Credentials" with "Doctorate"
    When I fill in "Email" with "house@cu.edu"
    When I select "restricted_html" from "Text format"
    When I fill in "Body" with "Random Words"
    When I select "full_html" from "Text format"
    When I press "Title Designations"
    Then I should see "Image"
    Then I should see "Organization"
    Then I should see "List assignment"
    Then I should see "Operations Area of Focus"
    Then I should see "Scientific Review Committee Title"
    Then I should see "Membership Committee Title"
    Then I should see "Publication Committee Title"
    When I press "Save"
    Then I should see "Directory Entry Gregory House has been created"
