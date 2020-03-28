(function ($) {
    "user strict";
    // Preloader Js
    $(window).on('load', function () {
      $('.preloader').fadeOut(1000);
      // galleryMasonary();
      background();
      // galleryMasonaryTwo();
    });
    $(document).ready(function(){

      // Lightcase 
      $('a[data-rel^=lightcase]').lightcase();
      
      // Singer Slider
      // var swiper = new Swiper('.sponsor-slider', {
      //   slidesPerView: 3,
      //   spaceBetween: 0,
      //   loop: true,
      //   breakpoints: {
      //     768: {
      //       slidesPerView: 2,
      //     },
      //     576: {
      //       slidesPerView: 1,
      //     },
      //   },
      //   autoplay: {
      //       delay: 2500,
      //       disableOnInteraction: false,
      //   },
      // }); 


      // Testimonial Slider
      // var swiper = new Swiper('.testimonial-slider', {
      //   spaceBetween: 0,
      //   loop: true,
      //   autoplay: {
      //     delay: 3000,
      //     disableOnInteraction: false,
      //   },
      // });

      //wow.min.js
      // var wow = new WOW({
      //   boxClass: 'wow',
      //   animateClass: 'animated',
      //   offset: 0,
      //   mobile: true,
      //   live: true,
      //   callback: function (box) {},
      //   scrollContainer: null
      // });
      // wow.init();

      // counter 
      // $('.counter').countUp({
      //   'time': 1500,
      //   'delay': 10
      // });

      // Service Tab
      var tabWrapper = $('.service-tab-wrapper'),
        tabMnu = tabWrapper.find('.tab-menu  li'),
        tabContent = tabWrapper.find('.tab-content > .tab-item');
      tabContent.not(':first-child').hide();
      tabMnu.each(function (i) {
        $(this).attr('data-tab', 'tab' + i);
      });
      tabContent.each(function (i) {
        $(this).attr('data-tab', 'tab' + i);
      });
      tabMnu.on('click', function () {
        var tabData = $(this).data('tab');
        tabWrapper.find(tabContent).hide(0);
        tabWrapper.find(tabContent).filter('[data-tab=' + tabData + ']').show(0);
      });
      $('.tab-menu > li').on('click', function () {
        var before = $('.tab-menu li.active');
        before.removeClass('active');
        $(this).addClass('active');
      });
    });

    //Create Background Image
    function background() {
      var img = $('.bg_img');
      img.css('background-image', function () {
        var bg = ('url(' + $(this).data('background') + ')');
        return bg;
      });
    }

    //Menu Dropdown Icon Adding
    $("ul>li>.sub-menu").parent("li").addClass("menu-item-has-children");
    // drop down menu width overflow problem fix
    $('ul').parent().hover(function () {
      var menu = $(this).find("ul");
      var menupos = $(menu).offset();
      if (menupos.left + menu.width() > $(window).width()) {
        var newpos = -$(menu).width();
        menu.css({
          left: newpos
        });
      }
    });

    //MenuBar
    $(document).on('click', '.header-bar', function () {
      $(".menu").toggleClass("active");
      $(".header-bar").toggleClass("active");
    });

    //Mobile Menu Accordion
    $(".menu>li>a, .menu ul.sub-menu>li>a").on("click", function () {
        var element = $(this).parent("li");
        if (element.hasClass("open")) {
          element.removeClass("open");
          element.find("li").removeClass("open");
        }
        else {
          element.addClass("open");
          element.siblings("li").removeClass("open");
          element.siblings("li").find("li").removeClass("open");
        }
    });
      
    // Scroll To Top 
    var scrollToTop = $(".scrollToTop");
    $(window).on('scroll', function () {
      if ($(this).scrollTop() < 500) {
        scrollToTop.removeClass("active");
      } else {
        scrollToTop.addClass("active");
      }
    });
      
    //Isotope Masonary
    // function galleryMasonary(){
    //   $('.gallery-wrapper').isotope({
    //     itemSelector: '.gallery-item',
    //     masonry: {
    //       columnWidth: 0,
    //     }
    //   });
    // }
    // function galleryMasonaryTwo(){
    //   // filter functions
    //   var $grid = $(".project-masonary");
    //   var filterFns = {};
    //   $grid.isotope({
    //       itemSelector: '.project-item',
    //       masonry: {
    //         columnWidth: 0,
    //       }
    //   });
    //   // bind filter button click
    //   $('ul.filter').on('click', 'li', function () {
    //     var filterValue = $(this).attr('data-filter');
    //     // use filterFn if matches value
    //     filterValue = filterFns[filterValue] || filterValue;
    //     $grid.isotope({
    //       filter: filterValue
    //     });
    //   });
    //   // change is-checked class on buttons
    //   $('ul.filter').each(function (i, buttonGroup) {
    //     var $buttonGroup = $(buttonGroup);
    //     $buttonGroup.on('click', 'li', function () {
    //       $buttonGroup.find('.active').removeClass('active');
    //       $(this).addClass('active');
    //     });
    //   });
    // }

    var swiper = new Swiper('.blog-slider', {
      navigation: {
        nextEl: '.blog-next',
        prevEl: '.blog-prev',
      },
    });
    var swiper = new Swiper('.client-slider', {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      speed: 800,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      }, 
      pagination: {
        el: '.client-pagination',
        clickable: true,
      },
    });
      
    // Header Sticky Here
    var fixed_top_three = $(".header-bottom");
    $(window).on('scroll', function () {
      if ($(this).scrollTop() < 203) {
        fixed_top_three.removeClass("header-fixed");
      } else {
        fixed_top_three.addClass("header-fixed");
      }
    });

})(jQuery);