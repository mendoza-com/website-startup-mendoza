<?php

include_once 'lib/edgtf-instagram-api.php';
include_once 'widgets/load.php';

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
if(!function_exists('edge_instagram_feed_load_textdomain')) {
    function edge_instagram_feed_load_textdomain() {
        load_plugin_textdomain( 'edge-instagram-feed', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
    }
    add_action( 'plugins_loaded', 'edge_instagram_feed_load_textdomain' );
}