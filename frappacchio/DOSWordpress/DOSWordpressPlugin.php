<?php

namespace frappacchio\DOSWordpress;


/**
 * Class DOSWordpressPlugin
 * @package frappacchio\DOSWordpress
 * @property DOSWordpressPlugin $pluginInstance
 */
class DOSWordpressPlugin
{
    /**
     *
     */
    const PLUGIN_NAME = 'DigitalOcean Spaces Sync';
    /**
     *
     */
    const PLUGIN_VERSION = '1.0.0';
    /**
     *
     */
    const PLUGIN_CAPABILITIES = 'manage_options';
    /**
     *
     */
    const PLUGIN_PAGE = 'dos-settings-page.php';
    /**
     * @var PluginFiltersAndActions
     */
    private $pluginInstance;

    /**
     * DOSWordpressPlugin constructor.
     */
    public function __construct()
    {
        load_plugin_textdomain('dos', false, DOS_PLUGIN_FOLDER_RELATIVE_PATH . DIRECTORY_SEPARATOR . 'languages');

        if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {

            if (version_compare(PHP_VERSION, '5.3.3', '<')) {

                $this->incompatibile(
                    __(
                        'Plugin DigitalOcean Spaces Sync requires PHP 5.3.3 or higher. The plugin has now disabled itself.',
                        'dos'
                    )
                );

            } elseif (!function_exists('curl_version')
                || !($curl = curl_version()) || empty($curl['version']) || empty($curl['features'])
                || version_compare($curl['version'], '7.16.2', '<')
            ) {

                $this->incompatibile(
                    __('Plugin DigitalOcean Spaces Sync requires cURL 7.16.2+. The plugin has now disabled itself.', 'dos')
                );

            } elseif (!($curl['features'] & CURL_VERSION_SSL)) {

                $this->incompatibile(
                    __(
                        'Plugin DigitalOcean Spaces Sync requires that cURL is compiled with OpenSSL. The plugin has now disabled itself.',
                        'dos'
                    )
                );

            }

        }

        add_action('admin_init', '\frappacchio\DOSWordpress\PluginSettings::registerSettings');
        add_action('admin_menu', [$this, 'setOptionPage']);
        $this->pluginInstance = new PluginFiltersAndActions();
    }

    public function incompatibile($message)
    {
        require_once ABSPATH . DIRECTORY_SEPARATOR . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'plugin.php';
        deactivate_plugins(__FILE__);
        wp_die($message);
    }

    /**
     * Register the plugin options page including the php file from
     * the plugin folder
     */
    public function registerSettingsPage()
    {
        include_once DOS_PLUGIN_FOLDER . DIRECTORY_SEPARATOR . self::PLUGIN_PAGE;
    }

    /**
     * Add the plugin options page within the main Wordpress settings menu
     */
    public function setOptionPage()
    {
        add_options_page(
            self::PLUGIN_NAME,
            self::PLUGIN_NAME,
            self::PLUGIN_CAPABILITIES,
            self::PLUGIN_PAGE,
            [$this, 'registerSettingsPage']
        );
    }
}