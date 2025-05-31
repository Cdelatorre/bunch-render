  /*============== Main Js Start ========*/

(function ($) {
  "use strict";

  (function( $ ){
    $.fn.mySelectDropdown = function(options) {
      return this.each(function() {
        var $this = $(this);
        $this.each(function () {
          var dropdown = $("<div />").addClass("f-dropdown selectDropdown");
          if($(this).is(':disabled'))
            dropdown.addClass('disabled');
          $(this).wrap(dropdown);
          var label = $("<span />").append($("<span />")
            .text($(this).attr("placeholder"))).insertAfter($(this));
          var list = $("<ul />");
          $(this)
            .find("option")
            .each(function () {
              var image = $(this).data('image');
              if(image) {
                list.append($("<li />").append(
                  $("<a />").attr('data-val',$(this).val())
                  .html(
                    $("<span />").append($(this).text())
                  ).prepend('<img src="'+image+'">')
                ));
              } else if($(this).val() != '') {
                list.append($("<li />").append(
                  $("<a />").attr('data-val',$(this).val())
                  .html(
                    $("<span />").append($(this).text())
                  )
                ));
              }
            });
          list.insertAfter($(this));
          if ($(this).find("option:selected").length > 0 && $(this).find("option:selected").val() != '') {
            list.find('li a[data-val="' + $(this).find("option:selected").val() + '"]').parent().addClass("active");
            $(this).parent().addClass("filled");
            label.html(list.find("li.active a").html());
          }
        });
        if(!$(this).is(':disabled')) {
          $(this).parent().on("click", "ul li a", function (e) {
            e.preventDefault();
            var dropdown = $(this).parent().parent().parent();
            var active = $(this).parent().hasClass("active");
            var label = active
              ? $('<span />').text(dropdown.find("select").attr("placeholder"))
              : $(this).html();
            dropdown.find("option").prop("selected", false);
            dropdown.find("ul li").removeClass("active");
            dropdown.toggleClass("filled", !active);
            dropdown.children("span").html(label);
            if (!active) {
              dropdown
                .find('option[value="' + $(this).attr('data-val') + '"]')
                .prop("selected", true);
              $(this).parent().addClass("active");
            }
            dropdown.removeClass("open");
          });
          $this.parent().on("click", "> span", function (e) {
            var self = $(this).parent();
            self.toggleClass("open");
          });
          $(document).on("click touchstart", function (e) {
            var dropdown = $this.parent();
            if (dropdown !== e.target && !dropdown.has(e.target).length) {
              dropdown.removeClass("open");
            }
          });
        }
      });
    };
  })( jQuery );
  $('select.f-dropdown').mySelectDropdown();




  /*======= Select with image js =========*/

//test for iterating over child elements
var langArray = [];
$('.vodiapicker option').each(function(){
  var img = $(this).attr("data-thumbnail");
  var text = this.innerText;
  var value = $(this).val();
  var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
  langArray.push(item);
})

$('#a').html(langArray);

//Set the button value to the first el of the array
$('.btn-select').html(langArray[0]);
$('.btn-select').attr('value', 'en');

//change button stuff on click
$('#a li').on( 'click', function(){
   var img = $(this).find('img').attr("src");
   var value = $(this).find('img').attr('value');
   var text = this.innerText;
   var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
  $('.btn-select').html(item);
  $('.btn-select').attr('value', value);
  $(".b").toggle();
  //console.log(value);
});

$(".btn-select").on( 'click', function(){
        $(".b").toggle();
    });

//check local storage for the lang
var sessionLang = localStorage.getItem('lang');
if (sessionLang){
  //find an item with value of sessionLang
  var langIndex = langArray.indexOf(sessionLang);
  $('.btn-select').html(langArray[langIndex]);
  $('.btn-select').attr('value', sessionLang);
} else {
   var langIndex = langArray.indexOf('ch');

  $('.btn-select').html(langArray[langIndex]);
  //$('.btn-select').attr('value', 'en');
}


  /*============== Header Hide Click On Body Js ========*/
  $('.navbar-toggler.header-button').on('click', function() {
    if($('.body-overlay').hasClass('show')){
      $('.body-overlay').removeClass('show');
    }else{
      $('.body-overlay').addClass('show');
    }
  });
  $('.body-overlay').on('click', function() {
    $('.header-button').trigger('click');
  });

  /* ==========================================
  *     Start Document Ready function
  ==========================================*/
  $(document).ready(function () {
    "use strict"
   /* ========================= Odometer Counter Js Start ========== */
   if ($(".odometer").length) {
    var odo = $(".odometer");
    odo.each(function () {
      $(this).appear(function () {
        var countNumber = $(this).attr("data-count");
        $(this).html(countNumber);
      });
    });
  }

    /*================== Password Show Hide Js ==========*/
    $(".toggle-password-change").on( 'click', function() {
      var targetId = $(this).data("target");
      var target = $("#" + targetId);
      var icon = $(this);
      if (target.attr("type") === "password") {
          target.attr("type", "text");
          icon.removeClass("fa-eye-slash");
          icon.addClass("fa-eye");
      } else {
          target.attr("type", "password");
          icon.removeClass("fa-eye");
          icon.addClass("fa-eye-slash");
      }
  });

    /*================== Show Login Toggle Js ==========*/
    $('#showlogin').on('click', function () {
      $('#checkout-login').slideToggle(700);
    });

    /*================== Show Coupon Toggle Js ==========*/
    $('#showcupon').on('click', function () {
      $('#coupon-checkout').slideToggle(400);
    });

    /*============** Mgnific Popup **============*/
    $(".image-popup").magnificPopup({
      type: "image",
      gallery: {
          enabled: true,
      },
    });

    $('.popup_video').magnificPopup({
        type: 'iframe',
    });

    /*========================= Slick Slider Js Start ==============*/
    $('.winner-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: false,
      pauseOnHover: false,
      arrows: false,
      responsive: [
          {
            breakpoint: 1199,
            settings: {
              arrows: false,
              slidesToShow: 4,
              dots: false,
            }
          },
          {
            breakpoint: 991,
            settings: {
              arrows: false,
              slidesToShow: 3
            }
          },
          {
            breakpoint: 767,
            settings: {
              arrows: false,
              slidesToShow: 2
            }
          },
          {
            breakpoint: 570,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          }
        ]
    });
    /*========================= Slick Testimonial Slider Js Start ==============*/
    $('.testimonial-slider').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: false,
      pauseOnHover: false,
      arrows: false,
      responsive: [
          {
            breakpoint: 1199,
            settings: {
              arrows: false,
              slidesToShow: 3,
              dots: false,
            }
          },
          {
            breakpoint: 991,
            settings: {
              arrows: false,
              slidesToShow: 2
            }
          },
          {
            breakpoint: 767,
            settings: {
              arrows: false,
              slidesToShow: 2
            }
          },
          {
            breakpoint: 570,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          }
        ]
    });

  /* ========================= Related Product Slider Js Start ===============*/
  $('.related-procuct-slider').slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 1000,
    pauseOnHover: true,
    speed: 2000 ,
    dots: false,
    arrows: false,
    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
    responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow:2,
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1
          }
        }
      ]
  });

  /* ========================= Product details Slider Js Start ===============*/
  $('.product-details-active').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 1000,
    pauseOnHover: true,
    speed: 2000 ,
    dots: false,
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
    responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow:1,
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1
          }
        }
      ]
  });

  /* ========================= Product Slider active Js Start ===============*/
  $('.product-slider-active').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 1000,
    pauseOnHover: true,
    speed: 2000 ,
    dots: false,
    arrows: false,
    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
    responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow:1,
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1
          }
        }
      ]
  });

  /*======================= Mouse hover Js Start ============*/
    $('.mousehover-item').on('mouseover', function() {
      $('.mousehover-item').removeClass('active')
      $(this).addClass('active')
    });

    /*================== Sidebar Menu Js Start =============== */
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").on( 'click', function() {
      $(".sidebar-submenu").slideUp(200);
      if (
        $(this)
          .parent()
          .hasClass("active")
      ) {
        $(".has-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }
    });

    /*==================== Sidebar Icon & Overlay js ===============*/
      $(".dashboard-body__bar-icon").on("click", function() {
        $(".sidebar-menu").addClass('show-sidebar');
        $(".sidebar-overlay").addClass('show');
      });
      $(".sidebar-menu__close, .sidebar-overlay").on("click", function() {
        $(".sidebar-menu").removeClass('show-sidebar');
        $(".sidebar-overlay").removeClass('show');
      });

    /*================= Increament & Decreament Js Start ======*/
      const productQty = $(".product-qty");
      productQty.each(function () {
        const qtyIncrement = $(this).find(".product-qty__increment");
        const qtyDecrement = $(this).find(".product-qty__decrement");
        let qtyValue = $(this).find(".product-qty__value");
        qtyIncrement.on("click", function () {
          var oldValue = parseFloat(qtyValue.val());
          var newVal = oldValue + 1;
          qtyValue.val(newVal).trigger("change");
        });
        qtyDecrement.on("click", function () {
          var oldValue = parseFloat(qtyValue.val());
          if (oldValue <= 0) {
            var newVal = oldValue;
          } else {
            var newVal = oldValue - 1;
          }
          qtyValue.val(newVal).trigger("change");
        });
      });

    /*======================= Event Details Like Js Start =======*/
    $('.hit-like').each(function() {
      $(this).on('click', function() {
        $(this).toggleClass('liked')
      });
    });

    /*============** Number Increment Decrement **============*/
      $(".add").on("click", function () {
        if ($(this).prev().val() < 999) {
          $(this)
            .prev()
            .val(+$(this).prev().val() + 1);
        }
      });
      $(".sub").on("click", function () {
        if ($(this).next().val() > 1) {
          if ($(this).next().val() > 1)
            $(this)
            .next()
            .val(+$(this).next().val() - 1);
        }
      });

    /* =================== User Profile Upload Photo Js Start ========== */
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#imagePreview').css('background-image', 'url('+e.target.result +')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function() {
      readURL(this);
    });

  });



 /*==================== Add scroll-based animation ===============*/
