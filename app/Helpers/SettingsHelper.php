<?php

namespace App\Helpers;

use App\Models\SettingsModel;

class SettingsHelper
{
    private static $settings = null;

    /**
     * Get settings data
     */
    public static function getSettings()
    {
        if (self::$settings === null) {
            $model = new SettingsModel();
            self::$settings = $model->getSettings() ?: [];
        }
        return self::$settings;
    }

    /**
     * Get a specific setting value
     */
    public static function get($key, $default = '')
    {
        $settings = self::getSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Get store name
     */
    public static function getStoreName()
    {
        return self::get('store_name', 'Store');
    }

    /**
     * Get store logo
     */
    public static function getStoreLogo()
    {
        return self::get('store_logo');
    }

    /**
     * Get navicon
     */
    public static function getNavicon()
    {
        return self::get('navicon');
    }

    /**
     * Get store icon
     */
    public static function getStoreIcon()
    {
        return self::get('store_icon');
    }
}
