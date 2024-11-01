<?php
/**
 * Team Metabox
 *
 * @class       TP_Travel_Package_Metabox
 * @since       1.0
 * @package     TP Education
 * @category    Class
 * @author      Theme Palace
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class TP_Travel_Package_Metabox {

    public function __construct()
    {
        add_action( 'add_meta_boxes', array( $this, 'tp_travel_package_options_meta') );
        add_action( 'save_post', array( $this, 'tp_travel_package_options_save' ) );
    }

    public function tp_travel_package_options_meta( $post_type )
    {
        /**
         * Add meta box
         */
        $post_types = array( 'tp-package' );
        if ( in_array( $post_type, $post_types ) ) :
            add_meta_box( 'tp-travel-package-options', esc_html__( 'Travel Package Options', 'tp-travel-package' ), array( $this, 'tp_travel_package_options' ), $post_type, 'normal', 'high' );
        endif;
    }

    public function tp_travel_package_options( $post )
    {
        /**
         * Outputs the content of the meta options
         */
        wp_nonce_field( 'tp_travel_package_options_nonce', 'travel_package_nonce' );

        $package_featured = get_post_meta( $post->ID, 'tp_package_featured_value', true );
        $package_featured = ! empty( $package_featured ) ? $package_featured : '';

        $package_quote = get_post_meta( $post->ID, 'tp_package_quote_value', true );
        $package_quote = ! empty( $package_quote ) ? $package_quote : '';

        $package_price = get_post_meta( $post->ID, 'tp_package_price_value', true );
        $package_price = ! empty( $package_price ) ? $package_price : '';

        $package_pax = get_post_meta( $post->ID, 'tp_package_pax_value', true );
        $package_pax = ! empty( $package_pax ) ? $package_pax : '';

        $package_days = get_post_meta( $post->ID, 'tp_package_days_value', true );
        $package_days = ! empty( $package_days ) ? $package_days : '';
        
        $package_difficulty = get_post_meta( $post->ID, 'tp_package_difficulty_value', true );
        $package_difficulty = ! empty( $package_difficulty ) ? $package_difficulty : '';
        
        $package_date = get_post_meta( $post->ID, 'tp_package_date_value', true );
        $package_date = ! empty( $package_date ) ? $package_date : '';

        $package_destination = get_post_meta( $post->ID, 'tp_package_destination_value', true );
        $package_destination = ! empty( $package_destination ) ? $package_destination : '';
        ?>

        <label class="tp-label featured_package_label" for="tp_package_featured_value"><?php esc_html_e( 'Featured Package', 'tp-travel-package' ); ?>: 
        <input type="checkbox" name="tp_package_featured_value" id="package_featured_id" <?php if ( isset ( $package_featured ) ) checked( $package_featured, 'yes' ); ?> />
        </label>

        <hr>

        <label class="tp-label" for="tp_package_quote_value"><?php esc_html_e( 'Package Quote', 'tp-travel-package' ); ?>: </label><br>
        <input type="text" name="tp_package_quote_value" id="package_quote_id" placeholder="<?php esc_attr_e( 'Visit Most Beautiful City', 'tp-travel-package' ); ?>" value="<?php echo esc_attr( $package_quote ); ?>" />

        <hr>

        <label class="tp-label" for="tp_package_price_value"><?php esc_html_e( 'Price', 'tp-travel-package' ); ?>: </label><br>
        <input type="text" name="tp_package_price_value" id="package_price_id" placeholder="<?php esc_attr_e( '$ 1250.00', 'tp-travel-package'); ?>" value="<?php echo esc_attr( $package_price ); ?>" />

        <hr>

        <label class="tp-label" for="tp_package_pax_value"><?php esc_html_e( 'No of people', 'tp-travel-package' ); ?>: </label><br>
        <input type="number" name="tp_package_pax_value" id="package_pax_id" placeholder="<?php esc_attr_e( '54', 'tp-travel-package' ); ?>" value="<?php echo absint( $package_pax ); ?>" />

        <hr>

        <label class="tp-label" for="tp_package_days_value"><?php esc_html_e( 'No of days', 'tp-travel-package' ); ?>: </label><br>
        <input type="number" name="tp_package_days_value" id="package_days_id" placeholder="<?php esc_attr_e( '10', 'tp-travel-package' ); ?>" value="<?php echo esc_attr( $package_days ); ?>" />

        <hr>

        <label class="tp-label" for="tp_package_difficulty_value"><?php esc_html_e( 'Difficulty', 'tp-travel-package' ); ?>: </label><br>
        <input type="text" name="tp_package_difficulty_value" id="package_difficulty_id" placeholder="<?php esc_attr_e( 'Medium', 'tp-travel-package' ); ?>" value="<?php echo esc_attr( $package_difficulty ); ?>" />

        <hr>

        <label class="tp-label" for="tp_package_date_value"><?php esc_html_e( 'Start Date', 'tp-travel-package' ); ?>: </label><br>
        <input type="date" name="tp_package_date_value" id="package_date_id" placeholder="<?php esc_attr_e( 'Feb 12, 2017', 'tp-travel-package' ); ?>" value="<?php echo esc_attr( $package_date ); ?>" />

        <hr>

        <label class="tp-label" for="tp_package_destination_value"><?php esc_html_e( 'Destination', 'tp-travel-package' ); ?>: </label><br>
        <select name="tp_package_destination_value" id="package_destination_id">
            <?php
            $args = array(
                'post_type' => 'tp-destination',
                'orderby'   => 'title',
                'order'     => 'ASC'
                );
            $posts = get_posts( $args );
            foreach ( $posts as $post ) {
                $selected = ( $post->ID == $package_destination ) ? 'selected' : '';
                echo '<option value="' . absint( $post->ID ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $post->post_title ) . '</option>';
            }
            ?>
            
        </select>
        <p><?php printf( esc_html__( 'Note: Please create destination first to select destination.%1$s Create New Destination %2$s', 'tp-travel-package' ), '<a href="' . esc_url( admin_url( 'post-new.php?post_type=tp-destination' ) ) . '">', '</a>' ); ?></p>
        <?php    
    }


    public function tp_travel_package_options_save( $post_id )
    {
        /**
         * Saves the mata input value
         */
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
         
        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['travel_package_nonce'] ) || !wp_verify_nonce( sanitize_key( $_POST['travel_package_nonce'] ), 'tp_travel_package_options_nonce' ) ) return;
         
        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;

        $value = isset($_POST['tp_package_featured_value']) ? 'yes' : '';
        update_post_meta( $post_id, 'tp_package_featured_value', sanitize_text_field( wp_unslash( $value ) ) );  
         
        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_quote_value'] ) ) :
            $value = isset($_POST['tp_package_quote_value']) ? $_POST['tp_package_quote_value'] : '';
            update_post_meta( $post_id, 'tp_package_quote_value', sanitize_text_field( wp_unslash( $value ) ) );   
        endif;      

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_price_value'] ) ) :
            $value = isset($_POST['tp_package_price_value']) ? $_POST['tp_package_price_value'] : '';
            update_post_meta( $post_id, 'tp_package_price_value', sanitize_text_field( wp_unslash( $value ) ) );   
        endif;  

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_pax_value'] ) ) :
            $value = isset($_POST['tp_package_pax_value']) ? $_POST['tp_package_pax_value'] : '';
            update_post_meta( $post_id, 'tp_package_pax_value', absint( wp_unslash( $value ) ) );   
        endif;

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_days_value'] ) ) :
            $value = isset($_POST['tp_package_days_value']) ? $_POST['tp_package_days_value'] : '';
            update_post_meta( $post_id, 'tp_package_days_value', absint( wp_unslash( $value ) ) ); 
        endif;

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_difficulty_value'] ) ) :
            $value = isset($_POST['tp_package_difficulty_value']) ? $_POST['tp_package_difficulty_value'] : '';
            update_post_meta( $post_id, 'tp_package_difficulty_value', sanitize_text_field( wp_unslash( $value ) ) ); 
        endif;

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_date_value'] ) ) :
            $value = isset($_POST['tp_package_date_value']) ?  $_POST['tp_package_date_value'] : array();
            update_post_meta( $post_id, 'tp_package_date_value', sanitize_text_field( wp_unslash( $value ) ) ); 
        endif;

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_date_value'] ) ) :
            $value = isset($_POST['tp_package_date_value']) ?  $_POST['tp_package_date_value'] : array();
            update_post_meta( $post_id, 'tp_package_date_value', sanitize_text_field( wp_unslash( $value ) ) ); 
        endif;

        // Make sure your data is set before trying to save it
        if( isset( $_POST['tp_package_destination_value'] ) ) :
            $value = isset($_POST['tp_package_destination_value']) ?  $_POST['tp_package_destination_value'] : '';
            update_post_meta( $post_id, 'tp_package_destination_value', absint( wp_unslash( $value ) ) ); 
        endif;
    }

}

new TP_Travel_Package_Metabox();