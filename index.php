<?php
/**
 * Plugin Name: DigitalOcean Spaces Sync
 * Plugin URI: https://github.com/keeross/DO-Spaces-Wordpress-Sync
 * Description: A php 7.X.X version of the Keeros plugin @see https://github.com/keeross/DO-Spaces-Wordpress-Sync
 * Version: 1.0.0
 * Author: frappacchio
 * Author URI: https://github.com/frappacchio
 * License: MIT
 * Text Domain: dos
 * Domain Path: /languages

 */




require_once 'vendor/autoload.php';

define('DOS_PLUGIN_FOLDER',__DIR__);
define('DOS_PLUGIN_FOLDER_RELATIVE_PATH',dirname(plugin_basename(__FILE__)));
define('DOS_PLUGIN_URL',plugins_url( '', __FILE__ ));

$plugin = new \frappacchio\DOSWordpress\DOSWordpressPlugin();