describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          const pages = [
            { url: 'members/roster', text: 'Membership Roster' },
            { url: 'operations', text: 'Operations' },
            { url: 'who/external-advisory-board', text: 'External Advisory Board' },
            { url: 'who/membership-committee', text: 'Membership Committee' },
            { url: 'who/publication', text: 'Publication Committee' },
            { url: 'who/scientific', text: 'Scientific Review Committee' },
            { url: 'who/steering', text: 'Steering Committee' },
            { url: 'admin/reports/downloads', text: 'File Name' },
            { url: 'News', text: 'News & Publications' },
            { url: 'requests', text: 'Data Requests' },
            { url: 'requests-not-feasible', text: 'Data Requests' },
            { url: 'studies', text: 'PCRC De-identified Data Repository (DiDR) Studies' },
            { url: 'search', text: 'Search Results' },
          ];

          pages.forEach(page => {
            cy.visit(page.url);
            cy.contains(page.text);
          });

          cy.deleteLastNode();

        }
      })
    })
  });
});

