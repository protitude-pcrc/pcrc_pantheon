describe('Page node', () => {
  it('Test page node', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('/support-training/telecommunication-liaison-lookup');
          cy.get('#edit-liaison-extension').type('20000');
          cy.get('#liaison-lookup-form > #edit-submit').click();
          cy.contains('We are currently having issues communicating with the database');
        }
      })
    })
  });
});

