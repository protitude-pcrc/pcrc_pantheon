@page
@api
@ghnode
Feature: test node types
  In order to create a request node
  As a user of the admin role
  I need to see fill in the following fields

  Scenario: Admin user sees proper fields when logged in
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/request"
    When I fill in "Project Title" with "Request Test"
    When I select "177" from "Approved Request"
    Then I should see "Date of submission"
    When I fill in "PI" with "Pye"
    When I fill in "Affiliation" with "Augusta University (460)"
    Then I should see "Date of Approval"
    When I fill in "edit-field-data-requested-0-target-id" with "Advance Care Planning for Parkinson’s Disease (2119)"
    When I select "restricted_html" from "field_research_proposal_abstract[0][format]"
    When I fill in "Research Proposal Abstract" with "My awesome proposal"
    When I select "full_html" from "field_research_proposal_abstract[0][format]"
    Then I should see "PCRC Project Review"
    When I select "restricted_html" from "field_project_status[0][format]"
    When I fill in "Project Status" with "Working..."
    When I select "full_html" from "field_project_status[0][format]"
    When I select "restricted_html" from "field_reason_deemed_infeasible[0][format]"
    When I fill in "Reason Deemed Infeasible" with "Working..."
    When I select "full_html" from "field_reason_deemed_infeasible[0][format]"
    When I press "Save"
    Then I should see "Request Request Test has been created"
    Then I should see "My awesome proposal"
