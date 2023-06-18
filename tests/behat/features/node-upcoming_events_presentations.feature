@page
@api
@ghnode
Feature: test node types
  In order to create a Upcoming Events Presentations node
  As a user of the admin role
  I need to see fill in the following fields

  Scenario: Admin user sees proper fields when logged in
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/upcoming_events_presentations"
    When I fill in "Title" with "Fish learnings"
    When I fill in "Subtitle" with "Know your fish"

    When I check "Announcement"

    When I select "restricted_html" from "Text format"
    When I fill in "Body" with "More info on this announcement"
    When I select "full_html" from "Text format"

    When I press "Save"
    Then I should see "Upcoming Events & Presentations Fish learnings has been created"
