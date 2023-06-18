@api
@ghmisc
Feature: check views for content
  In order view views pages
  As a user
  I need to make sure empty messages do not exist

  Scenario: User does not see empty view messages
    When I go to "members/roster"
    Then I should see "Membership Roster"

    When I go to "operations"
    Then I should see "Operations"

    When I go to "who/external-advisory-board"
    Then I should see "External Advisory Board"

    When I go to "who/membership-committee"
    Then I should see "Membership Committee"

    When I go to "who/publication"
    Then I should see "Publication Committee"

    When I go to "who/scientific"
    Then I should see "Scientific Review Committee"

    When I go to "who/steering"
    Then I should see "Steering Committee"

    When I go to "admin/reports/downloads"
    Then I should see "FILE NAME"

    When I go to "News"
    Then I should see "News & Publications"

    When I go to "requests"
    Then I should see "Data Requests"

    When I go to "requests-not-feasible"
    Then I should see "Data Requests"

    When I go to "studies"
    Then I should see "PCRC De-identified Data Repository (DiDR) Studies"

    When I go to "search"
    Then I should see "Search Results"
