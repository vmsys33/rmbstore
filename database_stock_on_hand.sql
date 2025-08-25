-- Stock on Hand System Setup
-- This creates the necessary table and modifies existing tables

-- Create stock_on_hand table
CREATE TABLE IF NOT EXISTS `stock_on_hand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive','depleted') NOT NULL DEFAULT 'active',
  `notes` text,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `status` (`status`),
  KEY `date_added` (`date_added`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add stock_on_hand_id to products table if it doesn't exist
ALTER TABLE `products` 
ADD COLUMN IF NOT EXISTS `stock_on_hand_id` int(11) NULL AFTER `id`,
ADD INDEX IF NOT EXISTS `idx_stock_on_hand` (`stock_on_hand_id`);

-- Add stock_on_hand_id to sales table if it doesn't exist
ALTER TABLE `sales` 
ADD COLUMN IF NOT EXISTS `stock_on_hand_id` int(11) NULL AFTER `product_id`,
ADD INDEX IF NOT EXISTS `idx_stock_on_hand` (`stock_on_hand_id`);

-- Insert sample stock data for existing products
INSERT INTO `stock_on_hand` (`product_id`, `quantity`, `status`, `notes`) 
SELECT 
    p.id,
    COALESCE(p.stock, 0) as quantity,
    CASE 
        WHEN COALESCE(p.stock, 0) > 0 THEN 'active'
        ELSE 'depleted'
    END as status,
    'Initial stock from existing product data' as notes
FROM `products` p
WHERE NOT EXISTS (
    SELECT 1 FROM `stock_on_hand` soh WHERE soh.product_id = p.id
);

-- Update products table to reference stock_on_hand
UPDATE `products` p 
INNER JOIN `stock_on_hand` soh ON p.id = soh.product_id
SET p.stock_on_hand_id = soh.id
WHERE p.stock_on_hand_id IS NULL;

-- Create view for easy stock reporting
CREATE OR REPLACE VIEW `product_stock_summary` AS
SELECT 
    p.id,
    p.product_name,
    p.category,
    p.price,
    p.featured_image,
    COALESCE(soh.quantity, 0) as stock_on_hand,
    COALESCE(sold.total_sold, 0) as total_sold,
    GREATEST(COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0), 0) as remaining_quantity,
    soh.status as stock_status,
    soh.date_updated as last_stock_update,
    CASE 
        WHEN COALESCE(soh.quantity, 0) = 0 THEN 'Out of Stock'
        WHEN COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0) <= 0 THEN 'Sold Out'
        WHEN COALESCE(soh.quantity, 0) - COALESCE(sold.total_sold, 0) <= 5 THEN 'Low Stock'
        ELSE 'In Stock'
    END as availability_status
FROM `products` p
LEFT JOIN `stock_on_hand` soh ON p.stock_on_hand_id = soh.id
LEFT JOIN (
    SELECT 
        product_id,
        SUM(quantity) as total_sold
    FROM `sales` 
    GROUP BY product_id
) sold ON p.id = sold.product_id
ORDER BY p.product_name;
