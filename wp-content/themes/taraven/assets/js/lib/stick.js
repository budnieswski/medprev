/*! jQuery Stick Plugin - v0.1.0 - 07/20/2015
 * Copyright (c) 2015 Guilherme Budnieswski*/
;(function( $ ){
$.fn.stick = function(options) {

  var defaults = {
    'footer' : '.footer',
    'cssStick' : {
      'position' : 'fixed',
      'top' : '0',
      'z-index' : '9999',
    },
  };
  
  var settings = $.extend(true, {}, defaults, options );
  
  __init = function(element) {

    // Static
    var posTopOriginal = element.position().top, // original Element position
        oldScroll = 0;

    var footerPos = $(document).outerHeight() - $(settings['footer']).outerHeight();
        footerPos = footerPos - (element.outerHeight(true)*2) - element.height();    

    $(window).scroll(function() {
      var newScroll   = $(window).scrollTop()-19,
          displaySize = $(window).height()
          posTop      = element.position().top,
          goingDown   = newScroll > oldScroll;
      
      // Ja passou pela posicao original do elemento
      // E nao chegou até o menu ainda
      if( newScroll >= posTopOriginal  && newScroll < footerPos  ){
        // Menu menor que o tamanho da tela
        // OU caso tenha sido maior, e o scroll tenha subido (para o menu nao ficar para baixo)
        if( element.outerHeight() < displaySize || newScroll < posTop ) {
          element.attr("style", ""); // reset

          // Mantem a position fixed (para nao dar delay no arrastar)
          element.css(settings['cssStick']); // stick it  

        } else if( element.css('position')=='fixed' ) {
          // Menu maior que o display ...
          // Caso ainda nao seja absolute (primeira vez)
          // Se ja for, mantem a position absolute para o menu nao ficar fixado          
          element.css('position', 'absolute');
          element.css('top', newScroll+'px');  
        }

      }
      else if (newScroll >= footerPos) {
        if( element.css('position')=='fixed' ) {
          element.css(settings['cssStick']); // stick it
          element.css('position', 'absolute');
          element.css('top', newScroll+'px');  //set sticker above the footer 
        }
      }
      else element.attr("style", "");  //un-stick

      oldScroll = newScroll;

    });
  }; // end __init

  // Start the plugin
  this.each (function() {
    __init($(this));
  });

}; 
})( jQuery );
