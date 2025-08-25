-- Create the chatbot_faq table for RMB Store
-- Run this SQL in your database to set up the FAQ system

CREATE TABLE IF NOT EXISTS `chatbot_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) NOT NULL COMMENT 'Search query/keywords for matching user prompts',
  `response` text NOT NULL COMMENT 'Response to return to user',
  `category` varchar(100) DEFAULT 'general' COMMENT 'Category: store_info, products, policies, etc.',
  `priority` int(11) DEFAULT 1 COMMENT 'Priority for search ranking (higher = more important)',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Whether this FAQ is active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_query` (`query`),
  KEY `idx_category` (`category`),
  KEY `idx_priority` (`priority`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample FAQ data
INSERT INTO `chatbot_faq` (`query`, `response`, `category`, `priority`) VALUES
-- Store Information
('store name', '🏪 **RMB Store** - Your trusted electronics and fashion retailer!', 'store_info', 10),
('store hours', '🕒 **Store Hours:**\n• Monday - Friday: 9:00 AM - 6:00 PM\n• Saturday: 10:00 AM - 4:00 PM\n• Sunday: Closed\n\nWe\'re here to serve you during business hours!', 'store_info', 10),
('store location', '📍 **Store Location:**\n123 Main Street, City, State 12345\n\nEasy to find and accessible by public transport!', 'store_info', 10),
('store address', '📍 **Store Address:**\n123 Main Street, City, State 12345\n\nLocated in the heart of downtown!', 'store_info', 9),
('phone number', '📞 **Contact Phone:** +1 (555) 123-4567\n\nCall us for any inquiries or support!', 'store_info', 9),
('email', '📧 **Contact Email:** info@rmbstore.com\n\nSend us an email anytime!', 'store_info', 9),
('contact', '📞 **Contact Information:**\n• Phone: +1 (555) 123-4567\n• Email: info@rmbstore.com\n• Address: 123 Main Street, City, State\n\nWe\'re here to help!', 'store_info', 10),

-- Store Policies
('return policy', '🔄 **Return Policy:**\n• 30-day return window\n• Must have original receipt\n• Item must be unused and in original packaging\n• Refund or exchange available\n• Some items may have different return terms', 'policies', 10),
('warranty', '🛡️ **Warranty Information:**\n• Manufacturer warranty applies\n• Extended warranty available for purchase\n• Coverage varies by product\n• Contact us for warranty claims\n• We handle warranty processing', 'policies', 9),
('payment methods', '💳 **Payment Methods:**\n• Cash\n• Credit/Debit Cards\n• Bank Transfer\n• Online Payment\n• Installment Plans Available\n• We accept all major cards', 'policies', 9),

-- Services
('delivery', '🚚 **Delivery Services:**\n• Free delivery for orders over $100\n• Same-day delivery available (local)\n• Next-day delivery for nearby areas\n• Tracking provided for all deliveries\n• Professional delivery team', 'services', 8),
('installation', '🔧 **Installation Services:**\n• Professional installation available\n• Certified technicians\n• Same-day installation for simple items\n• Warranty on installation work\n• Free consultation and quote', 'services', 8),
('discounts', '💰 **Discounts & Promotions:**\n• Student discounts available\n• Senior citizen discounts\n• Bulk purchase discounts\n• Seasonal sales and promotions\n• Loyalty program rewards\n• Sign up for email alerts!', 'services', 7),

-- Store Amenities
('wifi', '📶 **Free WiFi:**\n• Complimentary WiFi available in-store\n• Network: RMB_Store_Guest\n• Password: Welcome2024\n• High-speed internet for your convenience', 'store_info', 6),
('restroom', '🚻 **Restroom:**\n• Clean restrooms available for customers\n• Located at the back of the store\n• Handicap accessible\n• Baby changing station available', 'store_info', 5),

-- Additional Services
('gift cards', '🎁 **Gift Cards:**\n• Available in denominations from $10 to $500\n• Perfect gift for any occasion\n• Never expires\n• Can be used for any purchase in-store or online', 'services', 7),
('loyalty program', '⭐ **Loyalty Program:**\n• Earn points on every purchase\n• 1 point per $1 spent\n• Redeem points for discounts\n• Exclusive member-only offers\n• Sign up at checkout!', 'services', 7),
('price match', '💰 **Price Match Guarantee:**\n• We match competitor prices\n• Must be same item and condition\n• Valid within 30 days of purchase\n• Bring competitor ad for verification', 'policies', 7),
('bulk orders', '📦 **Bulk Orders:**\n• Special pricing for bulk purchases\n• Corporate accounts welcome\n• Volume discounts available\n• Contact our sales team for quotes', 'services', 6),
('repair services', '🔧 **Repair Services:**\n• Electronics repair available\n• Quick turnaround time\n• Warranty on repairs\n• Free diagnostic service\n• Certified technicians', 'services', 6),
('trade in', '🔄 **Trade-In Program:**\n• Trade in your old devices\n• Get credit toward new purchases\n• Fair market value assessment\n• Eco-friendly disposal of old items', 'services', 6);

-- Create additional indexes for better performance
CREATE INDEX `idx_query_response` ON `chatbot_faq` (`query`, `response`(100));
CREATE INDEX `idx_category_priority` ON `chatbot_faq` (`category`, `priority`);

-- Show the results
SELECT 'FAQ table created successfully!' as status;
SELECT COUNT(*) as total_faqs FROM chatbot_faq;
SELECT category, COUNT(*) as count FROM chatbot_faq GROUP BY category ORDER BY count DESC;
