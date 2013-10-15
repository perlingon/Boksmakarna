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

    //GOOGLE EVENT TRACKING

    $("#slider a").each(function() {
        var href = $(this).attr("href");
        var target = $(this).attr("target");
        var text = $(this).text();
        if (window._gaq) {
        $(this).click(function(event) { // when someone clicks these links
            event.preventDefault(); // don't open the link yet
            _gaq.push(["_trackEvent", "Slider-Link-Clicks", "Clicked", href, , false]); // create a custom event
            setTimeout(function() { // now wait 300 milliseconds...
                window.open(href,(!target?"_self":target)); // ...and open the link as usual
            },300);
        });
        }
    });

    $(".playlist a").each(function() {
        var href = $(this).attr("href");
        var target = $(this).attr("target");
        var text = $(this).text();
        if (window._gaq) {
            _gaq.push(["_trackEvent", "Player Episodes", "Clicked", href, , false]); // create a custom event
        };
    });


    $(".buy-link").each(function() {
        var href = $(this).attr("href");
        var target = $(this).attr("target");
        var text = $(this).text();
        if (window._gaq) {
        $(this).click(function(event) { // when someone clicks these links
            event.preventDefault(); // don't open the link yet
            _gaq.push(["_trackEvent", "Buy Button", "Clicked", href, , false]); // create a custom event
            setTimeout(function() { // now wait 300 milliseconds...
                window.open(href,(!target?"_self":target)); // ...and open the link as usual
            },300);
        });
        };
    });


    //LOCAL SCROLL
    function scrollfx(){
        var scrollTop = $(window).scrollTop();
        if(scrollTop>600){
                      $('#scrolltop-btn').fadeIn(200);
            }
        else { 
            $('#scrolltop-btn').fadeOut(200);
         }
    }
    window.onscroll = scrollfx;
    
    $('.scroll').each(function() {
    thisHref = $(this).find('a').prop('href');
    thisTitle = $(this).find('a').attr('title');
    $(this).find('a').prop('href', thisHref + thisTitle);     
    });
    
    $.localScroll({ hash:true, axis:'y' });
    $.localScroll.hash();

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

        if (all_filters === '') {$container.isotope({ filter: '*' });
        }else{
            $container.isotope({ filter: all_filters });
        }
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
                          var name = 'Titel';
                          return $elem.find('h3').text();
                        },
                        writer : function ( $elem ) {
                          var name = 'Författare';
                          return $elem.find('.writer-tag').text();
                        },
                        genre : function ( $elem ) {
                          var name = 'Genre';
                          return $elem.find('.genre-tag').text();
                        },
                        date : function ( $elem ) {
                            var name = 'Datum';
                            return parseInt( $elem.find('.timestamp').text(), 10 );
                          }
        }
    });

    var sortby = $('.sort-by a').eq(0);

    var sortorder = $('.sort-order a').eq(0);

    var asc_term = ["Äldst > Nyast","A > Ö"];
    var desc_term = ["Nyast > Äldst","Ö > A"];

    sortby.click(function(){
        
        //Cycle trough classes when clicking         
        this.className = {date : 'title', title: 'writer', writer: 'genre', genre: 'date'}[this.className];
        //Set vars
        if (sortorder.hasClass('asc')) {var sort_order = true;} else {var sort_order = false;};

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
        if ($(this).hasClass('date')) {
                sortName = 'date';
                $container.isotope({ sortBy : sortName, sortAscending : sort_order });
                $(this).html('Datum');
                $(this).attr('href','#'+sortName);
                //Add to hash
                var hashvalue = $.param({ sortBy: sortName });
                $.bbq.pushState( hashvalue );

                //sort-order terms
                sortorder.parent().removeClass('abc');
                sortorder.parent().addClass('date');
                if ( sortorder.hasClass("asc") ) {sortorder.html(asc_term[0]);}else{sortorder.html(desc_term[0]);};
        }else{
                //sort-order terms
                sortorder.parent().removeClass('date');
                sortorder.parent().addClass('abc');
                if ( sortorder.hasClass("asc") ) {sortorder.html(asc_term[1]);}else{sortorder.html(desc_term[1]);};
        };

        //ignore default link behaviour
        return false;
    });

    $('body').on('click', '.sort-order a', function(){
        if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') == 'off'){
                $(this).attr('data-toggled','on');
                var sortName = sortby.attr('href').slice(1);
                $(this).removeClass('desc');
                $(this).addClass('asc');
                $container.isotope({ sortBy : sortName, sortAscending : true });
                if (sortorder.parent().hasClass('date')) {
                    $(this).html(asc_term[0]);
                }else{
                    $(this).html(asc_term[1]);
                };
        }
        else if ($(this).attr('data-toggled') == 'on'){
               $(this).attr('data-toggled','off');
                var sortName = sortby.attr('href').slice(1);
                $(this).removeClass('asc');
                $(this).addClass('desc');
                $container.isotope({ sortBy : sortName, sortAscending : false });
                if (sortorder.parent().hasClass('date')) {
                    $(this).html(desc_term[0]);
                }else{
                    $(this).html(desc_term[1]);
                };
        }
        //ignore default link behaviour
        return false;
    });


    $('.grid-item .tags a, .filter').click(function(){
                //Set vars
                var selector = $(this).attr('data-filter');
                var sortName = $('.sort-by li a').first().attr('href').slice(1);
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


    $(window).bind( 'hashchange', function( event ){
      // get options object from hash
      var hashOptions = $.deparam.fragment();
      // apply options from hash
        $container.isotope( hashOptions );
        if (event.fragment == '') {
            $container.isotope({ filter: '*' });
        }else{
            $container.isotope( hashOptions );
            if (hashOptions.sortBy) {
                var sortName = hashOptions.sortBy;
                if (hashOptions.sortBy =='title') {var sortLabel = 'Titel'};
                if (hashOptions.sortBy =='writer') {var sortLabel = 'Författare'};
                if (hashOptions.sortBy =='genre') {var sortLabel = 'Genre'};
                if (hashOptions.sortBy =='date') {var sortLabel = 'Datum'};
                sortby.removeClass();
                sortby.addClass(sortName);
                sortby.attr('href','#'+sortName);
                sortby.html(sortLabel);
            };

        };
      
    })
      // trigger hashchange to capture any hash data on init
      .trigger('hashchange');


    function responsive_viewport(){

    /* getting viewport width */
    var responsive_viewport_width = $(window).width();
    console.log('width: '+responsive_viewport_width);

    //var els = $('.single-post .entry-content, .page-template-default .entry-content, #tabs .columns');
    var els = $('.single-post .entry-content, #tabs .columns');

    $('.single .entry-content p,.archive .entry-content p,.page-template-default .entry-content').addClass('sweet-justice');
    /* if is below 481px */
    if (responsive_viewport_width < 768) {
        $( ".media" ).hide();
        if (els.hasClass('columnized')) { 
            $('.column').each(function(){
               $(this).fadeOut(200, function(){
                    $(this).children().unwrap();
                    $(this).fadeIn(200);
               })
            });
            els.find('br').remove();

        }
    } /* end smallest screen */
    
    /* if is larger than 481px */
    if (responsive_viewport_width > 768) {
    $( ".media" ).show();
    if ($.fn.columnize) {
            if (!els.hasClass('columnized')) {
            els.columnize({
                columns  : 3,
                doneFunc : function(){
                    els.addClass('columnized');
                    els.find('p').removeClass('sweet-justice');
                    els.find('p').addClass('sweet-justice');
                    $( "#tabs" ).tabs({
                            active: -1,
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
                        $( "#tabs" ).tabs({active:-2});
                        return false;
                    });
                    $('.playlist-nav a').click(function(event){
                        event.preventDefault();
                        $( "#tabs" ).tabs({active:-1});
                        return false;
                    });
                }
            });
        };
    };
   
    //playlist-nav
    $('.playlist-nav a').click(function(event){
        event.preventDefault();
        var selector = $(this).attr('data');
        var aLink = $('.playlist.main li.'+selector+' a');
        
        $('.playlist-nav a').removeClass('active');
        $(this).addClass('active');
        $('.playlist-nav a.active').each(function(){
            $(this).toggleClass('playing');
        })

        $('.playlist.main li').hide();
        $('.playlist.main li#'+ selector).show();

        var href = $(this).attr("href");
        var target = $(this).attr("target");
        var text = $(this).text();
        if (window._gaq) {
        _gaq.push(["_trackEvent", "Playlist NavMenu", "Clicked", href, , false]); // create a custom event
        }
        return false;
    });
        
    } /* end larger than 481px */
    
    /* if is above or equal to 768px */
    if (responsive_viewport_width >= 768) {
    
        
    }
    
    /* off the bat large screen actions */
    if (responsive_viewport_width > 1030) {
        
    }
}

    responsive_viewport();
    
    $(window).resize(_.debounce(function(){
        responsive_viewport();
    }, 500));
	
	
 
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