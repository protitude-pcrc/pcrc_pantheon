@page
@api
@ghnode
@javascript
Feature: test node types
  In order to create a study node
  As a user of the admin role
  I need to see fill in the following fields

  Scenario: Admin user sees proper fields when logged in
    Given I am logged in as a user with the "administrator" role
    When I go to "node/add/study"
    When I fill in "Short Title" with "Fish Study"
    When I fill in "Detailed Title" with "Why fish swim"
    When I fill in "Clinical Trials Registration" with "Register here"
    When I fill in "URL" with "https://google.com"
    When I fill in "PCRC Study #" with "123"
    When I fill in "Primary Citation" with "https://google.com"
    Then I should see "Study Summary"
    Then I should see "Data Dictionary"
    Then I should see "Data Collection Form"

    When I select "restricted_html" from "field_summary[0][format]"
    When I fill in "Summary" with "Lots of fish studies show..."
    When I select "full_html" from "field_summary[0][format]"

    When I select "restricted_html" from "field_supporting_documentation[0][format]"
    When I fill in "Supporting Documentation" with "Supporting fish docs"
    When I select "full_html" from "field_supporting_documentation[0][format]"

    When I press "Approved Data Requests Associated with this Study"
    When I fill in "field_approved_data_requests[0][target_id]" with "Will an alternative reimbursement model provide financial sustainability for a palliative care program? (180)"

    When I press "Study Information Section Fields"
    When I fill in "Study Enrollment" with "Fish rollment"
    When I fill in "Study PI" with "Fish pi"
    When I fill in "Study PI Institution" with "Harvard"
    When I fill in "CO PI" with "yes"
    When I fill in "CO PI Institution" with "CU"
    When I fill in "Sponsor" with "Shark"
    When I fill in "Award Number" with "7"
    When I check "Multi Site"

    When I press "Categorization"
    When I select "136" from "PCRC Supported Trials"
    When I check "Renal"
    When I check "Peripheral Vascular Disease"
    When I select "173" from "200 – 299"
    When I check "Patient"
    When I check "Adult"
    When I select "152" from "Only male participants"
    When I select "151" from "≥ 25% Non-Hispanic White"
    When I select "148" from "Yes"
    When I select "143" from "11 - 15"
    When I select "138" from "Qualitative"
    When I select "160" from "Intervention"
    When I check "Home"

    When I press "Save"
    Then I should see "Study Fish Study has been created"
