describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('node/add/page');

          cy.get('#edit-title-0-value').type('Page Test');
          cy.get('#edit-field-subtitle-0-value').type('Less important');
          cy.get('#edit-body-0-format--2').select('restricted_html');
          cy.get('#edit-body-0-value').type('Random Words');
          cy.get('#edit-body-0-format--2').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.get('#edit-submit').click();

          cy.contains('Basic page Page Test has been created');
          cy.contains('Random Words');
          cy.contains('Announcements');
          cy.contains('Tweets from @PCRCGroup');

          cy.deleteLastNode();

        }
      })
    })
  });
});

