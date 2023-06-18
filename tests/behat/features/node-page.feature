@page
@api
@ghnode
Feature: test node types
  In order to create a news node
  As a user of the admin role
  I need to see fill in the following fields

  Scenario: Admin user sees proper fields when logged in
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/page"
    When I fill in "Title" with "Page Test"
    When I fill in "Subtitle" with "Less important"
    When I select "restricted_html" from "Text format"
    When I fill in "Body" with "Random Words"
    When I select "full_html" from "Text format"
    When I press "Save"
    Then I should see "Basic page Page Test has been created"
    Then I should see "Random Words"
    Then I should see "ANNOUNCEMENTS"
    Then I should see "TWEETS FROM @PCRCGROUP"
    Then I should see "NIH EXTRAMURAL NEXUS"
