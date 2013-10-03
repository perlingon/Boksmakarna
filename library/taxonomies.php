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
        'rewrite' => array( 'slug' => 'forlag'),
        'show_admin_column' => true,
        'show_tagcloud' => false,
    ));

    register_taxonomy('upcoming', 'book', array(
        'hierarchical' => false,
        'labels' => array( 'name' => _x( 'Upcoming', 'taxonomy general name', 'boksmakarna' ),
        'singular_name' => _x( 'Upcoming', 'taxonomy singular name', 'boksmakarna' ),
        'search_items' => __( 'Search Upcoming', 'boksmakarna' ),
        'all_items' => __( 'All Upcoming', 'boksmakarna' ),
        'edit_item' => __( 'Edit Upcoming', 'boksmakarna' ),
        'update_item' => __( 'Update Upcoming', 'boksmakarna' ),
        'add_new_item' => __( 'Add new Upcoming', 'boksmakarna' ),
        'new_item_name' => __( 'New Upcoming', 'boksmakarna' ),
        'menu_name' => __( 'Upcoming', 'boksmakarna' ), ),
        'rewrite' => array( 'slug' => 'kommande'),
        'show_admin_column' => false,
        'show_ui'           => false,
        'show_tagcloud' => false,
    ));

    register_taxonomy_for_object_type('category', 'episode');
    register_taxonomy_for_object_type('post_tag', 'episode');

}

//------- Add Default Terms for Upcoming -----------//
function tax_upcoming_terms(){
    $terms = array(
        '0' => array( 'name' => 'Yes', 'short' => 'yes' ),
        '1' => array( 'name' => 'No', 'short' => 'no' ),
    );
    return $terms;
}

function tax_upcoming_default_terms(){
    // see if we already have populated any terms
    $term = get_terms( 'upcoming', array( 'hide_empty' => false ) );

    // if no terms then lets add our terms
    if( empty( $term ) ){
        $terms = tax_upcoming_terms();
        foreach( $terms as $term ){
            if( !term_exists( $term['name'], 'upcoming' ) ){
                wp_insert_term( $term['name'], 'upcoming', array( 'slug' => $term['short'] ) );
            }
        }
    }
}

function set_default_object_terms( $post_id, $post ) {
    if ( 'book' === $post->post_type ) {
        $defaults = array(
            'upcoming' => array( 'No' )
            );
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( (array) $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
            }
        }
    }
}

add_action( 'init', 'tax_upcoming_default_terms' );
add_action( 'save_post', 'set_default_object_terms', 100, 2 );


?>