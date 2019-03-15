<?php
/**
 * @package      CMB2\Field_Content_Wrap
 * @author       Ruben Garcia <rubengcdev@gmail.com>
 * @copyright    Copyright (c) Ruben Garcia <rubengcdev@gmail.com>
 *
 * Plugin Name: CMB2 Field Type: Content Wrap
 * Plugin URI: https://github.com/rubengc/cmb2-field-content-wrap
 * GitHub Plugin URI: https://github.com/rubengc/cmb2-field-content-wrap
 * Description: CMB2 field type to setup content wrap values (margin, border(width) and padding).
 * Version: 1.0.1
 * Author: Ruben Garcia <rubengcdev@gmail.com>
 * Author URI: https://gamipress.com/
 * License: GPLv2+
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'CMB2_Field_Content_Wrap' ) ) {

    /**
     * Class CMB2_Field_Content_Wrap
     */
    class CMB2_Field_Content_Wrap {

        /**
         * Current version number
         */
        const VERSION = '1.0.1';

        /**
         * Initialize the plugin by hooking into CMB2
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ) );
            add_action( 'cmb2_render_content_wrap', array( $this, 'render' ), 10, 5 );
        }

        /**
         * Render field
         */
        public function render( $field, $value, $object_id, $object_type, $field_type ) {
            $initial_content_wrap = 'multiple';

            if( ( isset( $value['all'] ) && ! empty( $value['all'] ) ) ) {
                $initial_content_wrap = 'single';
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

                <?php
                $unit_options = array(
                    'px' => 'px',
                    'em' => 'em',
                    '%' => '%',
                );

                if( is_array( $field->args( 'units' ) ) ) {
                    $unit_options = $field->args( 'units' );
                }

                // If there is just 1 unit option, set it on a hidden field
                if( count( $unit_options ) === 1 ) :

                    $first_index = array_keys( $unit_options )[0];

                    echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[unit]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_unit',
                        'type'    => 'hidden',
                        'value' => $unit_options[$first_index],
                    ) ); ?>

                <?php else: ?>

                    <div class="cmb2-content-wrap-field cmb2-content-wrap-field-unit">
                        <label for="<?php echo $field_type->_name(); ?>_unit"><?php _e( 'Unit:', 'cmb2' ); ?></label>

                        <?php echo $field_type->select( array(
                            'name'    => $field_type->_name() . '[unit]',
                            'desc'    => '',
                            'id'      => $field_type->_id() . '_unit',
                            'class' => 'cmb2-content-wrap-select',
                            'options' => $this->build_options_string( $field_type, $unit_options, ( ( isset( $value['unit'] ) ) ? $value['unit'] : '' ) ),
                        ) ); ?>
                    </div>

                <?php endif; ?>

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
