jQuery(document).ready(function($) {
    //SLIDER

    $('#slider').royalSlider({
    arrowsNav: true,
    loop: false,
    keyboardNavEnabled: true,
    controlsInside: true,
    imageScaleMode: 'fit-if-smaller',
    imageScalePadding: 0,
    arrowsNavAutoHide: true,
    imageAlignCenter: true,
    //autoScaleSlider: true, 
    //autoScaleSliderWidth: 960,     
    //autoScaleSliderHeight: 390,
    controlNavigation: 'bullets',
    thumbsFitInViewport: false,
    //fadeinLoadedSlide: true,
    startSlideId: 0,
    addActiveClass: true,
    autoPlay: {
            enabled: true,
            pauseOnHover: true,
            delay: 5000
        },
    loopRewind: true,
    transitionType:'fade',
    transitionSpeed: 1000,
    globalCaption: false
  }).fadeIn(800);

  /*$('#slider').stop(true).fadeIn({
            duration: 800,
            queue: false
    }).css('display', 'none').slideDown(1000);*/
    
});