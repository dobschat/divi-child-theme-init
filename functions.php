<?php
	add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
	function theme_enqueue_styles() {
	    wp_enqueue_style( 'divi', get_template_directory_uri() . '/style.css' );
      wp_enqueue_script( 'divi', get_stylesheet_directory_uri() . 'js/scripts.js', array( 'jquery', 'divi-custom-script' ), '0.1.2', true );
	}
?>