document.addEventListener("DOMContentLoaded", function () {
  window.addEventListener('scroll', function () {
      const sections = document.querySelectorAll('section');
      sections.forEach(section => {
          const rect = section.getBoundingClientRect();
          const isVisible = (rect.top <= window.innerHeight * 0.8 && rect.bottom >= 0);
          if (isVisible) {
              section.style.opacity = "1";
              section.style.transform = "translateY(0)";
              section.style.transition = ".6s all";
          } else {
              section.style.opacity = "0";
              section.style.transform = "translateY(20px)";
              section.style.transition = ".6s all";
          }
      });
  });
});


  /*==========================================
  *      End Document Ready function
  // ==========================================*/

  /*========================= Preloader Js Start =====================*/

    $(window).on("load", function(){
      $("#loading").fadeOut();
      document.documentElement.classList.toggle('scrollDisabled', false);

      if($(document).width() < 991) {
        $('.header').addClass('fixed-header');
      }
    })


    /*========================= Header Sticky Js Start ==============*/
    $(window).on('scroll', function() {
      if($(document).width() < 991) {
        $('.header').addClass('fixed-header');
      } else {
        if ($(window).scrollTop() >= 300) {
          $('.header').addClass('fixed-header');
        }
        else {
            $('.header').removeClass('fixed-header');
        }
      }
    });

    /*============================ Scroll To Top Icon Js Start =========*/
    var btn = $('.scroll-top');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');

    });

  /*============================ Header Search =========*/
  $('.header-search-icon').on('click', function() {
      $('.header-search-hide-show').addClass('show');
      $('.header-search-icon').hide();
      $('.close-hide-show').addClass('show');
  });

  $('.close-hide-show').on('click', function() {
    $('.close-hide-show').removeClass('show');
    $('.header-search-hide-show').removeClass('show');
    $('.header-search-icon').show();
  });



  /*============================ header menu show hide =========*/
  $('.sidebar-menu-show-hide').on('click', function() {
    if($(document).width() < 991) {
      $('.sidebar-menu-wrapper').addClass('show');
      $(".sidebar-overlay").addClass('show');
      document.documentElement.classList.toggle('scrollDisabled', true);
    }

});

  $('.sidebar-overlay, .close-hide-show').on('click', function() {
    $('.sidebar-menu-wrapper').removeClass('show');
    $(".sidebar-overlay").removeClass('show');
      document.documentElement.classList.toggle('scrollDisabled', false);
});

  /*============================ Dashboard Menu show hide =========*/
  $('.dashboard-show-hide').on('click', function() {
    $('.dashboard_profile').addClass('show');
    $(".sidebar-overlay").addClass('show');
});

  $('.sidebar-overlay, .close-hide-show').on('click', function() {
    $('.dashboard_profile').removeClass('show');
    $(".sidebar-overlay").removeClass('show');
});



function proPicURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          var preview = $(input).parents('.thumb').find('.profilePicPreview');
          $(preview).css('background-image', 'url(' + e.target.result + ')');
          $(preview).addClass('has-image');
          $(preview).hide();
          $(preview).fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
  }
}
$(".profilePicUpload").on('change', function () {
  proPicURL(this);
});

$(".remove-image").on('click', function () {
  $(this).parents(".profilePicPreview").css('background-image', 'none');
  $(this).parents(".profilePicPreview").removeClass('has-image');
  $(this).parents(".thumb").find('input[type=file]').val('');
});



})(jQuery);


