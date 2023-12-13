describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('admin/config/people/accounts');
          cy.contains('Account settings');

          cy.visit('admin/config/people/accounts/fields');
          cy.contains('Affiliation').should('be.visible');
          cy.contains('Are you a PCRC Member?').should('be.visible');
          cy.contains('First name').should('be.visible');
          cy.contains('Last name').should('be.visible');
          cy.contains('Picture').should('be.visible');

          cy.visit('admin/config/people/captcha');
          cy.contains('CAPTCHA settings');

          cy.visit('admin/config/system/site-information');
          cy.get('#edit-site-name').should('have.value', 'Palliative Care Research Cooperative Group');
          cy.get('#edit-site-slogan').should('have.value', '');
          cy.get('#edit-site-mail').should('have.value', 'pcrc.disc@gmail.com');
          cy.get('#edit-site-frontpage').should('have.value', '/home');
          cy.get('#edit-site-403').should('have.value', '');
          cy.get('#edit-site-404').should('have.value', '');

          cy.visit('admin/config/system/smtp');
          cy.contains('SMTP Authentication Support');

          cy.visit('admin/config/system/cron');
          cy.contains('Cron');

          cy.visit('admin/config/system/entity-clone');
          const entities = ['Custom block', 'Comment', 'Contact message', 'Fake entity type', 'Entity subqueue', 'Subscription', 'Feed', 'File', 'Content', 'URL alias', 'Redirect', 'Search task', 'Shortcut link', 'Taxonomy term', 'User', 'Webform submission', 'Font', 'Custom menu link'];
          entities.forEach(entity => {
            cy.contains(entity);
          });

          cy.visit('admin/config/content/entity_browser');
          ['browse_documents', 'browse_documents_modal', 'browse_files', 'browse_files_modal', 'browse_images', 'browse_images_modal'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/content/linkit');
          ['Linkit profiles', 'Administrator'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/content/formats');
          ['Full HTML', 'Restricted HTML', 'Basic HTML', 'Plain text'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/content/embed');
          ['Embed buttons', 'Document Browser', 'File Browser', 'Image Browser', 'Node'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/user-interface/admin-toolbar-search-settings');
          cy.contains('Admin toolbar search settings').should('be.visible');

          cy.visit('admin/config/user-interface/admin-toolbar-tools');
          cy.contains('Admin Toolbar Tools settings').should('be.visible');

          cy.visit('admin/config/user-interface/admin-toolbar');
          cy.contains('Admin Toolbar settings').should('be.visible');

          cy.visit('admin/config/user-interface/shortcut');
          cy.contains('Default');

          cy.visit('admin/config/development/performance');
          cy.contains('Performance');

          cy.visit('admin/config/development/logging');
          cy.contains('Logging and errors');

          cy.visit('admin/config/development/maintenance');
          cy.contains('Maintenance mode');

          cy.visit('admin/config/development/configuration');
          cy.contains('Synchronize').should('be.visible');

          cy.visit('admin/config/media/file-system');
          cy.contains('File system');

          cy.visit('admin/config/media/image-styles');
          ['Directory Image', 'Directory profile', 'File Entity Browser small thumbnail', 'File Entity Browser thumbnail', 'Large (480×480)', 'Linkit result thumbnail', 'Max 325x325', 'Max 650x650', 'Max 1300x1300', 'Max 2600x2600', 'Medium (220×220)', 'Thumbnail (100×100)'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/media/responsive-image-style');
          ['Responsive image styles', 'Narrow', 'Original', 'Wide'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/config/media/file-settings');
          cy.contains('File settings');

          cy.visit('admin/config/media/image-toolkit');
          cy.contains('Image toolkit');

          cy.visit('admin/config/search/path');
          cy.contains('URL aliases');

          cy.visit('admin/config/search/search-api');
          cy.contains('Search API');

          cy.visit('admin/config/search/simplesitemap');
          cy.contains('Simple XML Sitemap');

          cy.visit('admin/config/search/redirect');
          cy.contains('Redirect');

          cy.visit('admin/config/search/facets');
          ['facets', 'search_api:views_page__pcrc_search_content__search_content', 'search_api:views_page__pcrc_studies_search__page_1'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/regional/settings');
          cy.contains('Regional settings');

          cy.visit('admin/config/regional/date-time');
          cy.contains('Date and time formats');

          cy.visit('admin/config/regional/name');
          ['Family', 'Full', 'Given', 'Given Family', 'Title Family'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

          cy.visit('admin/config/services/addtoany');
          cy.contains('AddToAny');

          cy.visit('admin/config/services/google-analytics');
          cy.contains('Google Analytics');

          cy.visit('admin/config/services/rss-publishing');
          cy.contains('RSS publishing');

          cy.visit('admin/reports/status');
          cy.contains('Status report');

        }
      })
    })
  });
});

