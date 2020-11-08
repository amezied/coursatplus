<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: select
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'SPFTESTIMONIAL_Field_select_f' ) ) {
	class SPFTESTIMONIAL_Field_select_f extends SPFTESTIMONIAL_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$args = wp_parse_args(
				$this->field, array(
					'placeholder' => '',
					'chosen'      => false,
					'multiple'    => false,
					'sortable'    => false,
					'ajax'        => false,
					'settings'    => array(),
					'query_args'  => array(),
				)
			);

			$this->value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

			echo $this->field_before();

			if ( isset( $this->field['options'] ) ) {

				if ( ! empty( $args['ajax'] ) ) {
					$args['settings']['data']['type']  = $args['options'];
					$args['settings']['data']['nonce'] = wp_create_nonce( 'spftestimonial_chosen_ajax_nonce' );
					if ( ! empty( $args['query_args'] ) ) {
						$args['settings']['data']['query_args'] = $args['query_args'];
					}
				}

				$chosen_rtl       = ( is_rtl() ) ? ' chosen-rtl' : '';
				$multiple_name    = ( $args['multiple'] ) ? '[]' : '';
				$multiple_attr    = ( $args['multiple'] ) ? ' multiple="multiple"' : '';
				$chosen_sortable  = ( $args['chosen'] && $args['sortable'] ) ? ' spftestimonial-chosen-sortable' : '';
				$chosen_ajax      = ( $args['chosen'] && $args['ajax'] ) ? ' spftestimonial-chosen-ajax' : '';
				$placeholder_attr = ( $args['chosen'] && $args['placeholder'] ) ? ' data-placeholder="' . $args['placeholder'] . '"' : '';
				$field_class      = ( $args['chosen'] ) ? ' class="spftestimonial-chosen' . $chosen_rtl . $chosen_sortable . $chosen_ajax . '"' : '';
				$field_name       = $this->field_name( $multiple_name );
				$field_attr       = $this->field_attributes();
				$maybe_options    = $this->field['options'];
				$chosen_data_attr = ( $args['chosen'] && ! empty( $args['settings'] ) ) ? ' data-chosen-settings="' . esc_attr( json_encode( $args['settings'] ) ) . '"' : '';

				if ( is_string( $maybe_options ) && ! empty( $args['chosen'] ) && ! empty( $args['ajax'] ) ) {
					$options = $this->field_wp_query_data_title( $maybe_options, $this->value );
				} elseif ( is_string( $maybe_options ) ) {
					$options = $this->field_data( $maybe_options, false, $args['query_args'] );
				} else {
					$options = $maybe_options;
				}

				if ( ( is_array( $options ) && ! empty( $options ) ) || ! empty( $args['chosen'] ) ) {

					if ( ! empty( $args['chosen'] ) && ! empty( $args['multiple'] ) ) {

						echo '<select name="' . $field_name . '" class="spftestimonial-hidden-select spftestimonial-hidden"' . $multiple_attr . $field_attr . '>';
						foreach ( $this->value as $option_key ) {
							echo '<option value="' . $option_key . '" selected>' . $option_key . '</option>';
						}
						echo '</select>';

						$field_name = '_pseudo';
						$field_attr = '';

					}

					echo '<select name="' . $field_name . '"' . $field_class . $multiple_attr . $placeholder_attr . $field_attr . $chosen_data_attr . '>';

					if ( $args['placeholder'] && empty( $args['multiple'] ) ) {
						if ( ! empty( $args['chosen'] ) ) {
							echo '<option value=""></option>';
						} else {
							echo '<option value="">' . $args['placeholder'] . '</option>';
						}
					}

					foreach ( $options as $option_key => $option ) {
							$pro_only_value = isset( $option['pro_only'] ) ? $option['pro_only'] : '';
							$pro_only       = true == $pro_only_value ? ' disabled' : '';
							$selected       = ( in_array( $option_key, $this->value ) ) ? ' selected' : '';
							echo '<option' . $pro_only . ' value="' . $option_key . '" ' . $selected . '>' . $option['name'] . '</option>';
					}

					echo '</select>';

				} else {

					echo ( ! empty( $this->field['empty_message'] ) ) ? $this->field['empty_message'] : esc_html__( 'No data provided for this option type.', 'testimonial-free' );

				}
			}

			echo $this->field_after();

		}

	}
}