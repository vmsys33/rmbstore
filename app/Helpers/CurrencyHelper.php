<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Get the currency symbol
     */
    public static function getCurrencySymbol(): string
    {
        return '₱'; // Philippine Peso
    }

    /**
     * Get the currency code
     */
    public static function getCurrency(): string
    {
        return 'PHP';
    }

    /**
     * Format amount with currency symbol
     */
    public static function format(float $amount, int $decimals = 2): string
    {
        return self::getCurrencySymbol() . number_format($amount, $decimals, '.', ',');
    }

    /**
     * Format amount without currency symbol
     */
    public static function formatAmount(float $amount, int $decimals = 2): string
    {
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
}
