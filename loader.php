<?php
/**
 * Plugin Name: DigitalOcean Spaces Sync
 * Plugin URI: https://github.com/keeross/DO-Spaces-Wordpress-Sync
 * Description: This WordPress plugin syncs your media library with DigitalOcean Spaces Container.
 * Version: 2.0.5
 * Author: keeross
 * Author URI: https://github.com/keeross
 * License: MIT
 * Text Domain: dos
 * Domain Path: /languages

 */




require_once 'vendor/autoload.php';

define('DOS_PLUGIN_FOLDER',__DIR__);
define('DOS_PLUGIN_FOLDER_RELATIVE_PATH',dirname(plugin_basename(__FILE__)));

$plugin = new \frappacchio\DOSWordpress\DOSWordpressPlugin();



/*require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dos_class.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dos_class_filesystem.php';

load_plugin_textdomain('dos', false, dirname(plugin_basename(__FILE__)) . '/languages');

function dos_incompatibile($msg) {
  require_once ABSPATH . DIRECTORY_SEPARATOR . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'plugin.php';
  deactivate_plugins(__FILE__);
  wp_die($msg);
}

if ( is_admin() && ( !defined('DOING_AJAX') || !DOING_AJAX ) ) {

  if ( version_compare(PHP_VERSION, '5.3.3', '<') ) {

    dos_incompatibile(
      __(
        'Plugin DigitalOcean Spaces Sync requires PHP 5.3.3 or higher. The plugin has now disabled itself.',
        'dos'
      )
    );

  } elseif ( !function_exists('curl_version')
    || !($curl = curl_version()) || empty($curl['version']) || empty($curl['features'])
    || version_compare($curl['version'], '7.16.2', '<')
  ) {

    dos_incompatibile(
      __('Plugin DigitalOcean Spaces Sync requires cURL 7.16.2+. The plugin has now disabled itself.', 'dos')
    );

  } elseif (!($curl['features'] & CURL_VERSION_SSL)) {

    dos_incompatibile(
      __(
        'Plugin DigitalOcean Spaces Sync requires that cURL is compiled with OpenSSL. The plugin has now disabled itself.',
        'dos'
      )
    );

  }

}

$instance = DOS::get_instance();
$instance->setup();*/