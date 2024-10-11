<?php
/**
 * Engine for Bluey theme
 * 
 * @package Bluey theme
 */

/**
 * Accessed directly
 */
if( ! defined( 'ABSPATH' ) ){
	exit;
}

$theme = wp_get_theme( 'bluey-shop' );
/**
 * Constant for theme utilities
 */
define( 'THEME_VERSION', $theme['Version'] );
define( 'THEME_TEXT_DOMAIN', $theme['Text Domain'] );


$theme_init = (object) array(
    'version' => THEME_VERSION,
    'main' => require 'include/ThemeInit.php'
);
