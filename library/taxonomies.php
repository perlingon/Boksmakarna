<?php

add_action( 'init', 'add_custom_taxonomies', 0 );

function add_custom_taxonomies() {
    
    /*************************************************************/
    /*********** TAXONOMIES FOR BOOKS ****************************/
    /*************************************************************/

    register_taxonomy('writer', 'book', array(
        'hierarchical' => false,
        'labels' => array( 'name' => _x( 'Writer', 'taxonomy general name', 'boksmakarna' ),
        'singular_name' => _x( 'Writer', 'taxonomy singular name', 'boksmakarna' ),
        'search_items' => __( 'Search Writer', 'boksmakarna' ),
        'all_items' => __( 'All Writers', 'boksmakarna' ),
        'edit_item' => __( 'Edit writer', 'boksmakarna' ),
        'update_item' => __( 'Update Writer', 'boksmakarna' ),
        'add_new_item' => __( 'Add new Writer', 'boksmakarna' ),
        'new_item_name' => __( 'New Writer', 'boksmakarna' ),
        'menu_name' => __( 'Writer', 'boksmakarna' ), ),
        'rewrite' => array( 'slug' => 'writer'),
        'show_admin_column' => true,
        'show_tagcloud' => false,
    ));

    register_taxonomy('genre', 'book', array(
        'hierarchical' => false,
        'labels' => array( 'name' => _x( 'Genre', 'taxonomy general name', 'boksmakarna' ),
        'singular_name' => _x( 'Genre', 'taxonomy singular name', 'boksmakarna' ),
        'search_items' => __( 'Search Genre', 'boksmakarna' ),
        'all_items' => __( 'All Genres', 'boksmakarna' ),
        'edit_item' => __( 'Edit Genre', 'boksmakarna' ),
        'update_item' => __( 'Update Genre', 'boksmakarna' ),
        'add_new_item' => __( 'Add new Genre', 'boksmakarna' ),
        'new_item_name' => __( 'New Genre', 'boksmakarna' ),
        'menu_name' => __( 'Genre', 'boksmakarna' ), ),
        'rewrite' => array( 'slug' => 'genre'),
        'show_admin_column' => true,
        'show_tagcloud' => false,
    ));
    
    register_taxonomy('publisher', 'book', array(
        'hierarchical' => false,
        'labels' => array( 'name' => _x( 'Publisher', 'taxonomy general name', 'boksmakarna' ),
        'singular_name' => _x( 'Publisher', 'taxonomy singular name', 'boksmakarna' ),
        'search_items' => __( 'Search Publisher', 'boksmakarna' ),
        'all_items' => __( 'All Publishers', 'boksmakarna' ),
        'edit_item' => __( 'Edit Publisher', 'boksmakarna' ),
        'update_item' => __( 'Update Publisher', 'boksmakarna' ),
        'add_new_item' => __( 'Add new Publisher', 'boksmakarna' ),
        'new_item_name' => __( 'New Publisher', 'boksmakarna' ),
        'menu_name' => __( 'Publisher', 'boksmakarna' ), ),
        'rewrite' => array( 'slug' => 'Publisher'),
        'show_admin_column' => true,
        'show_tagcloud' => false,
    ));

    register_taxonomy_for_object_type('category', 'episode');
    register_taxonomy_for_object_type('post_tag', 'episode');

}


?>