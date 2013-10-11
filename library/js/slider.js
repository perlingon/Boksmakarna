jQuery(document).ready(function($) {
    
   function responsive_slider(){

    /*Functions*/
    function initSlider(selector){
        //SLIDER
        $(selector).royalSlider({
        arrowsNav: arrows,
        loop: false,
        keyboardNavEnabled: true,
        controlsInside: false,
        imageScaleMode: 'fit-if-smaller',
        imageScalePadding: 0,
        arrowsNavAutoHide: true,
        imageAlignCenter: true,
        autoScaleSlider: true, 
        autoScaleSliderWidth: 480,     
        autoScaleSliderHeight: 320,
        controlNavigation: 'bullets',
        thumbsFitInViewport: false,
        fadeinLoadedSlide: false,
        addActiveClass: true,
        autoPlay: {
                enabled: true,
                pauseOnHover: true,
                delay: delay,
                stopAtAction: true
            },
        loopRewind: true,
        transitionType: transtype,
        transitionSpeed: speed,
        globalCaption: false
      }).fadeIn(800);
    }
    var slider = $("#slider").data('royalSlider');

    function slidertimer(){
        $( ".slider-timer div" ).css('width','0');
        $( ".slider-timer div" ).animate({
               width: '100%'
        }, delay, "linear");

        $( "#slider" ).hover(
            function() {$( ".slider-timer div" ).stop();}, 
            function() {$( ".slider-timer div" ).animate({width: '100%'}, delay, "linear");
          }
        );
    }

    /* getting viewport width */
    var responsive_viewport_width = $(window).width();
    console.log('slider window width: '+responsive_viewport_width);

    /* if larger than 960 */
    if (responsive_viewport_width > 960) {
        var transtype = 'fade';
        var arrows = true;
        var speed = 1000;
        var delay = 5000;
        // change scale mode
        $('#slider').removeClass('small-slider');
        $('#slider').removeClass('medium-slider');
        $('#slider').addClass('big-slider');
        initSlider('#slider');
    }else if(responsive_viewport_width < 480){
        var transtype = 'move';
        var arrows = false;
        var autowidth = 480;
        var autoheight = 320;
        var speed = 500;
        var delay = 5000;
        $('#slider').removeClass('big-slider');
        $('#slider').removeClass('medium-slider');
        $('#slider').addClass('small-slider');
        initSlider('#slider');
    }else{
        var transtype = 'move';
        var arrows = true;
        var autoscale = true;
        var autowidth = 960;
        var autoheight = 390;
        var speed = 700;
        var delay = 5000;
        $('#slider').removeClass('big-slider');
        $('#slider').removeClass('small-slider');
        $('#slider').addClass('medium-slider');
        initSlider('#slider');
    }
    slidertimer();


}
responsive_slider();

$('.archive-list').royalSlider();

//SLIDER EVENTS

//slider.ev.on('rsAfterSlideChange', function() {slidertimer();});
//slider.ev.on('rsDragStart', function(event) {$( ".slider-timer" ).fadeOut(200);});
//$( ".rsArrow,.rsNav" ).on('click', function() {$( ".slider-timer" ).fadeOut(200);});

$(window).resize(_.debounce(function(){
    responsive_slider();
}, 500));
    
});