
var ww = document.body.clientWidth;

$(document).ready(function() {
  $(".nav-responsive li a").each(function() {
    if ($(this).next().length > 0) {
      $(this).addClass("parent");
    };
  })
  
  $(".mobile-nav").click(function(e) {
    e.preventDefault();

    if( $(this).hasClass('active') ) {
      $(".nav-responsive").slideUp();
      $(this).toggleClass("active");
      return false
    }
    
    $(".nav-responsive").slideDown();
    $(this).toggleClass("active");

  });

  adjustMenu();
})

$(window).bind('resize orientationchange', function() {
  ww = document.body.clientWidth;
  adjustMenu();
});

var adjustMenu = function() {
  if (ww < 768) {
    $(".mobile-nav").css("display", "inline-block");
    if (!$(".mobile-nav").hasClass("active")) {
      $(".nav-responsive").hide();
    } else {
      $(".nav-responsive").show();
    }
    $(".nav-responsive li").unbind('mouseenter mouseleave');
    $(".nav-responsive li a.parent").unbind('click').bind('click', function(e) {
      // must be attached to anchor element to prevent bubbling
      e.preventDefault();
      $(this).parent("li").toggleClass("hover");
    });
  } 
  else if (ww >= 768) {
    $(".mobile-nav").css("display", "none");
    $(".nav-responsive").show();
    $(".nav-responsive li").removeClass("hover");
    $(".nav-responsive li a").unbind('click');
    
    // $(".nav-responsive li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
    //   // must be attached to li so that mouseleave is not triggered when hover over submenu
    //   // $(this).toggleClass('hover', 1000, "easeOutSine");

    //   $(this).addClass("hover")
    //                    .delay(4500)
    //                    .queue(function() {
    //                        $(this).removeClass("hover");
    //                        $(this).dequeue();
    //                    });


    // });

  $(".nav-responsive li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
      // must be attached to li so that mouseleave is not triggered when hover over submenu
      $(this).toggleClass('hover');
    });


  //   $('.nav-responsive ul > li').on('mouseenter', function() {
  //     var obj = $(this);
  //     this.iid = setInterval(function() {
  //       console.log('Mouse on');
  //       obj.addClass('hover');
  //     }, 25);
  //   }).on('mouseleave', function(){
  //     console.log('Mouse off');
  //     $(this).delay(500).queue(function() {
  //       $(this).removeClass("hover");
  //       $(this).dequeue();
  //     });
  //     this.iid && clearInterval(this.iid);
  //   });

    // $(".nav-responsive ul ul li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
    //   // must be attached to li so that mouseleave is not triggered when hover over submenu
    //   console.log('ON sec');
    //   $(this).toggleClass('hover');
    // });
  }
}

