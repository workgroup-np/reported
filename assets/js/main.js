jQuery(document).ready(function(){
    "use strict";

/* ==================================================================
                    Minified Header
================================================================== */
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 1) {
            $('.trd-header').addClass('minified');
        } else {
            $('.trd-header').removeClass('minified');
        }
    });

/* ==================================================================
                    Responsive Menu (Mobile)
================================================================== */
    $(".navbar-collapse").css({ 
        maxHeight: $(window).height() - $(".navbar-header").height() + "px" 
    });

/* ==================================================================
                    Same Height
================================================================== */
var mapWrapper = $('.trd-map-wrapper'),
    mapNextHeight = mapWrapper.next().outerHeight();

    $(window).resize(function() {
        if ($(this).width() < 768) {

           var sectionHeight = $(window).height() - 80;

            mapWrapper.css({
                height: sectionHeight,
            });
        } else {
            mapWrapper.css({
                height: mapNextHeight
            });
        }
    });
    
    $(window).trigger('resize');


});