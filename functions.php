<?php
	add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
	function theme_enqueue_styles() {
	    wp_enqueue_style( 'divi', get_template_directory_uri() . '/style.css' );
      wp_enqueue_script( 'divi', get_stylesheet_directory_uri() . 'js/scripts.js', array( 'jquery', 'divi-custom-script' ), '0.1.2', true );
	}


/**
 * Removes Divi Support Center from Frontend
 * @since Divi 3.20.1
 * https://github.com/mirkoschubert/divi-child
 */
function divi_child_remove_support_center() {
	wp_dequeue_script( 'et-support-center' );
	wp_deregister_script( 'et-support-center' );
}
add_action( 'wp_enqueue_scripts', 'divi_child_remove_support_center', 99999 );

/**
 * Custom Body Class for Child Theme
 * https://github.com/mirkoschubert/divi-child
 */
function divi_child_body_class( $classes ) {
  $classes[] = 'child';
  return $classes;
}
add_action( 'body_class', 'divi_child_body_class' );
