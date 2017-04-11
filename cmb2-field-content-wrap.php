<?php
/*
Plugin Name: CMB2 Field Type: Content Wrap
Plugin URI: https://github.com/rubengc/cmb2-field-content-wrap
GitHub Plugin URI: https://github.com/rubengc/cmb2-field-content-wrap
Description: CMB2 field type to setup content wrap values (margin, border(width) and padding).
Version: 1.0.0
Author: Ruben Garcia
Author URI: http://rubengc.com/
License: GPLv2+
*/


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'CMB2_Field_Content_Wrap' ) ) {
    /**
     * Class CMB2_Field_Position
     */
    class CMB2_Field_Content_Wrap {

        /**
         * Current version number
         */
        const VERSION = '1.0.0';

        /**
         * Initialize the plugin by hooking into CMB2
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ) );
            add_action( 'cmb2_render_content_wrap', array( $this, 'render' ), 10, 5 );
            add_action( 'cmb2_sanitize_content_wrap', array( $this, 'sanitize' ), 10, 4 );
        }

        /**
         * Render field
         */
        public function render( $field, $value, $object_id, $object_type, $field_type ) {
            $initial_content_wrap = 'single';

            if( ( isset( $value['top'] ) && ! empty( $value['top'] ) )
                || ( isset( $value['right'] ) && ! empty( $value['right'] ) )
                || ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) )
                || ( isset( $value['left'] ) && ! empty( $value['left'] ) )
            ) {
                $initial_content_wrap = 'multiple';
            }
            ?>

            <div class="cmb2-content-wrap cmb2-content-wrap-<?php echo $initial_content_wrap; ?>">
                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-switch">
                    <button type="button" class="button button-secondary"><i class="dashicons dashicons-editor-<?php if( $initial_content_wrap == 'single' ) : ?>expand<?php else : ?>contract<?php endif; ?>"></i></button>
                </div>
                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-all">
                    <label for="<?php echo $field_type->_name(); ?>_all"><?php _e( 'All:', 'cmb2' ); ?></label>

                    <?php echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[all]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_all',
                        'class' => 'cmb2-text-small cmb2-content-wrap-input',
                        'type'    => 'number',
                        'pattern' => '\d*',
                        'value' => ( ( isset( $value['all'] ) ) ? $value['all'] : '' ),
                    ) ); ?>
                </div>

                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-top">
                    <label for="<?php echo $field_type->_name(); ?>_top"><?php _e( 'Top:', 'cmb2' ); ?></label>

                    <?php echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[top]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_top',
                        'class' => 'cmb2-text-small cmb2-content-wrap-input',
                        'type'    => 'number',
                        'pattern' => '\d*',
                        'value' => ( ( isset( $value['top'] ) ) ? $value['top'] : '' ),
                    ) ); ?>
                </div>

                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-right">
                    <label for="<?php echo $field_type->_name(); ?>_right"><?php _e( 'Right:', 'cmb2' ); ?></label>

                    <?php echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[right]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_right',
                        'class' => 'cmb2-text-small cmb2-content-wrap-input',
                        'type'    => 'number',
                        'pattern' => '\d*',
                        'value' => ( ( isset( $value['right'] ) ) ? $value['right'] : '' ),
                    ) ); ?>
                </div>

                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-bottom">
                    <label for="<?php echo $field_type->_name(); ?>_bottom"><?php _e( 'Bottom:', 'cmb2' ); ?></label>

                    <?php echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[bottom]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_bottom',
                        'class' => 'cmb2-text-small cmb2-content-wrap-input',
                        'type'    => 'number',
                        'pattern' => '\d*',
                        'value' => ( ( isset( $value['bottom'] ) ) ? $value['bottom'] : '' ),
                    ) ); ?>
                </div>

                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-left">
                    <label for="<?php echo $field_type->_name(); ?>_left"><?php _e( 'Left:', 'cmb2' ); ?></label>

                    <?php echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[left]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_left',
                        'class'   => 'cmb2-text-small cmb2-content-wrap-input',
                        'type'    => 'number',
                        'pattern' => '\d*',
                        'value' => ( ( isset( $value['left'] ) ) ? $value['left'] : '' ),
                    ) ); ?>
                </div>

                <div class="cmb2-content-wrap-field cmb2-content-wrap-field-unit">
                    <label for="<?php echo $field_type->_name(); ?>_unit"><?php _e( 'Unit:', 'cmb2' ); ?></label>

                    <?php
                    $unit_options = array(
                        'px' => 'px',
                        'em' => 'em',
                        '%' => '%',
                    );

                    echo $field_type->select( array(
                        'name'    => $field_type->_name() . '[unit]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_unit',
                        'class' => 'cmb2-content-wrap-select',
                        'options' => $this->build_options_string( $field_type, $unit_options, ( ( isset( $value['unit'] ) ) ? $value['unit'] : '' ) ),
                    ) );
                    ?>
                </div>
            </div>

            <?php
            $field_type->_desc( true, true );
        }

        private function build_options_string( $field_type, $options, $value ) {
            $options_string = '';

            foreach( $options as $val => $label) {
                $options_string .= '<option value="' . $val . '" ' . selected( $value, $val, false ) . '>' . $label . '</option>';
            }

            return $options_string;
        }

        /**
         * Optionally save the latitude/longitude values into two custom fields
         */
        public function sanitize( $override_value, $value, $object_id, $field_args ) {
            $fid = $field_args['id'];

            if( $field_args['render_row_cb'][0]->data_to_save[$fid] ) {
                $value = $field_args['render_row_cb'][0]->data_to_save[$fid];
            } else {
                $value = false;
            }

            return $value;
        }

        /**
         * Enqueue scripts and styles
         */
        public function setup_admin_scripts() {
            wp_register_script( 'cmb-content-wrap', plugins_url( 'js/content-wrap.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );

            wp_enqueue_script( 'cmb-content-wrap' );

            wp_register_style( 'cmb-content-wrap', plugins_url( 'css/content-wrap.css', __FILE__ ), array(), self::VERSION );

            wp_enqueue_style( 'cmb-content-wrap' );

        }

    }

    $cmb2_field_content_wrap = new CMB2_Field_Content_Wrap();
}
