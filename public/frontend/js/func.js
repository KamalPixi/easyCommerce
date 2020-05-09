//Nested Dropdown Function
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass('show');
  
  
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass("show");
    });
  
  
    return false;
  });

//Owl carousel Function
$(document).ready(function(){
    $('.trendingSlider').owlCarousel({
        loop:true,
        margin:10,
        dots:false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:false
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:4,
                nav:false,
                loop:false
            }
        }
    });

    let trendingSlider = $('.trendingSlider');
    trendingSlider.owlCarousel();
    // Go to the next item
    $('.trendingSliderPrev').click(function() {
        trendingSlider.trigger('next.owl.carousel');
    });
    // Go to the previous item
    $('.trendingSliderNext').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        trendingSlider.trigger('prev.owl.carousel', [300]);
    });

  });