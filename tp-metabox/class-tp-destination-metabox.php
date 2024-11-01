<?php
/**
 * Team Metabox
 *
 * @class       TP_Travel_Destination_Metabox
 * @since       1.0
 * @package     TP Education
 * @category    Class
 * @author      Theme Palace
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class TP_Travel_Destination_Metabox {

    public function __construct()
    {
        add_action( 'add_meta_boxes', array( $this, 'tp_travel_destination_options_meta') );
        add_action( 'save_post', array( $this, 'tp_travel_destination_options_save' ) );
    }

    public function tp_travel_destination_options_meta( $post_type )
    {
        /**
         * Add meta box
         */
        $post_types = array( 'tp-destination' );
        if ( in_array( $post_type, $post_types ) ) :
            add_meta_box( 'tp-travel-destination-options', esc_html__( 'Travel Destination Options', 'tp-travel-package' ), array( $this, 'tp_travel_destination_options' ), $post_type, 'normal', 'high' );
        endif;
    }

    public function tp_travel_destination_options( $post )
    {
        /**
         * Outputs the content of the meta options
         */
        wp_nonce_field( 'tp_travel_destination_options_nonce', 'travel_destination_nonce' );
        $destination_quote = get_post_meta( $post->ID, 'tp_destination_quote_value', true );
        $destination_quote = ! empty( $destination_quote ) ? $destination_quote : '';

        $destination_rating = get_post_meta( $post->ID, 'tp_destination_rating_value', true );
        $destination_rating = ! empty( $destination_rating ) ? $destination_rating : '';
        ?>

        <label class="tp-label" for="tp_destination_quote_value"><?php esc_html_e( 'Destination Quote', 'tp-travel-package' ); ?>: </label><br>
        <input type="text" name="tp_destination_quote_value" id="destination_quote_id" placeholder="<?php esc_attr_e( 'Visit Most Beautiful Place', 'tp-travel-package' ); ?>" value="<?php echo esc_attr( $destination_quote ); ?>" />

        <hr>

        <label class="tp-label" for="tp_destination_rating_value"><?php esc_html_e( 'Rating', 'tp-travel-package' ); ?>: </label><br>
        <select name="tp_destination_rating_value" id="destination_rating_id">
            <option value="1" <?php echo ( 1 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '1 Star', 'tp-travel-package' ); ?></option>
            <option value="1.5" <?php echo ( 1.5 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '1.5 Star', 'tp-travel-package' ); ?></option>
            <option value="2" <?php echo ( 2 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '2 Stars', 'tp-travel-package' ); ?></option>
            <option value="2.5" <?php echo ( 2.5 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '2.5 Stars', 'tp-travel-package' ); ?></option>
            <option value="3" <?php echo ( 3 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '3 Stars', 'tp-travel-package' ); ?></option>
            <option value="3.5" <?php echo ( 3.5 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '3.5 Stars', 'tp-travel-package' ); ?></option>
            <option value="4" <?php echo ( 4 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '4 Stars', 'tp-travel-package' ); ?></option>
            <option value="4.5" <?php echo ( 4.5 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '4.5 Stars', 'tp-travel-package' ); ?></option>
            <option value="5" <?php echo ( 5 == $destination_rating ) ? esc_html__( 'selected', 'tp-travel-package' ) : '';  ?> ><?php esc_html_e( '5 Stars', 'tp-travel-package' ); ?></option>
        </select>
        
        <?php    
    }


    public function tp_travel_destination_options_save( $post_id )
    {
        /**
         * Saves the mata input value
         */
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
         
        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['travel_destination_nonce'] ) || !wp_verify_nonce( sanitize_key( $_POST['travel_destination_nonce'] ), 'tp_travel_destination_options_nonce' ) ) return;
         
        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;
         
        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_destination_quote_value'] ) ) :
            $value = isset($_POST['tp_destination_quote_value']) ? $_POST['tp_destination_quote_value'] : '';
            update_post_meta( $post_id, 'tp_destination_quote_value', sanitize_text_field( wp_unslash( $value ) ) );   
        endif;      

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_destination_rating_value'] ) ) :
            $value = isset($_POST['tp_destination_rating_value']) ? $_POST['tp_destination_rating_value'] : '';
            update_post_meta( $post_id, 'tp_destination_rating_value', sanitize_text_field( wp_unslash( $value ) ) ); 
        endif;
    }

}

new TP_Travel_Destination_Metabox();