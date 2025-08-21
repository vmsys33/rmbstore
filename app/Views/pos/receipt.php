<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - <?= $sale['sale_number'] ?></title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .receipt {
            max-width: 300px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .store-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .sale-info {
            margin-bottom: 15px;
        }
        .items {
            margin-bottom: 15px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .item-name {
            flex: 1;
        }
        .item-price {
            text-align: right;
        }
        .totals {
            border-top: 1px dashed #ddd;
            padding-top: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                border: none;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="store-name">RMB STORE</div>
            <div>Point of Sale Receipt</div>
            <div><?= $sale['sale_number'] ?></div>
            <div><?= date('M d, Y H:i', strtotime($sale['created_at'])) ?></div>
        </div>

        <div class="sale-info">
            <?php if ($sale['customer_name']): ?>
                <div><strong>Customer:</strong> <?= $sale['customer_name'] ?></div>
                <?php if ($sale['customer_email']): ?>
                    <div><strong>Email:</strong> <?= $sale['customer_email'] ?></div>
                <?php endif; ?>
                <?php if ($sale['customer_phone']): ?>
                    <div><strong>Phone:</strong> <?= $sale['customer_phone'] ?></div>
                <?php endif; ?>
            <?php else: ?>
                <div><strong>Customer:</strong> Walk-in Customer</div>
            <?php endif; ?>
        </div>

        <div class="items">
            <?php foreach ($sale['items'] as $item): ?>
                <div class="item">
                    <div class="item-name">
                        <?= $item['product_name'] ?><br>
                        <small><?= $item['quantity'] ?> × ₱<?= number_format($item['unit_price'], 2) ?></small>
                        <?php if ($item['discount_percent'] > 0): ?>
                            <br><small>Discount: <?= $item['discount_percent'] ?>%</small>
                        <?php endif; ?>
                    </div>
                    <div class="item-price">₱<?= number_format($item['total_amount'], 2) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₱<?= number_format($sale['subtotal'], 2) ?></span>
            </div>
            <div class="total-row">
                <span>Tax (12%):</span>
                <span>₱<?= number_format($sale['tax_amount'], 2) ?></span>
            </div>
            <?php if ($sale['discount_amount'] > 0): ?>
                <div class="total-row">
                    <span>Discount:</span>
                    <span>-₱<?= number_format($sale['discount_amount'], 2) ?></span>
                </div>
            <?php endif; ?>
            <div class="total-row final">
                <span>TOTAL:</span>
                <span>₱<?= number_format($sale['total_amount'], 2) ?></span>
            </div>
        </div>

        <div class="payment-info">
            <div><strong>Payment Method:</strong> <?= ucfirst(str_replace('_', ' ', $sale['payment_method'])) ?></div>
            <div><strong>Payment Status:</strong> <?= ucfirst($sale['payment_status']) ?></div>
            <div><strong>Sale Status:</strong> <?= ucfirst($sale['sale_status']) ?></div>
        </div>

        <?php if ($sale['notes']): ?>
            <div class="notes" style="margin-top: 15px; padding-top: 10px; border-top: 1px dashed #ddd;">
                <div><strong>Notes:</strong></div>
                <div><?= $sale['notes'] ?></div>
            </div>
        <?php endif; ?>

        <div class="footer">
            <div>Thank you for your purchase!</div>
            <div>Please keep this receipt for your records.</div>
            <div style="margin-top: 10px;">
                <div>RMB Store</div>
                <div>Point of Sale System</div>
                <div>Generated on <?= date('M d, Y H:i:s') ?></div>
            </div>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
