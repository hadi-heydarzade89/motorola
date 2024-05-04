/**
  * Theme Js file.
**/

jQuery('document').ready(function($){
  setTimeout(function () {
    jQuery(".loader").fadeOut("slow");
  },1000);
});

jQuery(function($){
  $(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {
      $('#return-to-top').fadeIn(200);
    } else {
      $('#return-to-top').fadeOut(200);
    }
  });
  $('#return-to-top').click(function() {
    $('body,html').animate({
      scrollTop : 0
    }, 500);
  });
});

// AOS.init();
jQuery(document).ready(function() {
  AOS.init({
    mirror: false,
    once: true,
    disable: function () {
        var maxWidth = 1024;
        return window.innerWidth < maxWidth;
    },
  });

  var clock_date = jQuery("#banner-clock").data('date')

  jQuery('#banner-clock').countdown(clock_date).on('update.countdown', function(event) {
  var $this = jQuery(this).html(event.strftime(''
    + '<div class="countdown-box"><span class="countdown-block">%-D</span>  </div>'
    + '<div class="countdown-box"><span class="countdown-block">%H</span> </div>'
    + '<div class="countdown-box"><span class="countdown-block">%M</span> </div> '
    + '<div class="countdown-box"><span class="countdown-block">%S</span> </div>'));
  });

});

document.addEventListener('readystatechange', event => {
  if (event.target.readyState === "complete") {
      var clockdiv = document.getElementsByClassName("clockdiv");
      var countDownDate = new Array();
      for (var i = 0; i < clockdiv.length; i++) {
          countDownDate[i] = new Array();
          countDownDate[i]['el'] = clockdiv[i];
          countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
          countDownDate[i]['days'] = 0;
          countDownDate[i]['hours'] = 0;
          countDownDate[i]['seconds'] = 0;
          countDownDate[i]['minutes'] = 0;
      }

      var countdownfunction = setInterval(function() {
        for (var i = 0; i < countDownDate.length; i++) {
            var now = new Date().getTime();
            var distance = countDownDate[i]['time'] - now;
            countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
            countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance < 0) {
                // document.getElementsByClassName("product_countdown").style.display = "none";
                // // countDownDate[i]['el'].querySelector('.days').innerHTML = 0;
                // // countDownDate[i]['el'].querySelector('.hours').innerHTML = 0;
                // // countDownDate[i]['el'].querySelector('.minutes').innerHTML = 0;
                // // countDownDate[i]['el'].querySelector('.seconds').innerHTML = 0;
            } else {
                countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'];
                countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'];
                countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'];
                countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'];
            }

          }
      }, 1000);
  }
});


// ===== Product ====

jQuery('document').ready(function(){
  var owl = jQuery('#product .owl-carousel');
    owl.owlCarousel({
    margin:20,
    nav: true,
    autoplay : true,
    lazyLoad: true,
    autoplayTimeout: 3000,
    loop: true,
    dots:false,
    navText : ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 2
      },
      1000: {
        items: 3
      },
      1200: {
        items: 3
      }
    },
    autoplayHoverPause : true,
    mouseDrag: true
  });
});

// ===== Mobile responsive Menu ====

function pharmacy_shop_menu_open_nav() {
  jQuery(".sidenav").addClass('open');
}
function pharmacy_shop_menu_close_nav() {
  jQuery(".sidenav").removeClass('open');
}
