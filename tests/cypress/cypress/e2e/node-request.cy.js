describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('node/add/request');

          cy.get('#edit-title-0-value').type('Request Test');
          cy.get('#edit-field-request-type-177').click();
          cy.get('#edit-field-pi-0-value').type('Pye');
          cy.get('#edit-field-affiliation-0-target-id').type('Augusta University (460)');
          // cy.get('#edit-field-affiliation-0-target-id').type('Advance Care Planning for Parkinson’s Disease (2119)');

          cy.get('#edit-field-research-proposal-abstract-0-format--2').select('restricted_html');
          cy.get('#edit-field-research-proposal-abstract-0-value').type('My awesome proposal');
          cy.get('#edit-field-research-proposal-abstract-0-format--2').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.get('#edit-field-project-status-0-format--2').select('restricted_html');
          cy.get('#edit-field-project-status-0-value').type('Working...');
          cy.get('#edit-field-project-status-0-format--2').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.get('#edit-field-reason-deemed-infeasible-0-format--2').select('restricted_html');
          cy.get('#edit-field-reason-deemed-infeasible-0-value').type('Working...');
          cy.get('#edit-field-reason-deemed-infeasible-0-format--2').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.get('#edit-submit').click();

          cy.contains('Request Request Test has been created').should('be.visible');
          cy.contains('My awesome proposal').should('be.visible');

          cy.deleteLastNode();

        }
      })
    })
  });
});

