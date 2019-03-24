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

/**
 * Makes every comment and comment author link truely external (except 'respond')
 * https://github.com/mirkoschubert/divi-child
 */
function divi_child_external_comment_links( $content ){
  return str_replace( "<a ", "<a target='_blank' ", $content );
}
add_filter( "comment_text", "divi_child_external_comment_links" );
add_filter( "get_comment_author_link", "divi_child_external_comment_links" );

/**
 * Removes IP addresses from comments (old entries have to be deleted by hand)
 * https://github.com/mirkoschubert/divi-child
 */
function divi_child_remove_comments_ip( $comment_author_ip ) {
  return '';
}
add_filter( 'pre_comment_user_ip', 'divi_child_remove_comments_ip' );

/**
 * Disable the emojis
 * https://github.com/mirkoschubert/divi-child
 */
function divi_child_disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'divi_child_disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'divi_child_disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'divi_child_disable_emojis' );


/**
* Filter function used to remove the tinymce emoji plugin.
* https://github.com/mirkoschubert/divi-child
* @param array $plugins
* @return array Difference betwen the two arrays
*/
function divi_child_disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

/**
* Remove emoji CDN hostname from DNS prefetching hints.
* https://github.com/mirkoschubert/divi-child
* @param array $urls URLs to print for resource hints.
* @param string $relation_type The relation type the URLs are printed for.
* @return array Difference betwen the two arrays.
*/
function divi_child_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
    $emoji_svg_url = apply_filters( 'emoji_svg_url','https://s.w.org/images/core/emoji/2/svg/' );

    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
  return $urls;
}
