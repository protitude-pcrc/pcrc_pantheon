/**
 * @file
 * PCRC plugin.
 *
 * @ignore
 */

(function ($, Drupal, drupalSettings, CKEDITOR) {

  'use strict';

  CKEDITOR.plugins.add('remlink', {
    init: function (editor) {
      
      // If the "menu" plugin is loaded, remove duplicate link.
      if (editor.addMenuItems) {
        //editor.removeMenuItems('link');
      }

    }
  });
  
})(jQuery, Drupal, drupalSettings, CKEDITOR);