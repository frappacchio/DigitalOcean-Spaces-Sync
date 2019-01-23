<?php

namespace frappacchio\DOSWordpress;


class PluginFiltersAndActions
{
    public function __construct()
    {

    }

    public function addActions()
    {

    }

    public function addFilters()
    {
        add_filter('wp_update_attachment_metadata', array($this, 'filter_wp_update_attachment_metadata'), 20, 1);
        add_filter('wp_unique_filename', array($this, 'filter_wp_unique_filename'));
        if ( ! empty(dos_storage_path)) {
            add_filter('wp_get_attachment_url', array($this, 'filter_wp_get_attachment_url'), 10, 1);
        }
    }
}