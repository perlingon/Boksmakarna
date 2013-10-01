<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' ); // if you remove this, bones will break
add_filter('show_admin_bar', '__return_false');
/*
2. Post Types & Taxonomies
*/
require_once( 'library/post-types.php' );
require_once( 'library/taxonomies.php' );
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
require_once( 'library/admin.php' ); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
require_once( 'library/translation/translation.php' ); // this comes turned off by default

//Grid archive function
require_once( 'library/grid-archive.php' );

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'admin-thumb', 60, 60, true );
add_image_size( 'grid-block', 250, 200, true );
add_image_size( 'cover', 620, 400, true );
add_image_size( 'big-slide', 960, 390, true );
add_image_size( 'preview-slide', 500, 240, true );
add_image_size( 'featured', 680, 380, true );
add_image_size( 'logo', 180, false );

/************* LAZY LOAD IMAGE TEMPLATE *************/
function lazyload_thumbnail($size){
	$tempimg = get_bloginfo('template_url') . "/library/images/blank.gif";
	$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size);
	$d_attr = array(
			'data-original'	=> $src[0],
			'src'	=> $tempimg,
			'class'	=> 'lazyload '.$size,
	);
	$ie7_attr = array(
			'src'	=> $src[0],
			'class'	=> 'ie7 '.$size,
	);
	the_post_thumbnail($size, $d_attr);
	//the_post_thumbnail($size, $ie7_attr);
}

/************* Episode Titles ***************/
function set_episode_title( $data , $postarr ) {
  if($data['post_type'] == 'episode') {
  	//http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_insert_post_data
    $tags = $postarr['tags_input'];
    $episode_title = implode(" ", $tags);
    $post_slug = sanitize_title_with_dashes ($episode_title,'','save');
    $post_slugsan = sanitize_title($post_slug);

    $data['post_title'] = $episode_title;
    $data['post_name'] = $post_slugsan;
  }
  return $data;
}
//add_filter( 'wp_insert_post_data' , 'set_episode_title' , '10', 2 );




/************* LIBRARIES ********************/
add_action( 'wp_enqueue_scripts', 'additional_libraries', 999 );
function additional_libraries() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  if (!is_admin()) {
  	wp_register_script( 'isotope', get_template_directory_uri() . '/library/js/libs/jquery.isotope.min.js', array( 'jquery' ), '', false );
  	wp_register_script( 'chosen', get_template_directory_uri() . '/library/js/libs/chosen.jquery.js', array( 'jquery' ), '', false );
	wp_register_script( 'responsive-nav', get_template_directory_uri() . '/library/js/libs/responsive-nav.min.js', array( 'jquery' ), '', false );
	wp_register_script( 'jquery BBQ', get_template_directory_uri() . '/library/js/libs/jquery.ba-bbq.min.js', array( 'jquery' ), '', false );
	wp_register_script( 'lazyload', get_template_directory_uri() . '/library/js/libs/jquery.lazyload.min.js', array( 'jquery' ), '', false );

  	wp_enqueue_script( 'isotope' );
  	wp_enqueue_script( 'chosen' );
  	wp_enqueue_script( 'responsive-nav' );
  	wp_enqueue_script( 'jquery BBQ' );
  	wp_enqueue_script( 'lazyload' );

  	//Sound Manager
  	if (is_single() || is_archive()) {
  	wp_register_script( 'sm2', get_template_directory_uri() . '/library/js/soundmanager/soundmanager2.js', '', '', false );
  	wp_register_script( 'sm2-player', get_template_directory_uri() . '/library/js/soundmanager/page-player.js', '', '', false );
  	wp_register_style( 'sm2-player', get_stylesheet_directory_uri() . '/library/css/soundmanager/page-player.css', array(), '', 'all' );
  	wp_register_style( 'flashblock', get_stylesheet_directory_uri() . '/library/css/soundmanager/flashblock.css', array(), '', 'all' );
  	wp_enqueue_script( 'sm2' );
  	wp_enqueue_script( 'sm2-player' );
  	wp_enqueue_style( 'sm2-player' );
  	wp_enqueue_style( 'flashblock' );
  	}
  	if (is_single()) {
  		wp_register_script( 'jquery-ui', get_template_directory_uri() . '/library/js/libs/jquery-ui-1.10.3.custom.min.js', array( 'jquery' ), '', false );
  		wp_register_script( 'js-columnizer', get_template_directory_uri() . '/library/js/libs/jquery.columnizer.js', array( 'jquery' ), '', false );
  		wp_enqueue_script( 'jquery-ui' );
  		wp_enqueue_script( 'js-columnizer' );
  	}

	if (is_home()) {
		//Royal Slider
  		wp_register_script( 'jquery easing', get_template_directory_uri() . '/library/js/libs/jquery.easing-1.3.js', array( 'jquery' ), '', false );
		wp_register_script( 'royalslider', get_template_directory_uri() . '/library/js/royalslider/jquery.royalslider.min.js', array( 'jquery' ), '', false );
		wp_register_script( 'slider', get_template_directory_uri() . '/library/js/royalslider/slider.js', array( 'jquery' ), '', false );
  		wp_register_style( 'royalslider', get_stylesheet_directory_uri() . '/library/css/royalslider/royalslider.css', array(), '', 'all' );
  		wp_register_style( 'royalslider-skin', get_stylesheet_directory_uri() . '/library/css/royalslider/skins/boksmakarna/rs-bok.css', array(), '', 'all' );
		wp_enqueue_script( 'jquery easing' );
  		wp_enqueue_script( 'royalslider' );
  		wp_enqueue_script( 'slider' );
		wp_enqueue_style( 'royalslider' );
		wp_enqueue_style( 'royalslider-skin' );
    }

  }
}



/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'push_spaces',
		'name' => __( 'Push Spaces', 'boksmakarna' ),
		'description' => __( 'Featured Content spaces on start.', 'boksmakarna' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer',
		'name' => __( 'The Footer', 'boksmakarna' ),
		'description' => __( 'The Footer.', 'boksmakarna' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* ARCHIVE MOD ************************/

function modify_query( $query ) {

	if ( is_post_type_archive('episode') && !is_admin() && is_main_query() ) {
	        set_query_var( 'tag', 'fredagsintervju' );
	        set_query_var( 'posts_per_page', 2 );
	    }
	if ( is_post_type_archive('book') && !is_admin() && is_main_query() ) {
	        set_query_var( 'posts_per_page', -1 );
	   }

	if ( is_home() && is_main_query() ) {
	        set_query_var( 'post_type', 'book' );
	        set_query_var( 'posts_per_page', 3 );
	    }
}

add_action( "pre_get_posts", "modify_query" );


/************* POST SLUG FUNCTION *****************/
function get_the_slug(){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}


/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bonestheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bonestheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!


?>