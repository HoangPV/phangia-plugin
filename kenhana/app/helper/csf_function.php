<?php


namespace Kenhana\App\Helper;


class Csf_Function {
	// Attention: Set your unique id of the framework
	const ID = 'appside_theme_options';

	public static function get_option($option = '', $default = null) {
		$options = get_option( self::ID );
		return ( isset( $options[$option] ) ) ? $options[$option] : $default;
	}

	public static function get_switcher_option( $option = '', $default = null) {
		$options = get_option(self::ID );
		$return_val =  ( isset( $options[$option] ) ) ? $options[$option] : $default;
		$return_val =  (is_null($return_val) || '1' == $return_val ) ? true : false;
		return $return_val;
	}

	public static function get_customize_option($option = '', $default = null) {
		$options = get_option( self::ID );
		return ( isset( $options[$option] ) ) ? $options[$option] : $default;
	}
}