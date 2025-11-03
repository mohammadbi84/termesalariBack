$(document).ready(function() {
  $().owlCarousel && ($(".owl-carousel.basic").length > 0 && $(".owl-carousel.basic").owlCarousel({
      margin: 30,
      stagePadding: 15,
      dotsContainer: $(".owl-carousel.basic").parents(".owl-container").find(".slider-dot-container"),
      responsive: {
          0: {
              items: 1
          },
          600: {
              items: 2
          },
          1000: {
              items: 3
          }
      }
  }).data("owl.carousel").onResize(), $(".owl-carousel.single").length > 0 && $(".owl-carousel.single").owlCarousel({
      margin: 30,
      items: 1,
      loop: !0,
      stagePadding: 15,
      dotsContainer: $(".owl-carousel.single").parents(".owl-container").find(".slider-dot-container")
  }).data("owl.carousel").onResize(), $(".owl-dot").click(function() {
      $($(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("to.owl.carousel", [$(this).index(), 300])
  }), $(".owl-prev").click(function(e) {
      e.preventDefault(), $($(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("prev.owl.carousel", [300])
  }), $(".owl-next").click(function(e) {
      e.preventDefault(), $($(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("next.owl.carousel", [300])
  }));

//------------------Termehsalari---------------------
$(".owl-carousel#carouselItems").owlCarousel({
    dots: false,
    nav:true,
    rtl: true,
    loop: false,
    items: 3,
    // lazyLoad: true,
    margin: 30,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause:true,
    smartSpeed:450,
    navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsiveClass:true,
    responsive:{
      0:{
        items:1,
        dots: true,
        nav:false,
      },
      500:{
          items:1,
          dots: true,
          nav:false,
      },
      700:{
        items:2,
        dots: true,
        nav:false,
      },

      1000:{
          items:3,
          dots: true,
          nav:false,
      },
      1200:{
          items:3,
      },
      1500:{
          items:3,
      }
    }
  });

  $(".owl-carousel#slideshow").owlCarousel({
    rtl: true,
    loop: false,
    dots: true,
    items: 1,
    autoplay: false,
    autoplayTimeout: 6000,
    autoplayHoverPause:true,
    animateOut: 'slideOutDown',
    animateIn: 'flipInX',
    smartSpeed:450,
    onTranslated: function() {
      // Update Magnify when slide changes
      $zoom.destroy().magnify();
    },
    afterMove: function() {
      setTimeout(function() {
        // Update Magnify when slide changes
        $zoom.destroy().magnify();
      }, 800); // This number should match paginationSpeed option
    }

  });
  // Initiate zoom
  var $zoom = $('.zoom').magnify();

});