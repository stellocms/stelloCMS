<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CMS Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls the CMS name and description that will be displayed
    | throughout the application. You can change these values in your .env file.
    |
    */

    'name' => env('CMS_NAME', 'stelloCMS'),
    
    'description' => env('CMS_DESCRIPTION', 'Limitless Online Content Management'),
    
    'team' => env('CMS_TEAM', 'stelloCMS Development Team'),
    
    /*
    |--------------------------------------------------------------------------
    | CMS Branding
    |--------------------------------------------------------------------------
    |
    | These options control the branding elements of the CMS.
    |
    */

    'brand' => [
        'logo' => env('CMS_LOGO', null),
        'favicon' => env('CMS_FAVICON', null),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | CMS Settings
    |--------------------------------------------------------------------------
    |
    | These options control various CMS settings.
    |
    */

    'settings' => [
        'allow_registration' => env('CMS_ALLOW_REGISTRATION', false),
        'default_role' => env('CMS_DEFAULT_ROLE', 'warga'),
    ],
];