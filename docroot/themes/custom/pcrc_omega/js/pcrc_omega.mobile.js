(function($){
  $.fn.sfmobile = function(options){
    options = $.extend({
      mode: 'inactive',
      type: 'accordion',
      breakpoint: 1024,
      breakpointUnit: 'px',
      useragent: '',
      title: '',
      accordionButton: 1
    }, options);

    function mobile(menu){
      if ($('.menu-icon').length <= 0) {
        var menu_icon = '<div class="menu-icon"><i class="fa fa-bars"></i></div>';
        $('.region-header').append(menu_icon);
        $('#views-exposed-form-pcrc-search-content-search-content').clone().prependTo('#superfish-main-accordion');
        $('.menu-icon').on('click', function(e){
          e.preventDefault();
          $(this).find('.fa').toggleClass('fa-bars').toggleClass('fa-times');
          $('.sf-accordion-toggle a').trigger('click');
        });
      }
    }
    
    function notmobile(menu){
      $('.menu-icon').remove();
    }
    
    // Return original object to support chaining.
    // Although this is unnecessary because of the way the module uses these plugins.
    for (var s = 0; s < this.length; s++){
      var
      menu = $(this).eq(s),
      mode = options.mode;
      // The rest is crystal clear, isn't it? :)
      if (mode == 'always_active'){
        mobile(menu);
      }
      else if (mode == 'window_width'){
        var breakpoint = (options.breakpointUnit == 'em') ? (options.breakpoint * parseFloat($('body').css('font-size'))) : options.breakpoint,
        windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
        timer;
        if ((typeof Modernizr === 'undefined' || typeof Modernizr.mq !== 'function') && windowWidth < breakpoint){
          mobile(menu);
        }
        else if (typeof Modernizr !== 'undefined' && typeof Modernizr.mq === 'function' && Modernizr.mq('(max-width:' + (breakpoint - 1) + 'px)')) {
          mobile(menu);
        }
        $(window).resize(function(){
          clearTimeout(timer);
          timer = setTimeout(function(){
            var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            if ((typeof Modernizr === 'undefined' || typeof Modernizr.mq !== 'function') && windowWidth < breakpoint){
              mobile(menu);
            }
            else if (typeof Modernizr !== 'undefined' && typeof Modernizr.mq === 'function' && Modernizr.mq('(max-width:' + (breakpoint - 1) + 'px)')) {
              mobile(menu);
            }
            else {
              notmobile(menu);
            }
          }, 50);
        });
      }
      else if (mode == 'useragent_custom'){
        if (options.useragent != ''){
          var ua = RegExp(options.useragent, 'i');
          if (navigator.userAgent.match(ua)){
            mobile(menu);
          }
        }
      }
      else if (mode == 'useragent_predefined' && navigator.userAgent.match(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i)){
        mobile(menu);
      }
    }
    return this;
  }
})(jQuery);


