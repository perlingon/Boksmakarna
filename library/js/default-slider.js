jQuery(document).ready(function($) {
        //SLIDER
        $('#archive-slider').royalSlider({
        arrowsNav: arrows,
        loop: false,
        keyboardNavEnabled: true,
        controlsInside: false,
        imageScaleMode: 'fit-if-smaller',
        imageScalePadding: 0,
        arrowsNavAutoHide: true,
        imageAlignCenter: true,
        autoScaleSlider: true, 
        autoScaleSliderWidth: 960,     
        autoScaleSliderHeight: 390,
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

});