<?php

/**
 * Global Currency Helper Functions
 * These functions can be used anywhere in your application
 */

if (!function_exists('currency_symbol')) {
    /**
     * Get current currency symbol
     */
    function currency_symbol(): string
    {
        return \App\Services\CurrencyService::getInstance()->getSymbol();
    }
}

if (!function_exists('currency_code')) {
    /**
     * Get current currency code
     */
    function currency_code(): string
    {
        return \App\Services\CurrencyService::getInstance()->getCurrency();
    }
}

if (!function_exists('currency_name')) {
    /**
     * Get current currency name
     */
    function currency_name(): string
    {
        return \App\Services\CurrencyService::getInstance()->getName();
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format amount with currency symbol
     */
    function format_currency($amount, int $decimals = 2): string
    {
        // Handle null or empty values
        if ($amount === null || $amount === '') {
            return '-';
        }
        
        // Convert to float
        $amount = (float) $amount;
        
        return \App\Services\CurrencyService::getInstance()->format($amount, $decimals);
    }
}

if (!function_exists('format_amount')) {
    /**
     * Format amount without currency symbol
     */
    function format_amount($amount, int $decimals = 2): string
    {
        // Handle null or empty values
        if ($amount === null || $amount === '') {
            return '-';
        }
        
        // Convert to float
        $amount = (float) $amount;
        
        return \App\Services\CurrencyService::getInstance()->formatAmount($amount, $decimals);
    }
}

if (!function_exists('get_tax_rate')) {
    /**
     * Get current tax rate
     */
    function get_tax_rate(): float
    {
        return \App\Services\CurrencyService::getInstance()->getTaxRate();
    }
}

if (!function_exists('get_shipping_cost')) {
    /**
     * Get current shipping cost
     */
    function get_shipping_cost(): float
    {
        return \App\Services\CurrencyService::getInstance()->getShippingCost();
    }
}

if (!function_exists('calculate_tax')) {
    /**
     * Calculate tax amount
     */
    function calculate_tax($amount): float
    {
        // Handle null or empty values
        if ($amount === null || $amount === '') {
            return 0.00;
        }
        
        // Convert to float
        $amount = (float) $amount;
        
        return \App\Services\CurrencyService::getInstance()->calculateTax($amount);
    }
}

if (!function_exists('calculate_total_with_tax')) {
    /**
     * Calculate total with tax
     */
    function calculate_total_with_tax($amount): float
    {
        // Handle null or empty values
        if ($amount === null || $amount === '') {
            return 0.00;
        }
        
        // Convert to float
        $amount = (float) $amount;
        
        return \App\Services\CurrencyService::getInstance()->calculateTotalWithTax($amount);
    }
}

if (!function_exists('calculate_total_with_tax_and_shipping')) {
    /**
     * Calculate total with tax and shipping
     */
    function calculate_total_with_tax_and_shipping($amount): float
    {
        // Handle null or empty values
        if ($amount === null || $amount === '') {
            return 0.00;
        }
        
        // Convert to float
        $amount = (float) $amount;
        
        return \App\Services\CurrencyService::getInstance()->calculateTotalWithTaxAndShipping($amount);
    }
}

if (!function_exists('refresh_currency_settings')) {
    /**
     * Refresh currency settings (useful after settings update)
     */
    function refresh_currency_settings(): void
    {
        \App\Services\CurrencyService::getInstance()->refresh();
    }
}
