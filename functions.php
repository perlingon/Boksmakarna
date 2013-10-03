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
  	wp_register_script( 'main', get_template_directory_uri() . '/library/js/compressed/_main.min.js', array( 'jquery' ), '', false );
  	wp_enqueue_script( 'main' );

  	if (is_single() || is_page()) {
  		wp_register_script( 'single', get_template_directory_uri() . '/library/js/compressed/_single.min.js', array( 'jquery' ), '', false );
  		wp_enqueue_script( 'single' );
  	}

  	if ( is_singular( array( 'book', 'episode' ) ) || is_post_type_archive('episode') ) {
	  	wp_register_script( 'soundmanager', get_template_directory_uri() . '/library/js/compressed/_soundmanager.min.js', array( 'jquery' ), '', false );
	  	wp_enqueue_script( 'soundmanager' );

	  	//Sound Manager Styles
	  	wp_register_style( 'sm2-player', get_stylesheet_directory_uri() . '/library/css/soundmanager/page-player.css', array(), '', 'all' );
	  	wp_register_style( 'flashblock', get_stylesheet_directory_uri() . '/library/css/soundmanager/flashblock.css', array(), '', 'all' );
	  	wp_enqueue_style( 'sm2-player' );
	  	wp_enqueue_style( 'flashblock' );
  	}


	if (is_home()) {
		wp_register_script( 'home', get_template_directory_uri() . '/library/js/compressed/_home.min.js', array( 'jquery' ), '', false );
  		wp_enqueue_script( 'home' );

		//Royal Slider Styles
  		wp_register_style( 'slider', get_stylesheet_directory_uri() . '/library/css/royalslider/royalslider.css', array(), '', 'all' );
  		wp_register_style( 'slider-skin', get_stylesheet_directory_uri() . '/library/css/royalslider/skins/boksmakarna/rs-bok.css', array(), '', 'all' );
		wp_enqueue_style( 'slider' );
		wp_enqueue_style( 'slider-skin' );
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
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
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

/**
 * get_columns_array
 *
 * Columns for the loop, single function interface (limited) 
 *
 * Copyright (c) 2011 hakre <http://hakre.wordpress.com/>, some rights reserved
 *
 * USAGE:
 *
 *   foreach(get_columns_array($post_count) as $column_count) :
 *     // column starts here
 *     while ($column_count--) : $the_query->the_post();
 *         // output your post
 *     endwhile;
 *     // column ends here
 *   endforeach;
 * 
 * @author hakre <http://hakre.wordpress.com/>
 * @see http://wordpress.stackexchange.com/q/9308/178
 */
function get_columns_array($totalCount, $columnSize) {
	$columns = array();
	$totalCount = (int) max(0, $totalCount);
	if (!$count)
		return $columns;	
	$columnSize = (int) max(0, $columnSize);
	if (!$columnSize)
		return $columns;
	($floor = (int) ($totalCount / $columnSize))
                && $columns = array_fill(0, $floor, $columnSize)
                ;
	($remainder = $totalCount % $columnSize)
		&& $columns[] = $remainder
		;
	return $columns;
}
 
/**
 * WP_Query_Columns
 *
 * Columns for the loop. 
 *
 * Copyright (c) 2011 hakre <http://hakre.wordpress.com/>, some rights reserved 
 * 
 * @author hakre <http://hakre.wordpress.com/>
 * @see http://wordpress.stackexchange.com/q/9308/178
 */
class WP_Query_Columns implements Countable, IteratorAggregate {
	/**
	 * column size
	 * @var int
	 */
	private $size;
	private $index = 0;
	private $query;
	public function __construct(WP_Query $query, $size = 10) {
		$this->query = $query;
		$this->size = (int) max(0, $size);
	}
	/**
	 * @return WP_Query
	 */
	public function query() {
		return $this->query;
	}
	private function fragmentCount($fragmentSize, $totalSize) {
		$total = (int) $totalSize;
		$size = (int) max(0, $fragmentSize);
		if (!$total || !$size)
			return 0;
		$count = (int) ($total / $size);
		$count * $size != $total && $count++;				
		return $count;
	}
	private function fragmentSize($index, $fragmentSize, $totalSize) {
		$index = (int) max(0, $index);
		if (!$index)
			return 0;
		$count = $this->fragmentCount($fragmentSize, $totalSize);
		if ($index > $count)
			return 0;
		return $index === $count ? ($totalSize - ($count-1) * $fragmentSize) : $fragmentSize;			
	}
	public function columnSize($index) {
		return $this->fragmentSize($index, $this->size, $this->query->post_count);
	}
	/**
	 * @see Countable::count()
	 * @return int number of columns
	 */
	public function count() {
		return $this->fragmentCount($this->size, $this->query->post_count);
	}
	/**
	 * @return array
	 */
	public function columns() {
		$count = $this->count();
		$array = $count ? range(1, $count) : array();
		return array_map(array($this, 'columnSize'), $array);
	}
	/**
	 * @see IteratorAggregate::getIterator()
	 * @return traversable columns
	 */
	public function getIterator() {
		return new ArrayIterator($this->columns());
	}
}
?>