describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('node/add/study');

          cy.get('#edit-title-0-value').type('Fish Study');
          cy.get('#edit-field-detailed-title-0-value').type('Why fish swim');
          cy.get('#edit-field-nct-link-field-0-title').type('Register here');
          cy.get('#edit-field-nct-link-field-0-uri').type('https://google.com');
          cy.get('#edit-field-pcrc-study-num-0-value').type('123');
          cy.get('#edit-field-primary-citation-0-uri').type('https://google.com');

          ['Study Summary', 'Data Dictionary', 'Data Collection Form'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.get('select[name="field_summary[0][format]"]').select('restricted_html');
          cy.get('#edit-field-summary-0-value').type('Lots of fish studies show...');
          cy.get('select[name="field_summary[0][format]"]').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.get('select[name="field_supporting_documentation[0][format]"]').select('restricted_html');
          cy.get('#edit-field-supporting-documentation-0-value').type('Supporting fish docs');
          cy.get('select[name="field_supporting_documentation[0][format]"]').select('full_html');
          cy.get('.ui-dialog-buttonset > .button--primary').click();

          cy.contains('Approved Data Requests Associated with this Study').click();
          cy.get('input[name="field_approved_data_requests[0][target_id]"]').type('Will an alternative reimbursement model provide financial sustainability for a palliative care program? (180)');

          cy.contains('Study Information Section Fields').click();
          cy.get('#edit-field-enrollment-0-value').type('Fish rollment');
          cy.get('#edit-field-study-pi-0-value').type('Fish pi');
          cy.get('#edit-field-study-pi-institution-0-value').type('Harvard');
          cy.get('#edit-field-study-site-pi-0-value').type('yes');
          cy.get('#edit-field-study-site-institution-0-value').type('CU');
          cy.get('#edit-field-sponsor-0-value').type('Shark');
          cy.get('#edit-field-award-number-0-value').type('7');
          cy.get('#edit-field-multi-site-value').check();

          cy.contains('Categorization').click();

          const idsToCheck = [
            '#edit-field-study-type-136',
            '#edit-field-therapeutic-area-166',
            '#edit-field-condition-studied-111',
            '#edit-field-total-enrollment-173',
            '#edit-field-participant-type-155',
            '#edit-field-participant-age-146',
            '#edit-field-participant-sex-152',
            '#edit-field-participant-race-151',
            '#edit-field-participant-ethnicity-coll-148',
            '#edit-field-number-of-study-sites-143',
            '#edit-field-data-type-138',
            '#edit-field-study-design-160',
            '#edit-field-study-setting-131'
          ];

          idsToCheck.forEach(id => {
            cy.get(id).check();
          });

          cy.get('#edit-submit').click();

          cy.contains('Study Fish Study has been created');

          cy.deleteLastNode();

        }
      })
    })
  });
});

