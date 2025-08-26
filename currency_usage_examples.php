<?php
/**
 * Global Currency System Usage Examples
 * 
 * This file demonstrates how to use the new global currency system
 * throughout your rmbstore application.
 */

// ============================================================================
// 1. USING GLOBAL HELPER FUNCTIONS (Recommended - Easy to use)
// ============================================================================

// Make sure to include the helper file in your autoload or at the top of your views
// require_once 'app/Helpers/GlobalCurrencyHelper.php';

// Get currency information
$symbol = currency_symbol();        // Returns: $, €, £, ¥, etc.
$code = currency_code();           // Returns: USD, EUR, GBP, JPY, etc.
$name = currency_name();           // Returns: US Dollar, Euro, British Pound, etc.

// Format amounts
$formattedPrice = format_currency(99.99);        // Returns: $99.99 (or €99.99, etc.)
$formattedAmount = format_amount(99.99);         // Returns: 99.99 (no symbol)

// Tax and shipping calculations
$taxRate = get_tax_rate();                      // Returns: 5.00 (from settings)
$shippingCost = get_shipping_cost();            // Returns: 10.00 (from settings)
$taxAmount = calculate_tax(100.00);             // Returns: 5.00 (5% of 100)
$totalWithTax = calculate_total_with_tax(100.00); // Returns: 105.00
$totalWithTaxAndShipping = calculate_total_with_tax_and_shipping(100.00); // Returns: 115.00

// ============================================================================
// 2. USING THE CURRENCY SERVICE (More control)
// ============================================================================

use App\Services\CurrencyService;

$currencyService = CurrencyService::getInstance();

$symbol = $currencyService->getSymbol();
$code = $currencyService->getCurrency();
$name = $currencyService->getName();
$formattedPrice = $currencyService->format(99.99);

// ============================================================================
// 3. USING THE CURRENCY HELPER (Legacy support)
// ============================================================================

use App\Helpers\CurrencyHelper;

$symbol = CurrencyHelper::getCurrencySymbol();
$code = CurrencyHelper::getCurrency();
$formattedPrice = CurrencyHelper::format(99.99);

// ============================================================================
// 4. IN YOUR VIEWS (Most common usage)
// ============================================================================

// In your Blade/PHP views, you can use:
?>
<!-- Display product price with current currency -->
<div class="product-price">
    Price: <?= format_currency($product['price']) ?>
</div>

<!-- Display sale price -->
<?php if ($product['sale_price']): ?>
    <div class="sale-price">
        Sale: <?= format_currency($product['sale_price']) ?>
    </div>
<?php endif; ?>

<!-- Display tax information -->
<div class="tax-info">
    Tax Rate: <?= get_tax_rate() ?>%
    Tax Amount: <?= format_currency(calculate_tax($product['price'])) ?>
</div>

<!-- Display total with tax -->
<div class="total">
    Total: <?= format_currency(calculate_total_with_tax($product['price'])) ?>
</div>

<!-- ============================================================================
5. IN YOUR CONTROLLERS
============================================================================ -->

// In your controllers, you can inject the service:
public function showProduct($id)
{
    $product = $this->productModel->find($id);
    $currencyService = CurrencyService::getInstance();
    
    $data = [
        'product' => $product,
        'currency_symbol' => $currencyService->getSymbol(),
        'currency_code' => $currencyService->getCurrency(),
        'formatted_price' => $currencyService->format($product['price']),
        'tax_rate' => $currencyService->getTaxRate(),
        'total_with_tax' => $currencyService->calculateTotalWithTax($product['price'])
    ];
    
    return view('products/show', $data);
}

// ============================================================================
// 6. IN YOUR JAVASCRIPT (Frontend)
// ============================================================================

// You can pass currency data to JavaScript:
<script>
const currencySymbol = '<?= currency_symbol() ?>';
const currencyCode = '<?= currency_code() ?>';
const taxRate = <?= get_tax_rate() ?>;

function formatCurrency(amount) {
    return currencySymbol + parseFloat(amount).toFixed(2);
}

function calculateTax(amount) {
    return amount * (taxRate / 100);
}

function calculateTotal(amount) {
    return amount + calculateTax(amount);
}
</script>

// ============================================================================
// 7. REFRESHING CURRENCY SETTINGS
// ============================================================================

// After updating settings, refresh the cache:
refresh_currency_settings();

// Or in your controller:
CurrencyService::getInstance()->refresh();
CurrencyHelper::clearCache();

// ============================================================================
// 8. BENEFITS OF THE NEW SYSTEM
// ============================================================================

/*
✅ GLOBAL: Currency settings apply everywhere automatically
✅ DYNAMIC: Change currency in admin settings, updates everywhere
✅ CACHED: Settings are cached for performance
✅ FLEXIBLE: Multiple ways to use (helpers, service, or helper class)
✅ TAX SUPPORT: Built-in tax calculations
✅ SHIPPING SUPPORT: Built-in shipping cost handling
✅ MULTI-CURRENCY: Support for 10+ currencies
✅ FORMATTING: Proper currency formatting for each currency type
✅ MOBILE FRIENDLY: Works perfectly on all devices
*/

// ============================================================================
// 9. SUPPORTED CURRENCIES
// ============================================================================

/*
USD - US Dollar ($)
EUR - Euro (€)
GBP - British Pound (£)
JPY - Japanese Yen (¥)
CAD - Canadian Dollar ($)
AUD - Australian Dollar ($)
CHF - Swiss Franc (₣)
CNY - Chinese Yuan (¥)
INR - Indian Rupee (₹)
PHP - Philippine Peso (₱)
*/

// ============================================================================
// 10. AUTOMATIC UPDATES
// ============================================================================

/*
When you change currency in Admin → Settings:
1. Settings are saved to database
2. Currency cache is automatically refreshed
3. All pages immediately show new currency
4. No need to restart or clear other caches
5. Changes apply to all users instantly
*/
