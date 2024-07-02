/**
 * Logs out the user.
 */
Cypress.Commands.add('drupalLogout', () => {
  cy.visit('/user/logout');
})

/**
 * Basic user login command. Requires valid username and password.
 *
 * @param {string} username
 *   The username with which to log in.
 * @param {string} password
 *   The password for the user's account.
 */
Cypress.Commands.add('loginAs', (user, password) => {
  return cy.session(user, () => {
    cy.request({
      method: 'POST',
      url: '/user/login',
      form: true,
      body: {
        name: user,
        pass: password,
        form_id: 'user_login_form',
      },
    });
  },
  {
    cacheAcrossSpecs: true,
  });
});

/**
* Logs a user in by their uid via drush uli.
*/
Cypress.Commands.add('loginUserByUid', (uid) => {
  cy.drush('user-login', [], { uid, uri: Cypress.env('baseUrl') })
    .its('stdout')
    .then(function (url) {
      cy.visit(url);
    });
});

/**
* Deletes last node created.
*/
Cypress.Commands.add('deleteLastNode', () => {
  cy.visit('admin/content');
  cy.get('#edit-node-bulk-form-0').click();
  cy.get('#edit-action').select('node_delete_action');
  cy.get('#edit-submit').click();
  cy.get('[value="Delete"]').click();
});

