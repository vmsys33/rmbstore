<?php

/**
 * Currency Helper
 * Provides currency-related functions for the application
 */

if (!function_exists('currency_symbol')) {
    /**
     * Get current currency symbol
     */
    function currency_symbol(): string
    {
        try {
            return \App\Services\CurrencyService::getInstance()->getSymbol();
        } catch (Exception $e) {
            return '$'; // Fallback to dollar sign
        }
    }
}

if (!function_exists('currency_code')) {
    /**
     * Get current currency code
     */
    function currency_code(): string
    {
        try {
            return \App\Services\CurrencyService::getInstance()->getCurrency();
        } catch (Exception $e) {
            return 'USD'; // Fallback to USD
        }
    }
}

if (!function_exists('currency_name')) {
    /**
     * Get current currency name
     */
    function currency_name(): string
    {
        try {
            return \App\Services\CurrencyService::getInstance()->getName();
        } catch (Exception $e) {
            return 'US Dollar'; // Fallback
        }
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format amount with currency symbol
     */
    function format_currency(float $amount, int $decimals = 2): string
    {
        try {
            return \App\Services\CurrencyService::getInstance()->format($amount, $decimals);
        } catch (Exception $e) {
            return '$' . number_format($amount, $decimals); // Fallback
        }
    }
}

if (!function_exists('format_amount')) {
    /**
     * Format amount without currency symbol
     */
    function format_amount(float $amount, int $decimals = 2): string
    {
        try {
            return \App\Services\CurrencyService::getInstance()->formatAmount($amount, $decimals);
        } catch (Exception $e) {
            return number_format($amount, $decimals); // Fallback
        }
    }
}

if (!function_exists('get_tax_rate')) {
    /**
     * Get current tax rate
     */
    function get_tax_rate(): float
    {
        try {
            return \App\Services\CurrencyService::getInstance()->getTaxRate();
        } catch (Exception $e) {
            return 0.00; // Fallback
        }
    }
}

if (!function_exists('get_shipping_cost')) {
    /**
     * Get current shipping cost
     */
    function get_shipping_cost(): float
    {
        try {
            return \App\Services\CurrencyService::getInstance()->getShippingCost();
        } catch (Exception $e) {
            return 0.00; // Fallback
        }
    }
}

if (!function_exists('calculate_tax')) {
    /**
     * Calculate tax amount
     */
    function calculate_tax(float $amount): float
    {
        try {
            return \App\Services\CurrencyService::getInstance()->calculateTax($amount);
        } catch (Exception $e) {
            return 0.00; // Fallback
        }
    }
}

if (!function_exists('calculate_total_with_tax')) {
    /**
     * Calculate total with tax
     */
    function calculate_total_with_tax(float $amount): float
    {
        try {
            return \App\Services\CurrencyService::getInstance()->calculateTotalWithTax($amount);
        } catch (Exception $e) {
            return $amount; // Fallback
        }
    }
}

if (!function_exists('calculate_total_with_tax_and_shipping')) {
    /**
     * Calculate total with tax and shipping
     */
    function calculate_total_with_tax_and_shipping(float $amount): float
    {
        try {
            return \App\Services\CurrencyService::getInstance()->calculateTotalWithTaxAndShipping($amount);
        } catch (Exception $e) {
            return $amount; // Fallback
        }
    }
}

if (!function_exists('refresh_currency_settings')) {
    /**
     * Refresh currency settings (useful after settings update)
     */
    function refresh_currency_settings(): void
    {
        try {
            \App\Services\CurrencyService::getInstance()->refresh();
        } catch (Exception $e) {
            // Silently fail
        }
    }
}
