<?php

namespace App\Helpers;

use App\Models\SettingsModel;

class CurrencyHelper
{
    private static $settings = null;
    
    /**
     * Get settings from database (cached)
     */
    private static function getSettings(): array
    {
        if (self::$settings === null) {
            $settingsModel = new SettingsModel();
            $settings = $settingsModel->first();
            self::$settings = $settings ?: ['currency' => 'USD', 'tax_rate' => 0.00];
        }
        return self::$settings;
    }
    
    /**
     * Get the currency symbol based on settings
     */
    public static function getCurrencySymbol(): string
    {
        $currency = self::getSettings()['currency'] ?? 'USD';
        
        $symbols = [
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
        
        return $symbols[$currency] ?? '$';
    }

    /**
     * Get the currency code from settings
     */
    public static function getCurrency(): string
    {
        return self::getSettings()['currency'] ?? 'USD';
    }
    
    /**
     * Get the full currency name
     */
    public static function getCurrencyName(): string
    {
        $currency = self::getSettings()['currency'] ?? 'USD';
        
        $names = [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'JPY' => 'Japanese Yen',
            'CAD' => 'Canadian Dollar',
            'AUD' => 'Australian Dollar',
            'CHF' => 'Swiss Franc',
            'CNY' => 'Chinese Yuan',
            'INR' => 'Indian Rupee',
            'PHP' => 'Philippine Peso'
        ];
        
        return $names[$currency] ?? 'US Dollar';
    }

    /**
     * Format amount with currency symbol
     */
    public static function format(float $amount, int $decimals = 2): string
    {
        $symbol = self::getCurrencySymbol();
        $currency = self::getCurrency();
        
        // Special formatting for certain currencies
        if ($currency === 'JPY') {
            $decimals = 0; // No decimals for JPY
        }
        
        $formattedAmount = number_format($amount, $decimals, '.', ',');
        
        // Position symbol based on currency
        if (in_array($currency, ['USD', 'CAD', 'AUD', 'PHP'])) {
            return $symbol . $formattedAmount; // Symbol before amount
        } else {
            return $formattedAmount . ' ' . $symbol; // Symbol after amount
        }
    }

    /**
     * Format amount without currency symbol
     */
    public static function formatAmount(float $amount, int $decimals = 2): string
    {
        $currency = self::getCurrency();
        
        // Special formatting for certain currencies
        if ($currency === 'JPY') {
            $decimals = 0; // No decimals for JPY
        }
        
        return number_format($amount, $decimals, '.', ',');
    }

    /**
     * Parse currency string to float
     */
    public static function parse(string $amount): float
    {
        // Remove currency symbol and commas, then convert to float
        $cleanAmount = preg_replace('/[^\d.-]/', '', $amount);
        return (float) $cleanAmount;
    }
    
    /**
     * Get tax rate from settings
     */
    public static function getTaxRate(): float
    {
        return (float) (self::getSettings()['tax_rate'] ?? 0.00);
    }
    
    /**
     * Calculate tax amount
     */
    public static function calculateTax(float $amount): float
    {
        $taxRate = self::getTaxRate();
        return $amount * ($taxRate / 100);
    }
    
    /**
     * Calculate total with tax
     */
    public static function calculateTotalWithTax(float $amount): float
    {
        return $amount + self::calculateTax($amount);
    }
    
    /**
     * Clear cached settings (useful after settings update)
     */
    public static function clearCache(): void
    {
        self::$settings = null;
    }
}
