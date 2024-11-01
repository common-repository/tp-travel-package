<?php
/**
 * TP Travel Package core functions
 *
 * @package TP Travel Package
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Destination Quote
 */
if( ! function_exists( 'tp_destination_quote' ) ):
	function tp_destination_quote( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_destination_quote = get_post_meta( $post_id, 'tp_destination_quote_value', true );
		if ( ! empty( $tp_destination_quote ) ) {
			return esc_html( $tp_destination_quote );
		}
	}
endif;

/*
 * Destination Rating value
 */
if( ! function_exists( 'tp_destination_rating_value' ) ):
	function tp_destination_rating_value( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		
		$tp_destination_rating_value = get_post_meta( $post_id, 'tp_destination_rating_value', true );
		if ( ! empty( $tp_destination_rating_value ) ) {
			return esc_html( $tp_destination_rating_value );
		}	
	}
endif;

/*
 * Destination Rating
 */
if( ! function_exists( 'tp_destination_rating' ) ):
	function tp_destination_rating( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		
		$tp_destination_value = $tp_destination_rating = get_post_meta( $post_id, 'tp_destination_rating_value', true );
		$tp_destination_rating = explode( '.' ,  $tp_destination_rating );
		for( $i=1; $i <= 5; $i++ ){
			if( $i <= $tp_destination_rating[0] ) {
				$rating_class = 'tp-star';
			} else {
				if ( count( $tp_destination_rating > 1 ) ) {
					$value = ( $tp_destination_rating[0] ) + 1;
					if ( $i == $value )
						$rating_class = 'tp-half-star';
					else
						$rating_class = 'tp-star-o';
				} else {
					$rating_class = 'tp-star-o';
				}
			}
			echo '<i class="'. esc_attr( $rating_class ). '"></i>';
		}
	}
endif;

/*
 * Package Quote
 */
if( ! function_exists( 'tp_package_quote' ) ):
	function tp_package_quote( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_quote = get_post_meta( $post_id, 'tp_package_quote_value', true );
		if ( ! empty( $tp_package_quote ) ) {
			return esc_html( $tp_package_quote );
		}
	}
endif;

/*
 * Package Price
 */
if( ! function_exists( 'tp_package_price' ) ):
	function tp_package_price( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_price = get_post_meta( $post_id, 'tp_package_price_value', true );
		if ( ! empty( $tp_package_price ) ) {
			return esc_html( $tp_package_price );
		}
	}
endif;

/*
 * Package pax
 */
if( ! function_exists( 'tp_package_pax' ) ):
	function tp_package_pax( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_pax = get_post_meta( $post_id, 'tp_package_pax_value', true );
		if ( ! empty( $tp_package_pax ) ) {
			return esc_html( $tp_package_pax );
		}
	}
endif;

/*
 * Package days
 */
if( ! function_exists( 'tp_package_days' ) ):
	function tp_package_days( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_days = get_post_meta( $post_id, 'tp_package_days_value', true );
		if ( ! empty( $tp_package_days ) ) {
			$days = ( $tp_package_days === 1 ) ? esc_html__( 'day', 'tp-travel-package' ) : esc_html__( 'days', 'tp-travel-package' ); 
			return esc_html( $tp_package_days ) . esc_html( $days );
		}
	}
endif;

/*
 * Package difficulty
 */
if( ! function_exists( 'tp_package_difficulty' ) ):
	function tp_package_difficulty( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_difficulty = get_post_meta( $post_id, 'tp_package_difficulty_value', true );
		if ( ! empty( $tp_package_difficulty ) ) {
			return esc_html( $tp_package_difficulty );
		}
	}
endif;

/*
 * Package date
 */
if( ! function_exists( 'tp_package_date' ) ):
	function tp_package_date( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_date = get_post_meta( $post_id, 'tp_package_date_value', true );
		if ( ! empty( $tp_package_date ) ) {
			return date_i18n( esc_html__( get_option( 'date_format' ), 'tp-travel-package' ), strtotime( $tp_package_date ) );
		}
	}
endif;

/*
 * Package destination
 */
if( ! function_exists( 'tp_package_destination' ) ):
	function tp_package_destination( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_destination = get_post_meta( $post_id, 'tp_package_destination_value', true );
		if ( ! empty( $tp_package_destination ) ) {
			return esc_html( get_the_title( $tp_package_destination ) );
		}
	}
endif;

/*
 * Package destination link
 */
if( ! function_exists( 'tp_package_destination_link' ) ):
	function tp_package_destination_link( $post_id = '' ) {
		if ( empty( $post_id ) ) {
			GLOBAL $post;
			$post_id = $post->ID;
		}
		$tp_package_destination = get_post_meta( $post_id, 'tp_package_destination_value', true );
		if ( ! empty( $tp_package_destination ) ) {
			return '<a href="' . esc_url( get_the_permalink( $tp_package_destination ) ) . '">' . esc_html( get_the_title( $tp_package_destination ) ) . '</a>';
		}
	}
endif;

function tp_travel_package_before_content($content) {
	$output = '';
	if ( 'tp-package' == get_post_type() && is_single() ) {
		$output .= '<h4 class="package-quote">' . tp_package_quote() . '</h4>';
		$output .= '<table>';
		
		$output .= '<thead><tr>';
		if ( ! empty( tp_package_price() ) )
			$output .= '<th>' . esc_html__( 'Price', 'tp-education' ) . '</th>';
		if ( ! empty( tp_package_pax() ) )
			$output .= '<th>' . esc_html__( 'No of People', 'tp-education' ) . '</th>';
		if ( ! empty( tp_package_days() ) )
			$output .= '<th>' . esc_html__( 'Duration', 'tp-education' ) . '</th>';
		if ( ! empty( tp_package_difficulty() ) )
			$output .= '<th>' . esc_html__( 'Difficulty', 'tp-education' ) . '</th>';
		if ( ! empty( tp_package_date() ) )
			$output .= '<th>' . esc_html__( 'Departure', 'tp-education' ) . '</th>';
		if ( ! empty( tp_package_destination_link() ) )
			$output .= '<th>' . esc_html__( 'Destinaiton', 'tp-education' ) . '</th>';
		$output .= '</tr></thead>';
		
		$output .= '<tbody><tr>';
		if ( ! empty( tp_package_price() ) )
			$output .= '<td>' . tp_package_price() . '</td>';
		if ( ! empty( tp_package_pax() ) )
			$output .= '<td>' . tp_package_pax() . '</td>';
		if ( ! empty( tp_package_days() ) )
			$output .= '<td>' . tp_package_days() . '</td>';
		if ( ! empty( tp_package_difficulty() ) )
			$output .= '<td>' . tp_package_difficulty() . '</td>';
		if ( ! empty( tp_package_date() ) )
			$output .= '<td>' . tp_package_date() . '</td>';
		if ( ! empty( tp_package_destination_link() ) )
			$output .= '<td>' . tp_package_destination_link() . '</td>';
		$output .= '</tr></tbody>';

		$output .= '</table>';
	}
		return $output . $content;

}
add_filter('the_content', 'tp_travel_package_before_content');
