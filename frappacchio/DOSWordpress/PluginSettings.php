<?php

namespace frappacchio\DOSWordpress;


/**
 * Class PluginSettings
 * @package frappacchio\DOSWordpress
 */
class PluginSettings
{
    /**
     * return the plugin option from defined constant or
     * wordpress setting saved in the database
     * @param string $property
     * @return string|boolean
     */
    public static function get($property)
    {
        if (defined(strtoupper($property))) {
            return constant(strtoupper($property));
        }

        return get_option($property, false);
    }

    /**
     * Save an option value to the database
     * @param string $property
     * @param mixed $value
     * @return bool
     */
    public static function set($property, $value)
    {
        return add_option($property, $value);
    }

    /**
     * Register a setting and its data required for this plugin to work
     */
    public static function registerSettings()
    {
        register_setting('dos_settings', 'dos_key');
        register_setting('dos_settings', 'dos_secret');
        register_setting('dos_settings', 'dos_endpoint');
        register_setting('dos_settings', 'dos_container');
        register_setting('dos_settings', 'dos_storage_path');
        register_setting('dos_settings', 'dos_storage_file_only');
        register_setting('dos_settings', 'dos_storage_file_delete');
        register_setting('dos_settings', 'dos_filter');
        register_setting('dos_settings', 'upload_url_path');
        register_setting('dos_settings', 'upload_path');
        register_setting('dos_settings', 'dos_optimize_images');
    }
}