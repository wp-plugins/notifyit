<?php
/**
 * Plugin Name: NotifyIt
 * Plugin URI:  http://kroozz.com/plugins/
 * Description: Add stylish notification in your website.
 * Author URI:  http://kroozz.com/
 * Author: the kroozz team
 * Version:     1.0.0
 * License:     GPLv2 or later (license.txt)
 * Text Domain: notifyit
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define( 'NOTIFYIT_VERSION', '1.0.0' );
define( 'NOTIFYIT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NOTIFYIT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( is_admin() ) {
    require_once( NOTIFYIT_PLUGIN_DIR . 'admin/notifyit-admin.php' );
    add_action( 'init', array( 'NotifyItAdmin', 'init' ) );
}

require_once( NOTIFYIT_PLUGIN_DIR . 'class.frontend.php' );
add_action( 'init', array( 'NotifyFront', 'init' ) );
