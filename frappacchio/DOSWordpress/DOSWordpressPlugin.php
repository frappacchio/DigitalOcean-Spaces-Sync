<?php

namespace frappacchio\DOSWordpress;


class DOSWordpressPlugin
{
    public const PLUGIN_NAME = 'DigitalOcean Spaces Sync';
    public const PLUGIN_VERSION = '';
    public const PLUGIN_CAPABILITIES = 'manage_options';
    public const PLUGIN_PAGE = 'dos-settings-page.php';
    public function __construct()
    {
        load_plugin_textdomain('dos', false, DOS_PLUGIN_FOLDER_RELATIVE_PATH.DIRECTORY_SEPARATOR . 'languages');
        add_action('admin_init', '\frappacchio\DOSWordpress\PluginSettings::registerSettings');
        add_action('admin_menu', [$this, 'setOptionPage']);
    }

    public function registerSettingsPage()
    {
        include_once DOS_PLUGIN_FOLDER.DIRECTORY_SEPARATOR.self::PLUGIN_PAGE;
    }

    public function setOptionPage(){
        add_options_page(
            self::PLUGIN_NAME,
            self::PLUGIN_NAME,
            self::PLUGIN_CAPABILITIES,
            self::PLUGIN_PAGE,
            [$this,'registerSettingsPage']
        );
    }
}