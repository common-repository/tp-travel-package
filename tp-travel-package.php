<?php
/**
 * Plugin Name: TP Travel Package
 * Plugin URI: http://www.themepalace.com/plugins/tp-travel-package
 * Description: This Plugin has assembled destination and packages and its elementary fields for travel websites.
 * Version: 1.0.4
 * Author: Theme Palace
 * Author URI: http://themepalace.com
 * Requires at least: 4.7
 * Tested up to: 6.0
 *
 * Text Domain: tp-travel-package
 * Domain Path: /languages/
 *
 * @package TP Travel Package
 * @category Core
 * @author Theme Palace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'TP_Travel_Package' ) ) :

	final class TP_Travel_Package {

		public function __construct()
		{
			$this->tp_travel_package_constant();
			$this->tp_travel_package_includes();
			$this->tp_travel_package_hook();
			$this->tp_travel_package_install_uninstall_hook();
		}

		public function tp_travel_package_constant()
		{
			define( 'TP_TRAVEL_PACKAGE_BASE_PATH', dirname(__FILE__ ) );
			define( 'TP_TRAVEL_PACKAGE_URL_PATH', plugin_dir_url(__FILE__ ) );
			define( 'TP_TRAVEL_PACKAGE_PLUGIN_BASE_PATH', plugin_basename(__FILE__) );
		}

		public static function tp_travel_package_install_uninstall_hook()
		{
	        register_activation_hook( TP_TRAVEL_PACKAGE_URL_PATH, array( 'TP_Travel_Package', 'tp_travel_package_rewrite' ) );
	        register_deactivation_hook( TP_TRAVEL_PACKAGE_URL_PATH, array( 'TP_Travel_Package', 'tp_travel_package_rewrite' ) );
	    }

	    static function tp_travel_package_rewrite()
	    {
	    	flush_rewrite_rules( $hard = true );
	    }

	    public function tp_travel_package_hook() 
	    {
	    	// custom template
			add_filter( 'template_include', array( $this,'tp_travel_package_set_template' ) );

			// Custom Search
			add_filter( 'template_include', array( $this,'tp_travel_package_set_search_template' ) );

			// enqueue scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'tp_travel_package_enqueue' ) );

			// enqueue admin scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'tp_travel_package_admin_enqueue' ) );

			// Check WP Travel active status to migrate.
			add_action( 'admin_init', array( $this, 'tp_travel_data_migrate_to_wp_travel' ) );
	    }

		public function tp_travel_package_includes()
		{
			// Destination Post Type
			include_once('tp-post-type/class-tp-destination.php');

			// Package Post Type
			include_once('tp-post-type/class-tp-package.php');

			// Package Meta Box
			include_once('tp-metabox/class-tp-package-metabox.php');

			// Destination Meta Box
			include_once('tp-metabox/class-tp-destination-metabox.php');

			// Functions
			include_once('includes/tp-travel-package-functions.php');
		}

		public function tp_travel_package_admin_enqueue( $hook )
		{
			/*
			 * Enqueue admin scripts
			 */

			// Load tp education style
            wp_enqueue_style( 'tp-travel-package-style', TP_TRAVEL_PACKAGE_URL_PATH  . 'assets/css/admin-style.min.css' );

	        if ( 'post.php' == $hook || 'post-new.php' == $hook ) :
	            // Load simple date picker css
	            wp_enqueue_style( 'jquery-ui', TP_TRAVEL_PACKAGE_URL_PATH  . 'assets/css/jquery-ui.min.css' );

	            // Load admin custom js
	            wp_enqueue_script( 'tp-travel-package-admin-custom', TP_TRAVEL_PACKAGE_URL_PATH  . 'assets/js/admin-custom.min.js', array( 'jquery', 'jquery-ui-datepicker' ) );
            endif;

		}

		public function tp_travel_package_enqueue()
		{
			/*
			 * Enqueue scripts
			 */

			// Load style
            wp_enqueue_style( 'tp-travel-package-style', TP_TRAVEL_PACKAGE_URL_PATH  . 'assets/css/style.min.css' );
		}

		public function tp_travel_package_set_template( $template )
		{
			if ( is_post_type_archive( 'tp-package' ) || is_tax('tp-package-category') ) :
				if ( locate_template( 'tp-travel-package/tp-archive-package.php' ) != '' )
					$template = locate_template( 'tp-travel-package/tp-archive-package.php' );
				else
					$template = locate_template( 'archive.php' );
			endif;

			if ( is_post_type_archive( 'tp-destination' ) ) :
				if ( locate_template( 'tp-travel-package/tp-archive-destination.php' ) != '' )
					$template = locate_template( 'tp-travel-package/tp-archive-destination.php' );
				else
					$template = locate_template( 'archive.php' );
			endif;


			if( is_singular( 'tp-package' ) ) :
				if ( locate_template( 'tp-travel-package/tp-single-package.php' ) != '' )
					$template = locate_template( 'tp-travel-package/tp-single-package.php' );
				else
					$template = locate_template( 'single.php' );
			endif;

			if( is_singular( 'tp-destination' ) ) :
				if ( locate_template( 'tp-travel-package/tp-single-destination.php' ) != '' )
					$template = locate_template( 'tp-travel-package/tp-single-destination.php' );
				else
					$template = locate_template( 'single.php' );
			endif;

			return $template;
		}

		public function tp_travel_package_set_search_template( $template )
		{
			global $wp_query;
			$post_type = get_query_var( 'post_type' );
			if ( $wp_query->is_search && 'tp-package' == $post_type )
			{
				if ( locate_template( 'tp-travel-package/tp-package-search.php' ) != '' )
					$template =  locate_template( 'tp-travel-package/tp-package-search.php' );
				else
					$template = locate_template( 'search.php' );
			}
			return $template;
		}

		public function tp_travel_data_migrate_to_wp_travel() {
			if ( class_exists( 'WP_Travel' ) ) {

				add_action( 'admin_notices', array( $this, 'tp_travel_wp_travel_activation_notice' ) );
				$migrated = get_option( 'tp_travel_migrated' );
				if ( $migrated === 'yes' ) {
					return;
				}
				$args = array(
					'numberposts'	=> '-1',
					'post_type'		=> 'tp-package',
					'post_status'	=> 'publish',
					'orderby'		=> 'ID',
					'order'			=> 'ASC'					
				);
				$tp_travels = get_posts( $args ); // TP travel posts.

				// TP travel Terms.
				$tp_travels_terms = get_terms( array(
					'taxonomy' => 'tp-package-category',
					'hide_empty' => false,
				) );
				
				// Adding TP Travels terms into itinerary_types.
				if ( is_array( $tp_travels_terms ) && count( $tp_travels_terms ) > 0 ) {
					foreach ( $tp_travels_terms as $tp_travels_term ) :
						if ( ! term_exists( $tp_travels_term->name, 'itinerary_types' ) ) {
							wp_insert_term( $tp_travels_term->name, 'itinerary_types', array( 'description' => $tp_travels_term->description ) );
						}						 
					endforeach;
				}

				// Fetch Destination Post types.
				$args = array(
					'numberposts'	=> '-1',
					'post_type'		=> 'tp-destination',
					'post_status'	=> 'publish',
					'orderby'		=> 'ID',
					'order'			=> 'ASC'					
				);
				$tp_destinations = get_posts( $args ); // TP Destination posts.
				if ( is_array( $tp_destinations ) && count( $tp_destinations ) > 0 ) {
					$destination = array();
					foreach ( $tp_destinations as $tp_destination ) :
						if ( ! term_exists( $tp_destination->post_title, 'travel_locations' ) ) {
							$destination[ $tp_destination->ID ] = $tp_destination->post_title;
							$term = wp_insert_term( $tp_destination->post_title, 'travel_locations', array( 'description' => $tp_destination->post_content ) );
							$term_id = is_array( $term ) && isset( $term['term_id'] ) ? $term['term_id'] : 0;
							
							$thumbnail_id = get_post_thumbnail_id( $tp_destination->ID );
							$quote		= get_post_meta( $tp_destination->ID, 'tp_destination_quote_value', true );
							$rating		= get_post_meta( $tp_destination->ID, 'tp_destination_rating_value', true );
							$excerpt	= $tp_destination->post_excerpt;

							update_term_meta( $term_id, 'thumbnail_id', $thumbnail_id );
							update_term_meta( $term_id, 'quote', $quote );
							update_term_meta( $term_id, 'rating', $rating );
							update_term_meta( $term_id, 'excerpt', $excerpt );

						}
					endforeach;
				}

				// set difficulty as Global Trip Facts.
				$settings = wp_travel_get_settings();
				if ( isset( $settings['wp_travel_trip_facts_settings'] ) && ! in_array( 'Difficulty', array_column( $settings['wp_travel_trip_facts_settings'], 'name' )  ) ) {
					$global_fact = array();				
					$global_fact = array(								
						'name' => 'Difficulty',
						'type' => 'text',
						'options' => array(),
						'icon' => ''
					);
					
					if ( is_array( $settings['wp_travel_trip_facts_settings'] ) && '' !== $settings['wp_travel_trip_facts_settings'] ) {
						$settings['wp_travel_trip_facts_settings'][] = $global_fact;
					}
					update_option( 'wp_travel_settings', $settings );
				}

				// Inserting TP Travel Packages into wp travel itinerary.
				if ( is_array( $tp_travels ) && count( $tp_travels ) > 0 ) {
					foreach ( $tp_travels as $wp_travel ) :
						// Getting Post Terms of TP Travel Post.
						$tp_travel_post_id = $wp_travel->ID;
						$tp_travel_post_terms = get_the_terms( $tp_travel_post_id, 'tp-package-category' );
						$tp_travel_term_names = array();
						if ( is_array( $tp_travel_post_terms ) && count( $tp_travel_post_terms ) > 0 ) {
							foreach ( $tp_travel_post_terms as $post_terms ) {
								$tp_travel_term_names[] = $post_terms->name;
							}
						}

						$title = $wp_travel->post_title;
						$content = $wp_travel->post_content;
						$excerpt = $wp_travel->post_excerpt;
						
						$page = get_page_by_title( $title, OBJECT, WP_TRAVEL_POST_TYPE );

						if ( isset( $page->ID ) ) {
							$post_id = $page->ID;
						} else {
							$post_id = wp_insert_post(
								array(
									'post_type' 	=> WP_TRAVEL_POST_TYPE,
									'post_status' 	=> 'publish',
									'post_title' 	=> $title,
									'post_content'	=> $content,
									'post_excerpt'	=> $excerpt,
								)
							);
						}
						// Setting all TP Travel Package Catagory as Trip type in WP Travel.
						wp_set_object_terms( $post_id, $tp_travel_term_names, 'itinerary_types' );

						// Setting TP Destination post type to travel_locations.
						$destination_post_id = get_post_meta( $tp_travel_post_id, 'tp_package_destination_value', true );
						if ( $destination_post_id && isset( $destination[$destination_post_id] ) ) {
							$destination_term_names = array( $destination[$destination_post_id] );
							wp_set_object_terms( $post_id, $destination_term_names, 'travel_locations' );
						}

						// Setting Featured Post.
						$featured = get_post_meta( $tp_travel_post_id, 'tp_package_featured_value', true );
						$featured = ( $featured ) ? $featured : 'no';
						update_post_meta( $post_id, 'wp_travel_featured', $featured );

						
						// Adding Package Quote as Outline.
						$quote = get_post_meta( $tp_travel_post_id, 'tp_package_quote_value', true );
						if ( $quote ) {
							update_post_meta( $post_id, 'wp_travel_outline', $quote );
						}

						// Creating Gallery and Featured images for trip.
						$gallery_id = get_post_thumbnail_id( $tp_travel_post_id );
						if ( $gallery_id ) {
							update_post_meta( $post_id, 'wp_travel_itinerary_gallery_ids', array( $gallery_id ) );
							set_post_thumbnail( $post_id, $gallery_id );
						}

						// Adding Price.
						$trip_price = get_post_meta( $tp_travel_post_id, 'tp_package_price_value', true );
						if ( $trip_price ) {
							update_post_meta( $post_id, 'wp_travel_price', $trip_price );
						}

						// Adding PAX / Group size.
						$group_size = get_post_meta( $tp_travel_post_id, 'tp_package_pax_value', true );
						if ( $group_size ) {
							update_post_meta( $post_id, 'wp_travel_group_size', $group_size );
						}

						// Adding No of Days to WP Travel.
						$no_of_days = get_post_meta( $tp_travel_post_id, 'tp_package_days_value', true );
						if ( $no_of_days ) {
							update_post_meta( $post_id, 'wp_travel_trip_duration', $no_of_days );
						}

						// Adding PAX / Group size.
						$wp_travel_fact = array();
						$difficulty = get_post_meta( $tp_travel_post_id, 'tp_package_difficulty_value', true );
						
						if ( $difficulty ) {
							$wp_travel_fact[] = array(
								'label' => 'Difficulty',
								'type'	=> 'text',
								'value' => $difficulty

							);
							update_post_meta( $post_id, 'wp_travel_trip_facts', $wp_travel_fact );
						}
						
						// Start Date.
						$start_date = get_post_meta( $tp_travel_post_id, 'tp_package_date_value', true );
						if ( $start_date ) {
							$start_date = date( 'm/d/Y' , strtotime( $start_date ) );
							update_post_meta( $post_id, 'wp_travel_start_date', $start_date );
						}
					endforeach;
				}
				update_option( 'tp_travel_migrated', 'yes' );
			}
		}

		public function tp_travel_wp_travel_activation_notice() { ?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'WP Travel is activated. Please Deactivate TP Travel Package.', 'tp-travel-package' ) ?></p>
			</div>
		<?php
		}
		
	}

	new TP_Travel_Package();

endif;

