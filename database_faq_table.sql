-- FAQ Table for Chatbot Store Information
-- This table stores common questions and answers about the store

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

-- Insert sample FAQ data for store information
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
('discounts', '💰 **Current Discounts:**\n• 10% off on electronics (valid until month-end)\n• Buy 2 get 1 free on accessories\n• Student discount: 15% with valid ID\n\nAsk our staff for more details!', 'policies', 8),
('return policy', '🔄 **Return Policy:**\n• 30-day return window for most items\n• Electronics: 14-day return window\n• Must have original receipt and packaging\n• Refund or exchange available', 'policies', 8),
('warranty', '🛡️ **Warranty Information:**\n• Electronics: 1-year manufacturer warranty\n• Extended warranty available for purchase\n• Covers defects in materials and workmanship', 'policies', 7),
('shipping', '🚚 **Shipping Information:**\n• Free shipping on orders over $50\n• Standard delivery: 3-5 business days\n• Express delivery: 1-2 business days\n• International shipping available', 'policies', 7),

-- Payment & Services
('payment methods', '💳 **Accepted Payment Methods:**\n• Cash\n• Credit/Debit Cards (Visa, MasterCard, American Express)\n• Digital Wallets (PayPal, Apple Pay, Google Pay)\n• Bank Transfer\n• Installment plans available', 'services', 8),
('installment', '💳 **Installment Plans:**\n• 0% interest for 6 months on electronics\n• Flexible payment terms available\n• Credit check required\n• Ask our staff for details!', 'services', 7),
('delivery', '🚚 **Delivery Services:**\n• Same-day delivery for local orders\n• Free delivery within 10 miles\n• Professional installation available\n• Track your order online', 'services', 7),

-- Product Categories
('electronics', '📱 **Electronics Department:**\n• Smartphones & Tablets\n• Laptops & Computers\n• Audio & Speakers\n• Gaming & Accessories\n• Smart Home Devices\n\nWe carry top brands at competitive prices!', 'products', 8),
('fashion', '👕 **Fashion Department:**\n• Casual & Formal Wear\n• Shoes & Sneakers\n• Bags & Accessories\n• Jewelry & Watches\n• Seasonal Collections\n\nStay trendy with our latest arrivals!', 'products', 8),
('accessories', '👜 **Accessories Department:**\n• Phone Cases & Covers\n• Chargers & Cables\n• Headphones & Earbuds\n• Bags & Wallets\n• Watches & Jewelry\n\nComplete your look with our accessories!', 'products', 7),

-- General Information
('about us', '🏪 **About RMB Store:**\nWe are a leading electronics and fashion retailer committed to providing quality products and excellent customer service. Founded with a vision to make technology and fashion accessible to everyone.\n\nOur mission is to offer the best products at competitive prices while ensuring customer satisfaction.', 'general', 9),
('business hours', '🕒 **Business Hours:**\n• Monday - Friday: 9:00 AM - 6:00 PM\n• Saturday: 10:00 AM - 4:00 PM\n• Sunday: Closed\n\nExtended hours during holiday seasons!', 'store_info', 9),
('holiday hours', '🎄 **Holiday Hours:**\n• Christmas Eve: 9:00 AM - 3:00 PM\n• Christmas Day: Closed\n• New Year\'s Eve: 9:00 AM - 3:00 PM\n• New Year\'s Day: Closed\n\nCheck our website for special holiday schedules!', 'store_info', 7),
('parking', '🅿️ **Parking Information:**\n• Free parking available in front of the store\n• Street parking available\n• Handicap accessible parking\n• Loading zone for large purchases', 'store_info', 6),
('wifi', '📶 **Free WiFi:**\n• Complimentary WiFi available in-store\n• Network: RMB_Store_Guest\n• Password: Welcome2024\n• High-speed internet for your convenience', 'store_info', 6),
('restroom', '🚻 **Restroom:**\n• Clean restrooms available for customers\n• Located at the back of the store\n• Handicap accessible\n• Baby changing station available', 'store_info', 5),
('gift cards', '🎁 **Gift Cards:**\n• Available in denominations from $10 to $500\n• Perfect gift for any occasion\n• Never expires\n• Can be used for any purchase in-store or online', 'services', 7),
('loyalty program', '⭐ **Loyalty Program:**\n• Earn points on every purchase\n• 1 point per $1 spent\n• Redeem points for discounts\n• Exclusive member-only offers\n• Sign up at checkout!', 'services', 7),
('price match', '💰 **Price Match Guarantee:**\n• We match competitor prices\n• Must be same item and condition\n• Valid within 30 days of purchase\n• Bring competitor ad for verification', 'policies', 7),
('bulk orders', '📦 **Bulk Orders:**\n• Special pricing for bulk purchases\n• Corporate accounts welcome\n• Volume discounts available\n• Contact our sales team for quotes', 'services', 6),
('repair services', '🔧 **Repair Services:**\n• Electronics repair available\n• Quick turnaround time\n• Warranty on repairs\n• Free diagnostic service\n• Certified technicians', 'services', 6),
('trade in', '🔄 **Trade-In Program:**\n• Trade in your old devices\n• Get credit toward new purchases\n• Fair market value assessment\n• Eco-friendly disposal of old items', 'services', 6);

-- Create index for better search performance
CREATE INDEX `idx_query_response` ON `chatbot_faq` (`query`, `response`(100));
CREATE INDEX `idx_category_priority` ON `chatbot_faq` (`category`, `priority`);
