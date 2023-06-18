@admin-config
@api
@ghadminsecond
Feature: check admin structure pages
  In order use admin pages
  As a user of the admin role
  I need to see certain pages exist

  Scenario: Admin user sees proper fields when logged in
    Given I am logged in as a user with the "administrator" role
    When I go to "admin/structure/block/block-content"
    Then I should see "Custom block library"
    When I go to "admin/structure/block"
    Then I should see "PCRC News: Announcements Block"
    When I go to "admin/structure/comment"
    Then I should see "Comment types"
    When I go to "admin/structure/contact"
    Then I should see "Contact forms"
    Then I should see "Personal contact form"
    Then I should see "Website feedback"
    When I go to "admin/structure/types"
    Then I should see "Basic Page"
    Then I should see "Directory Entry"
    Then I should see "Request"
    Then I should see "Study"
    Then I should see "Upcoming Events & Presentations"
    When I go to "admin/structure/display-modes/form"
    # Add more here if custom modes added
    Then I should see "Form modes"
    Then I should see "Register"
    When I go to "admin/structure/context"
    Then I should see "Basic Page"
    Then I should see "Home Page"
    Then I should see "My Account Page"
    Then I should see "News List Page"
    Then I should see "News Page"
    Then I should see "Password Page"
    Then I should see "Requests Page"
    Then I should see "Request Data Form"
    Then I should see "Request Page"
    Then I should see "Search Results Page"
    Then I should see "Search Studies Page"
    Then I should see "Study Page"
    Then I should see "User Page"
    Then I should see "Page Title"
    Then I should see "Page Title in Highlighted"
    Then I should see "Search Buttons"
    Then I should see "Views headers"
    When I go to "admin/structure/display-modes/view"
    # Add any custom view modes needed
    Then I should see "View modes"
    Then I should see "Full content"
    Then I should see "Highlighted title"
    Then I should see "Revision"
    Then I should see "RSS"
    Then I should see "Search index"
    Then I should see "Search result highlighting input"
    Then I should see "Sidebar first"
    Then I should see "Sidebar second"
    Then I should see "Study data requests"
    Then I should see "Study details"
    Then I should see "Study links"
    Then I should see "Teaser"
    Then I should see "Teaser (no image)"
    Then I should see "Teaser (no title)"
    Then I should see "Teaser (operations)"
    Then I should see "Token"
    When I go to "admin/structure/entityqueue"
    Then I should see "External Advisory Board"
    Then I should see "Membership Committee"
    Then I should see "Operations"
    Then I should see "Publication Committee"
    Then I should see "Scientific Review Committee"
    Then I should see "Steering Committee"
    When I go to "admin/structure/feeds"
    Then I should see "Directory"
    When I go to "admin/structure/file-types"
    Then I should see "Audio"
    Then I should see "Document"
    Then I should see "Image"
    Then I should see "Video"
    When I go to "admin/structure/menu"
    Then I should see "Administration"
    Then I should see "Footer"
    Then I should see "Main navigation"
    Then I should see "Requests"
    Then I should see "Search Options"
    Then I should see "Tools"
    Then I should see "User account menu"
    Then I should see "User Menu"
    When I go to "admin/structure/taxonomy"
    Then I should see "Category"
    Then I should see "Classification"
    Then I should see "Conditions Studied"
    Then I should see "Data Types"
    Then I should see "Directory Lists"
    Then I should see "Font Designer"
    Then I should see "Font Foundry"
    Then I should see "Font Tags"
    Then I should see "Languages Supported"
    Then I should see "News Types"
    Then I should see "Number of Study Sites"
    Then I should see "Organizations"
    Then I should see "Participant Age"
    Then I should see "Participant Ethnicity Collected"
    Then I should see "Participant Race"
    Then I should see "Participant Sex"
    Then I should see "Participant Types"
    Then I should see "Request Types"
    Then I should see "Study Design"
    Then I should see "Study Setting"
    Then I should see "Study Types"
    Then I should see "Tags"
    Then I should see "Therapeutic Areas"
    Then I should see "Total Enrollment"
    When I go to "admin/structure/views"
    Then I should see "PCRC Data Requests"
    Then I should see "PCRC Directory Lists"
    Then I should see "PCRC File Downloads"
    Then I should see "PCRC News"
    Then I should see "PCRC NIH Extramural Nexus Feeds"
    Then I should see "PCRC Requests"
    Then I should see "PCRC Search Content"
    Then I should see "PCRC Studies Search"
    When I go to "admin/structure/webform"
    Then I should see "Webforms"
    Then I should see "Contact"
    Then I should see "Request Data Form"
