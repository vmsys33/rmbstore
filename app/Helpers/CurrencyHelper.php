<?php

namespace App\Helpers;

use App\Models\SettingsModel;

class CurrencyHelper
{
    private static $settings = null;
    private static $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'CAD' => '$',
        'AUD' => '$',
        'CHF' => '₣',
        'CNY' => '¥',
        'INR' => '₹',
        'PHP' => '₱'
    ];

    /**
     * Get settings from database (cached)
     */
    private static function getSettings()
    {
        if (self::$settings === null) {
            $settingsModel = new SettingsModel();
            self::$settings = $settingsModel->getSettings();
        }
        return self::$settings;
    }

    /**
     * Get current currency from settings
     */
    public static function getCurrency()
    {
        $settings = self::getSettings();
        return $settings['currency'] ?? 'PHP';
    }

    /**
     * Get currency symbol from settings
     */
    public static function getCurrencySymbol()
    {
        $currency = self::getCurrency();
        return self::$currencySymbols[$currency] ?? '₱';
    }

    /**
     * Format amount with currency symbol
     */
    public static function format($amount, $decimals = 2)
    {
        $symbol = self::getCurrencySymbol();
        $formattedAmount = number_format($amount, $decimals, '.', ',');
        return $symbol . $formattedAmount;
    }

    /**
     * Format amount without currency symbol
     */
    public static function formatAmount($amount, $decimals = 2)
    {
        return number_format($amount, $decimals, '.', ',');
    }

    /**
     * Get all currency symbols for dropdowns
     */
    public static function getCurrencySymbols()
    {
        return self::$currencySymbols;
    }

    /**
     * Get currency options for select dropdowns
     */
    public static function getCurrencyOptions()
    {
        $options = [
            'USD' => '$ USD (US Dollar)',
            'EUR' => '€ EUR (Euro)',
            'GBP' => '£ GBP (British Pound)',
            'JPY' => '¥ JPY (Japanese Yen)',
            'CAD' => '$ CAD (Canadian Dollar)',
            'AUD' => '$ AUD (Australian Dollar)',
            'CHF' => '₣ CHF (Swiss Franc)',
            'CNY' => '¥ CNY (Chinese Yuan)',
            'INR' => '₹ INR (Indian Rupee)',
            'PHP' => '₱ PHP (Philippine Peso)'
        ];
        return $options;
    }
}
