<?php
/**
 * @package ZGM_Basic
 * @version 1.0
 */
/*
Plugin Name: ZGM Basic
Plugin URI: https://zerogravitymarketing.com
Description: This is a basic plugin for quick functionality that doesn't belong in a theme
Author: Zero Gravity Marketing
Version: 1.0
Author URI: https://zerogravitymarketing.com
Text Domain: zgm
*/

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

if ( !class_exists( 'ZGM_Basic_Plugin' ) ) {

    class ZGM_Basic_Plugin
    {
        /**
        * Intended to run first when the class is initiated
        */
        public function init() {

            /**
            * Plugin Activation Hook
            * @link https://developer.wordpress.org/reference/functions/register_activation_hook/
            */
            register_activation_hook( __FILE__, function(){
                // clear the permalinks after the post type has been registered
                flush_rewrite_rules();
                register_uninstall_hook( __FILE__, array($this,'register_uninstall_hook') );
            });

            /**
            * Plugin Deactivation Hook
            * @link https://developer.wordpress.org/reference/functions/register_deactivation_hook/
            */
            register_deactivation_hook( __FILE__, function(){
                // clear the permalinks to remove our post type's rules from the database
                flush_rewrite_rules();
            });

        }

        /**
        * Plugin Uninstall Hook
        * @link https://developer.wordpress.org/reference/functions/register_uninstall_hook/
        */
        public function register_uninstall_hook()
        {
            //
        }

        /**
        * Add WP Filters Hook
        * @link https://developer.wordpress.org/reference/functions/add_filter/
        */
        public function add_filters()
        {
            add_filter('body_class', array($this,'body_class'));
        }

        /**
        * Add WP Actions Hook
        * @link https://developer.wordpress.org/reference/functions/add_action/
        */
        public function add_actions()
        {
            add_action('wp_footer', array($this,'wp_footer') );
        }

        /**
         * Add <body> classes
         */
        public function body_class($classes)
        {
          // Add page slug if it doesn't exist
          if (is_single() || is_page() && !is_front_page()) {
            if (!in_array(basename(get_permalink()), $classes)) {
              $classes[] = basename(get_permalink());
            }
          }

          return $classes;
        }
        
        public function wp_footer()
        {
            echo "<script>console.log('wp_footer');</script>";
        }
    }

}

/**
 * Initialize all Plugin Class Functions
 */
if ( class_exists( 'ZGM_Basic_Plugin' ) ) {
    $ZGM_Basic_Plugin = new ZGM_Basic_Plugin();
    $ZGM_Basic_Plugin->init();
    $ZGM_Basic_Plugin->add_filters();
    $ZGM_Basic_Plugin->add_actions();
}
