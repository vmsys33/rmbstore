<?php

namespace App\Services;

use App\Models\SettingsModel;

class CurrencyService
{
    private static $instance = null;
    private $settings = null;
    
    private function __construct()
    {
        $this->loadSettings();
    }
    
    /**
     * Get singleton instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Load settings from database
     */
    private function loadSettings(): void
    {
        $settingsModel = new SettingsModel();
        $this->settings = $settingsModel->first() ?: [
            'currency' => 'USD',
            'tax_rate' => 0.00,
            'shipping_cost' => 0.00
        ];
    }
    
    /**
     * Get current currency code
     */
    public function getCurrency(): string
    {
        return $this->settings['currency'] ?? 'USD';
    }
    
    /**
     * Get currency symbol
     */
    public function getSymbol(): string
    {
        $currency = $this->getCurrency();
        
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
     * Get currency name
     */
    public function getName(): string
    {
        $currency = $this->getCurrency();
        
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
     * Format amount with currency
     */
    public function format(float $amount, int $decimals = 2): string
    {
        $symbol = $this->getSymbol();
        $currency = $this->getCurrency();
        
        // Special formatting for certain currencies
        if ($currency === 'JPY') {
            $decimals = 0;
        }
        
        $formattedAmount = number_format($amount, $decimals, '.', ',');
        
        // Position symbol based on currency
        if (in_array($currency, ['USD', 'CAD', 'AUD', 'PHP'])) {
            return $symbol . $formattedAmount;
        } else {
            return $formattedAmount . ' ' . $symbol;
        }
    }
    
    /**
     * Format amount without symbol
     */
    public function formatAmount(float $amount, int $decimals = 2): string
    {
        $currency = $this->getCurrency();
        
        if ($currency === 'JPY') {
            $decimals = 0;
        }
        
        return number_format($amount, $decimals, '.', ',');
    }
    
    /**
     * Get tax rate
     */
    public function getTaxRate(): float
    {
        return (float) ($this->settings['tax_rate'] ?? 0.00);
    }
    
    /**
     * Get shipping cost
     */
    public function getShippingCost(): float
    {
        return (float) ($this->settings['shipping_cost'] ?? 0.00);
    }
    
    /**
     * Calculate tax
     */
    public function calculateTax(float $amount): float
    {
        $taxRate = $this->getTaxRate();
        return $amount * ($taxRate / 100);
    }
    
    /**
     * Calculate total with tax
     */
    public function calculateTotalWithTax(float $amount): float
    {
        return $amount + $this->calculateTax($amount);
    }
    
    /**
     * Calculate total with tax and shipping
     */
    public function calculateTotalWithTaxAndShipping(float $amount): float
    {
        return $this->calculateTotalWithTax($amount) + $this->getShippingCost();
    }
    
    /**
     * Refresh settings (useful after settings update)
     */
    public function refresh(): void
    {
        $this->loadSettings();
    }
    
    /**
     * Get all currency options for forms
     */
    public function getCurrencyOptions(): array
    {
        return [
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
    }
}
