(function($, Drupal) {
  
  Drupal.behaviors.matchHeights = {
    attach: function(context) {
      $('.path-frontpage .preface-outer-wrapper').matchHeight();
      $('.node--type-directory.node--view-mode-teaser').matchHeight();
    }
  };
  
  Drupal.behaviors.accordion = {
    attach: function(context, settings) {
      $(".accordion").accordion({ collapsible: true, autoHeight: false, heightStyle: "content", heightstyle: "content"});
    }
  };
  
  Drupal.behaviors.tabs = {
    attach: function(context, settings) {
      $(".sc-tabs").tabs({
        show: { effect: "fadeIn", duration: 500 }
      });
      $(".sc-tabs .ui-tabs-panel").once('wrap').wrapAll("<div class='sc-tabs-panels'></div>");
    }
  };
  
  Drupal.behaviors.toggle = {
    attach: function(context, settings) {
      $('.toggle h3.toggle-title').once('toggle').each(function(){
        $(this).append('<span class="ui-icon"></span>');
        $(this).next().addClass('ui-toggle-content').hide();
        $(this).click(function(){
          $(this).toggleClass('ui-state-active active').next().slideToggle();
        });
      });
    }
  };
  
  Drupal.behaviors.listInView = {
    attach : function(context) {
      $('ul').bind('inview', function (event, isVisible) {
        if (isVisible) {
          $(this).addClass('is-inview');
        } else {
          $(this).removeClass('is-inview');
        }
      });
    }
  };

  Drupal.behaviors.selectAll = {
    attach : function(context) {
      $('.select-switch').once('select').each(function(){
        $(this).click(function(e){
          $(this).toggleClass('all');
          var $checkboxes = $(this).siblings('.form-checkboxes');
          $checkboxes.find('.form-checkbox').prop('checked', $(this).hasClass('all'));
        });
      });
    }
  };
    
  Drupal.behaviors.areaClickThru = {
    attach: function (context, settings) {
      $('.view-pcrc-studies-search').once('clickthru').each(function(){
        $(this).find('table tr').each(function(){
          var link = $(this).find('.views-field-title a');
          var href = link.attr('href');
          var target = link.attr('target');
          if (typeof href != 'undefined'){
            $(this).click(function(e){
              e.preventDefault();
              if (typeof target != 'undefined') {
                window.open(href, target);
              } else {
                window.location.href = href;
              }
            });
          }
        });
      });    
    }
  }
  
  // Convert svg to png equivalents if not supported
  Drupal.behaviors.svgFallback = {
    attach: function (context, settings) {
      svgeezy.init(false, 'png');
    }
  };
  
  Drupal.behaviors.mobile = {
    attach: function (context, settings) {
      $.each(settings.superfish || {}, function (index, options) {
        var $menu = $('ul#' + options.id, context);
        if (options.plugins || false) {
          if (options.plugins.smallscreen || false) {
            $menu.sfmobile(options.plugins.smallscreen);
          }
        }
      });
    }
  };
  
  Drupal.behaviors.searchClick = {
    attach: function (context, settings) {
      $('#search-overlay-bkgd').addClass('ready');
      $('.search-overlay').once('search').each(function(){
        $('.pcrc-search-icon').click(function(){
          if ($('html').hasClass('lt-ie9')){
            window.location.href = 'search-results';
          } else {
            $('#search-overlay-bkgd').removeClass('hide');
            $('.search-overlay').addClass('show');
            // Autofocus on search input box
            //setTimeout(function(){$('#edit-search').focus();}, 1000);
          }
        });
        $('#views-exposed-form-pcrc-search-content-search-content .form-item-text').append('<button type="submit" class="search-button"><i class="fa fa-search"></i></button>');
        $('.search-overlay #views-exposed-form-pcrc-search-content-search-content .form--inline').append('<div class="search-close"><i class="fa fa-times"></i></div>');
        $('.search-close').click(function(){
          $('#search-overlay-bkgd').addClass('hide');
          $('.search-overlay').removeClass('show');
        });
      });
    }
  };
  
})(jQuery, Drupal);