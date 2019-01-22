<?php

namespace frappacchio\DOSWordpress;


class PluginSettings
{
    public static function get($property)
    {
        if (defined(strtoupper($property))) {
            return constant(strtoupper($property));
        }

        return get_option($property, false);
    }

    public static function set($property, $value)
    {
        return add_option($property, $value);
    }

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
    }
}