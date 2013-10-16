jQuery(document).ready(function($) {

        //SLIDER
        $('.archive-slider').royalSlider({
        arrowsNav: true,
        slidesOrientation: 'vertical',
        loop: false,
        keyboardNavEnabled: true,
        controlsInside: false,
        arrowsNavAutoHide: false,
        imageAlignCenter: true,
        controlNavigation: 'bullets',
        thumbsFitInViewport: false,
        fadeinLoadedSlide: false,
        addActiveClass: true,
        transitionType: 'move',
        globalCaption: false,
        autoHeight: true
      });

      var slider = $(".archive-slider").data('royalSlider');
      
      if (slider) {

          slider.removeSlide(0);

          if (slider.numSlides < 2) {
            $(".archive-slider div, .archive-slider ul").unwrap();
            $(".rsNavItem,.rsArrowIcn").remove();
          }

      }

});