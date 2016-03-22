jQuery(function($){

  $(".menu nav").menumaker({
    title: "Menu",
    format: "multitoggle"
  });

  $(".rslides").responsiveSlides({
    nav: true,
    pager: true
  });

  $(".fancybox").fancybox();

  $('.scrollup').click(function(){
    $("body, html").animate({ scrollTop: 0 }, 700);
    return false;
  }); 

  // Remove link from 'empty links'
  $(".menu nav > ul > li a").each(function(){
    if( $(this).attr('href')=='#' ){
      $(this).removeAttr('href');
      $(this).css('cursor', 'pointer');
    }
  });

  $('.header select[name="your-unidade"]').change(function(){
    var o = $(this).val();
    if (o!="" && o!=0) {
      window.location.href = o;
    }
  });

  $('a[href*="#"]').on('click', function(e) {
          // prevent default action and bubbling
      e.preventDefault();
      e.stopPropagation();
      // set target to anchor's "href" attribute
      var target = $(this).attr('href');
      // scroll to each target
      $(target).velocity('scroll', {
          duration: 500,
          offset: -40,
          easing: 'ease-in-out'
      });
  });

  /*
  * Input Masks
  */
  {
    // Phone
    $("input[name*='your-cpf']").setMask({mask: "999.999.999-99"});
    $("input[name*='your-phone']").setMask({mask: "(99) 9999-9999"});
    $("input[name*='your-phone']").keyup(function () {
      var t = $(this),
          n = t.val();
      if ( n[5] == "9" ) {
        t.setMask({mask: "(99) 999999999"});
      } else {
          t.setMask({mask: "(99) 9999-9999"});
      }
    }); // end Phone
  }


  /*
  * Apply Fancybox for images in posts
  */
  $("img[class*='wp-image-']").each(function(){
    var o = $(this), // img
        p = o.parent('a'), // a
        l = p.attr('href'), // Link to match
        r = /(.jpg|.png|.jpeg|.gif)+/igm; // Regex to match

    if (!p.hasClass('fancybox') && r.test(l)) {
      p.addClass('fancybox');
    }
  });

  /*
  * Stick header menu at top (just for mobile)
  */
  {
    // function stickAdjustMenu(){
    //   ww = document.body.clientWidth;
    //   if (ww < 768) {
    //     $(".header nav").stick({'cssStick':{
    //       'margin' : '0',
    //       'background' : '#f7c51e',
    //       'width' : $(".container").width(),
    //     }});
    //   }
    // }
    
    // stickAdjustMenu();

    // $(window).bind('resize orientationchange', stickAdjustMenu() );    
  }


  /*
  * Accordion
  */
  {
    // var allPanels = $('.accordion > dt');
    // if( allPanels.length ) {
    //   var allPanelsContent = $('.accordion > dd').hide();

    //   // allPanels.first().addClass('active');
    //   // allPanelsContent.first().show();

    //   $('.accordion > dt > a').click(function() {
    //       $this   =  $(this);
    //       $parent =  $this.parent();
    //       $target =  $parent.next();

    //       if(!$parent.hasClass('active')) {
    //          allPanels.removeClass('active');
    //          allPanelsContent.slideUp();
    //          $parent.addClass('active');
    //          $target.slideDown();
    //       } else {
    //         $parent.removeClass('active');
    //         $target.slideUp();
    //       }
          
    //     return false;
    //   });  
    // }
  }

});
