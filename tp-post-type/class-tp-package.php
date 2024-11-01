<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Package Post Type
 *
 * @class       TP_Package_Post_type
 * @since       1.0
 * @package     TP Travel Package
 * @category    Class
 * @author      Theme Palace
 */

class TP_Package_Post_type {

    public function __construct(){
        add_action( 'init', array( $this, 'tp_package_post_type' ) );
    }

    public function tp_package_post_type() {

        $package_labels = array(
            'name'               => esc_html_x( 'Package', 'post type general name', 'tp-travel-package' ),
            'singular_name'      => esc_html_x( 'Package', 'post type singular name', 'tp-travel-package' ),
            'menu_name'          => esc_html_x( 'Package', 'admin menu', 'tp-travel-package' ),
            'name_admin_bar'     => esc_html_x( 'Package', 'add new on admin bar', 'tp-travel-package' ),
            'add_new'            => esc_html_x( 'Add New', 'Package', 'tp-travel-package' ),
            'add_new_item'       => esc_html__( 'Add New Package', 'tp-travel-package' ),
            'new_item'           => esc_html__( 'New Package', 'tp-travel-package' ),
            'edit_item'          => esc_html__( 'Edit Package', 'tp-travel-package' ),
            'view_item'          => esc_html__( 'View Package', 'tp-travel-package' ),
            'all_items'          => esc_html__( 'All Package', 'tp-travel-package' ),
            'search_items'       => esc_html__( 'Search Package', 'tp-travel-package' ),
            'parent_item_colon'  => esc_html__( 'Parent Package:', 'tp-travel-package' ),
            'not_found'          => esc_html__( 'No Package Found.', 'tp-travel-package' ),
            'not_found_in_trash' => esc_html__( 'No Package Found in Trash.', 'tp-travel-package' )
        );
        $package_args = array(
            'labels'             => $package_labels,
            'description'        => esc_html__( 'Description.', 'tp-travel-package' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'tp-package', 'with_front' => false ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-tickets-alt',
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );
        register_post_type( 'tp-package', $package_args );

        // Add new taxonomy for Package
        $package_cat_labels = array(
            'name'              => esc_html_x( 'Package Categories', 'taxonomy general name', 'tp-travel-package' ),
            'singular_name'     => esc_html_x( 'Package Category', 'taxonomy singular name', 'tp-travel-package' ),
            'search_items'      => esc_html__( 'Search Package Categories', 'tp-travel-package' ),
            'all_items'         => esc_html__( 'All Package Categories', 'tp-travel-package' ),
            'parent_item'       => esc_html__( 'Parent Package Category', 'tp-travel-package' ),
            'parent_item_colon' => esc_html__( 'Parent Package Category:', 'tp-travel-package' ),
            'edit_item'         => esc_html__( 'Edit Package Category', 'tp-travel-package' ),
            'update_item'       => esc_html__( 'Update Package Category', 'tp-travel-package' ),
            'add_new_item'      => esc_html__( 'Add New Package Category', 'tp-travel-package' ),
            'new_item_name'     => esc_html__( 'New Package Category Name', 'tp-travel-package' ),
            'menu_name'         => esc_html__( 'Package Category', 'tp-travel-package' ),
        );

        $package_cat_args = array(
            'hierarchical'      => true,
            'labels'            => $package_cat_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'tp-package-category' ),
        );

        register_taxonomy( 'tp-package-category', array( 'tp-package' ), $package_cat_args );
        
    }
    
}

new TP_Package_Post_type();
