describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('node/add/directory');

          cy.get('#edit-field-name-0-title').select('Dr.');
          cy.get('#edit-field-name-0-given').type('Gregory');
          cy.get('#edit-field-name-0-middle').type('Beatle');
          cy.get('#edit-field-name-0-family').type('House');
          cy.get('#edit-field-name-0-credentials').type('Doctorate');
          cy.get('#edit-field-email-0-value').type('house@cu.edu');
          cy.get('#edit-body-0-format--2').select('restricted_html');
          cy.get('#edit-body-0-value').type('Random Words');
          cy.get('#edit-body-0-format--2').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.contains('Title Designations').click();

          ['Image', 'Organization', 'List assignment', 'Operations Area of Focus', 'Scientific Review Committee Title', 'Membership Committee Title', 'Publication Committee Title'].forEach(item => {
            cy.contains(item);
          });

          cy.get('#edit-submit').click();

          cy.contains('Directory Entry Gregory House has been created');

          cy.deleteLastNode();

        }
      })
    })
  });
});

