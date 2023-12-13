describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('node/add/upcoming_events_presentations');

          cy.get('#edit-title-0-value').type('Fish learnings');
          cy.get('#edit-field-subtitle-0-value').type('Know your fish');
          cy.get('#edit-field-type-352').check();

          cy.get('#edit-body-0-format--2').select('restricted_html');
          cy.get('#edit-body-0-value').type('More info on this announcement');
          cy.get('#edit-body-0-format--2').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.get('#edit-submit').click();

          cy.contains('Upcoming Events & Presentations Fish learnings has been created');

          cy.deleteLastNode();

        }
      })
    })
  });
});

