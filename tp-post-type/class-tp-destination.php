<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Destination Post Type
 *
 * @class       TP_Destination_Post_type
 * @since       1.0
 * @package     TP Travel Package
 * @category    Class
 * @author      Theme Palace
 */

class TP_Destination_Post_type {

    public function __construct(){
        add_action( 'init', array( $this, 'tp_destination_post_type' ) );
    }

    public function tp_destination_post_type() {

        $destination_labels = array(
            'name'               => esc_html_x( 'Destination', 'post type general name', 'tp-travel-package' ),
            'singular_name'      => esc_html_x( 'Destination', 'post type singular name', 'tp-travel-package' ),
            'menu_name'          => esc_html_x( 'Destination', 'admin menu', 'tp-travel-package' ),
            'name_admin_bar'     => esc_html_x( 'Destination', 'add new on admin bar', 'tp-travel-package' ),
            'add_new'            => esc_html_x( 'Add New', 'Destination', 'tp-travel-package' ),
            'add_new_item'       => esc_html__( 'Add New Destination', 'tp-travel-package' ),
            'new_item'           => esc_html__( 'New Destination', 'tp-travel-package' ),
            'edit_item'          => esc_html__( 'Edit Destination', 'tp-travel-package' ),
            'view_item'          => esc_html__( 'View Destination', 'tp-travel-package' ),
            'all_items'          => esc_html__( 'All Destination', 'tp-travel-package' ),
            'search_items'       => esc_html__( 'Search Destination', 'tp-travel-package' ),
            'parent_item_colon'  => esc_html__( 'Parent Destination:', 'tp-travel-package' ),
            'not_found'          => esc_html__( 'No Destination Found.', 'tp-travel-package' ),
            'not_found_in_trash' => esc_html__( 'No Destination Found in Trash.', 'tp-travel-package' )
        );
        $destination_args = array(
            'labels'             => $destination_labels,
            'description'        => esc_html__( 'Description.', 'tp-travel-package' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'tp-destination', 'with_front' => false ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-location-alt',
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );
        register_post_type( 'tp-destination', $destination_args );
        
    }
    
}

new TP_Destination_Post_type();
