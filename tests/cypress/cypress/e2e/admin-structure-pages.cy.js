describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('admin/content/block');
          // cy.contains('Custom block library').should('be.visible');

          cy.visit('admin/structure/block');
          cy.contains('PCRC News: Announcements Block');

          cy.visit('admin/structure/comment');
          cy.contains('Comment types');

          cy.visit('admin/structure/contact');
          ['Contact forms', 'Personal contact form', 'Website feedback'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/types');
          ['Basic page', 'Directory Entry', 'Request', 'Study', 'Upcoming Events & Presentations'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/display-modes/form');
          cy.contains('Form modes');
          cy.contains('Register').should('be.visible');

          cy.visit('admin/structure/context');
          ['Basic Page', 'Home Page', 'My Account Page', 'News List Page', 'News Page', 'Password Page', 'Requests Page', 'Request Data Form', 'Request Page', 'Search Results Page', 'Search Studies Page', 'Study Page', 'User Page', 'Page Title', 'Page Title in Highlighted', 'Search Buttons', 'Views headers'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/structure/display-modes/view');
          ['View modes', 'Full content', 'Highlighted title', 'Revision', 'RSS', 'Search index', 'Search result highlighting input', 'Sidebar first', 'Sidebar second', 'Study data requests', 'Study details', 'Study links', 'Teaser', 'Teaser (no image)', 'Teaser (no title)', 'Teaser (operations)', 'Token'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/entityqueue');
          ['External Advisory Board', 'Membership Committee', 'Operations', 'Publication Committee', 'Scientific Review Committee', 'Steering Committee'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/feeds');
          cy.contains('Directory');

          cy.visit('admin/structure/file-types');
          ['Audio', 'Document', 'Image', 'Video'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/menu');
          ['Administration', 'Footer', 'Main navigation', 'Requests', 'Search Options', 'Tools', 'User account menu', 'User Menu'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy');
          ['Category', 'Classification', 'Conditions Studied', 'Data Types', 'Directory Lists', 'Font Designer', 'Font Foundry', 'Font Tags', 'Languages Supported', 'News Types', 'Number of Study Sites', 'Organizations', 'Participant Age', 'Participant Ethnicity Collected', 'Participant Race', 'Participant Sex', 'Participant Types', 'Request Types', 'Study Design', 'Study Setting', 'Study Types', 'Tags', 'Therapeutic Areas', 'Total Enroll'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/views');
          ['PCRC Data Requests', 'PCRC Directory Lists', 'PCRC File Downloads', 'PCRC News', 'PCRC Requests', 'PCRC Search Content', 'PCRC Studies Search'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/webform');
          ['Webforms', 'Contact', 'Request Data Form'].forEach(item => {
            cy.contains(item);
          });

        }
      })
    })
  });
});
