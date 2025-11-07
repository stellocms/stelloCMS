<?php

namespace App\Plugins\SimplePage;

class Plugin
{
    public function getName()
    {
        return 'SimplePage';
    }

    public function getTitle()
    {
        return 'Simple Page Plugin';
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDescription()
    {
        return 'A simple plugin for creating pages';
    }

    public function getAuthor()
    {
        return 'StelloCMS Developer';
    }

    public function getAuthorUrl()
    {
        return 'https://stello-cms.com';
    }

    public function isActive()
    {
        // Logic to check if plugin is active can be implemented here
        return true;
    }

    public function install()
    {
        // Logic for installing the plugin can be implemented here
        return true;
    }

    public function uninstall()
    {
        // Logic for uninstalling the plugin can be implemented here
        return true;
    }
}