<?php 
add_action( 'init', 'add_custom_post_types' );

function add_custom_post_types() {
        
        /**************************************************************/
        /************BOOKS POST TYPE********************************/
        /*************************************************************/
        
          $labels = array(
            'name' => __('Books', 'boksmakarna'),
            'singular_name' => __('Book', 'boksmakarna'),
            'add_new' => __('Add new', 'boksmakarna'),
            'add_new_item' => __('Add new Book', 'boksmakarna'),
            'edit_item' => __('Edit Book', 'boksmakarna'),
            'new_item' => __('New Book', 'boksmakarna'),
            'all_items' => __('All Books', 'boksmakarna'),
            'view_item' => __('View this book', 'boksmakarna'),
            'search_items' => __('Search Book', 'boksmakarna'),
            'not_found' =>  __('No books.', 'boksmakarna'),
            'not_found_in_trash' => __('No Books in the Trash', 'boksmakarna'),
            'menu_name' => __('Books', 'boksmakarna'),
        
          );
          $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'query_var' => true,
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'bocker'),
            'hierarchical' => false,
            'has_archive' => true,
            'menu_position' => 5,
            'menu_icon' => get_template_directory_uri().'/library/images/admin-icon-book.png',
            'supports' => array('title', 'editor', 'thumbnail' ),
        );
          register_post_type('book',$args);
        
          flush_rewrite_rules();

        /**************************************************************/
        /************EPISODES POST TYPE********************************/
        /*************************************************************/
        
          $labels = array(
            'name' => __('Episodes', 'boksmakarna'),
            'singular_name' => __('Episode', 'boksmakarna'),
            'add_new' => __('Add new', 'boksmakarna'),
            'add_new_item' => __('Add new Episode', 'boksmakarna'),
            'edit_item' => __('Edit Episode', 'boksmakarna'),
            'new_item' => __('New Episode', 'boksmakarna'),
            'all_items' => __('All Episodes', 'boksmakarna'),
            'view_item' => __('View this episode', 'boksmakarna'),
            'search_items' => __('Search Episodes', 'boksmakarna'),
            'not_found' =>  __('No episodes.', 'boksmakarna'),
            'not_found_in_trash' => __('No episodes in the Trash', 'boksmakarna'),
            'menu_name' => __('Episodes', 'boksmakarna'),
          );
          $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'query_var' => true,
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'fredagsintervjun'),
            'hierarchical' => false,
            'has_archive' => true,
            'menu_position' => 6,
            'menu_icon' => get_template_directory_uri().'/library/images/admin-icon-episode.png',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt','custom-fields' ),
            'taxonomies' => array('category', 'post_tag')
        );
          register_post_type('episode',$args);
        
          flush_rewrite_rules();

      /**************************************************************/
      /************PARTNERS POST TYPE********************************/
      /**************************************************************/
        
          $labels = array(
            'name' => __('Partners', 'boksmakarna'),
            'singular_name' => __('Partner', 'boksmakarna'),
            'add_new' => __('Add new', 'boksmakarna'),
            'add_new_item' => __('Add new Partner', 'boksmakarna'),
            'edit_item' => __('Edit Partner', 'boksmakarna'),
            'new_item' => __('New Partner', 'boksmakarna'),
            'all_items' => __('All Partners', 'boksmakarna'),
            'view_item' => __('View this partner', 'boksmakarna'),
            'search_items' => __('Search Partners', 'boksmakarna'),
            'not_found' =>  __('No partners.', 'boksmakarna'),
            'not_found_in_trash' => __('No partners in the Trash', 'boksmakarna'),
            'menu_name' => __('Partners', 'boksmakarna'),
          );
          $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'query_var' => true,
            'hierarchical' => false,
            'menu_position' => 7,
            'menu_icon' => get_template_directory_uri().'/library/images/admin-icon-partners.png',
            'supports' => array('title', 'thumbnail'),
        );
          register_post_type('partner',$args);
        
          flush_rewrite_rules();
}
?>