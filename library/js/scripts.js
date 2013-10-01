/*
Bones Scripts File
Author: Eddie Machado

This file should contain any js scripts you want to add to the site.
Instead of calling it in the header or throwing it inside wp_head()
this file will be called automatically in the footer so as not to
slow the page load.

*/

// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        };
        return this;
    };
}


// as the page loads, call these scripts
jQuery(document).ready(function($) {

    var $win = $(window),
        $container = $('.grid-container'),
        $imgs = $("img.lazyload");

    //LAZY LOAD
    $imgs.lazyload({ 
    effect : "fadeIn",
    failure_limit : Math.max($imgs.length - 1, 0)
    });

    //RESPONSIVE NAV
    var navigation = responsiveNav("#menu-main", {
        animate: true,        // Boolean: Use CSS3 transitions, true or false
        transition: 400,      // Integer: Speed of the transition, in milliseconds
        label: "Meny",        // String: Label for the navigation toggle
        insert: "after",      // String: Insert the toggle before or after the navigation
        customToggle: "",     // Selector: Specify the ID of a custom toggle
        openPos: "relative",  // String: Position of the opened nav, relative or static
        jsClass: "js",        // String: 'JS enabled' class which is added to <html> el
        init: function(){},   // Function: Init callback
        open: function(){},   // Function: Open callback
        close: function(){}   // Function: Close callback
      });
    
    //CHOSEN AND ISOTOPE FILTERING
    $(".chosen-select").chosen().change(function() {
        var select_parent = '';
        var selected_titles = $("#titles").val();
        var selected_writers = $("#writers").val();
        var selected_genres = $("#genres").val();

        if (selected_titles === null) {selected_titles = '';}
        if (selected_writers === null) {selected_writers = '';}
        if (selected_genres === null) { selected_genres = '';}

        var all_filters = select_parent.concat(selected_titles, selected_writers, selected_genres);

        var hashvalue = $.param({ filter: all_filters });
        $.bbq.pushState( hashvalue );

        //$(".textwidget").html(all_filters);

        if (all_filters === '') {$container.isotope({ filter: '*' });}
        else{$container.isotope({ filter: all_filters });}
    });

    //ISOTOPE CONFIG
    $container.isotope({
      // options
      itemSelector : '.grid-item',
      layoutMode : 'fitRows',
      onLayout: function() {
        $win.trigger("scroll");
      },

      getSortData : {
                        title : function ( $elem ) {
                          return $elem.find('h3').text();
                        },
                        writer : function ( $elem ) {
                          return $elem.find('.writer-tag').text();
                        },
                        genre : function ( $elem ) {
                          return $elem.find('.genre-tag').text();
                        },
                        date : function ( $elem ) {
                            return parseInt( $elem.find('.date').text(), 10 );
                          }
        }
    });

    $('.sort-by a').not( "#sort-book" ).click(function() {
                
                //Set vars
                if ($('.sort-order a').first().hasClass('asc')) {var sort_order = true;} else {var sort_order = false;};
                var sortName = $(this).attr('href').slice(1);

                //Make only this link active
                $('.sort-by li').removeClass('active');
                $(this).parent().addClass('active');

                //Sort
                $container.isotope({ sortBy : sortName, sortAscending : sort_order });
                    //Add to hash
                    var hashvalue = $.param({ sortBy: sortName });
                    $.bbq.pushState( hashvalue );

                //ignore default link behaviour
                return false;
            }
    );

    $('.title,.writer,.genre').click(function(){
        //Cycle trough classes when clicking                             
        this.className = {genre : 'title', title: 'writer', writer: 'genre'}[this.className];

        //Set vars
        if ($('.sort-order a').first().hasClass('asc')) {var sort_order = true;} else {var sort_order = false;};

        //Make only this link active
        $('.sort-by li').removeClass('active');
        $(this).parent().addClass('active');

        //Conditional Sorting
        if ($(this).hasClass('title')) {
                sortName = 'title';
                $container.isotope({ sortBy : sortName, sortAscending : sort_order });
                $(this).html('Titel');
                $(this).attr('href','#'+sortName);
                //Add to hash
                var hashvalue = $.param({ sortBy: sortName });
                $.bbq.pushState( hashvalue );
        };
        if ($(this).hasClass('writer')) {
                sortName = 'writer';
                $container.isotope({ sortBy : sortName, sortAscending : sort_order });
                $(this).html('Författare');
                $(this).attr('href','#'+sortName);
                //Add to hash
                var hashvalue = $.param({ sortBy: sortName });
                $.bbq.pushState( hashvalue );
        };
        if ($(this).hasClass('genre')) {
                sortName = 'genre';
                $container.isotope({ sortBy : sortName, sortAscending : sort_order });
                $(this).html('Genre');
                $(this).attr('href','#'+sortName);
                //Add to hash
                var hashvalue = $.param({ sortBy: sortName });
                $.bbq.pushState( hashvalue );
        };

        //ignore default link behaviour
        return false;
    });


    $('.sort-order a').toggle(function() {
                var sortName = $('.sort-by li.active a').first().attr('href').slice(1);
                $(this).removeClass('desc');
                $(this).addClass('asc');
                $container.isotope({ sortBy : sortName, sortAscending : true });
                $(this).html('Fallande');
            },
               function () {
                var sortName = $('.sort-by li.active a').first().attr('href').slice(1);
                $(this).removeClass('asc');
                $(this).addClass('desc');
                $container.isotope({ sortBy : sortName, sortAscending : false });
                $(this).html('Stigande');
               }
    );


    $('.grid-item .tags a, .filter').click(function(){
                //Set vars
                var selector = $(this).attr('data-filter');
                var sortName = $('.sort-by li.active a').first().attr('href').slice(1);
                if ($('.sort-order a').first().hasClass('asc')) {var sort_order = true;} else {var sort_order = false;};

                //Filter
                $container.isotope({ filter: selector, sortBy : sortName, sortAscending : sort_order });
                    //Add to hash
                    var hashvalue = $.param({ filter: selector });
                    $.bbq.pushState( hashvalue );
                
                //Add to chosen select
                //$('#writers').val('häst');

                //ignore default link behaviour
                return false;
    });

//BOOK PLAYER (>481)
    
     //tabs
    $('#tabs .columns').columnize({
          columns  : 3,
          doneFunc : function(){
                        $( "#tabs" ).tabs({
                            active: 1,
                            show: function(event, ui) {
                                    var lastOpenedPanel = $(this).data("lastOpenedPanel");
                                    if (!$(this).data("topPositionTab")) {
                                        $(this).data("topPositionTab", $(ui.panel).position().top);
                                    }
                                    $(ui.panel).hide().fadeIn(250);
                                    if (lastOpenedPanel) {
                                        lastOpenedPanel.toggleClass("ui-tabs-hide").css("position", "absolute").css("top", "0").fadeOut(250, function() {
                                            $(this).css("position", "");
                                        });
                                    }
                                    $(this).data("lastOpenedPanel", $(ui.panel));
                                }
                        });
                        $('.excerpt-read-more').click(function(){
                            $( "#tabs" ).tabs({active:0});
                            return false;
                        });
        }
     });

    //playlist-nav
    $('.playlist-nav a').click(function(event){
        event.preventDefault();
        var selector = $(this).attr('href').slice(1);
        var aLink = $('.playlist.main li.'+selector+' a');
        
        $('.playlist-nav a').removeClass('active');
        $(this).addClass('active');

        $('.playlist.main li').hide();
        $('.playlist.main li#'+ selector).show();

        soundManager.pauseAll();
    });

    $('.playlist-nav .active').toggle(
            function(){
                soundManager.pauseAll();
            },

            function(){
                soundManager.resumeAll();
            }
        );



    /* getting viewport width */
    var responsive_viewport = $(window).width();
    
    /* if is below 481px */
    if (responsive_viewport < 481) {
    
    } /* end smallest screen */
    
    /* if is larger than 481px */
    if (responsive_viewport > 481) {
        
    } /* end larger than 481px */
    
    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {
    
        /* load gravatars */
        $('.comment img[data-gravatar]').each(function(){
            $(this).attr('src',$(this).attr('data-gravatar'));
        });
        
    }
    
    /* off the bat large screen actions */
    if (responsive_viewport > 1030) {
        
    }
    
	
	// add all your scripts here
	
 
}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
    var doc = w.document;
    if( !doc.querySelector ){ return; }
    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;
    if( !meta ){ return; }
    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true; }
    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false; }
    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
        if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );