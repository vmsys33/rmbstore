-- Chatbot FAQ Table Setup Script
-- This creates the chatbot_faq table with the proper structure for the FAQ system

-- Drop table if it exists (for clean setup)
DROP TABLE IF EXISTS `chatbot_faq`;

-- Create the chatbot_faq table
CREATE TABLE `chatbot_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) NOT NULL COMMENT 'The question or search query',
  `response` text NOT NULL COMMENT 'The answer or response',
  `category` enum('store_info','products','policies','services','general') NOT NULL DEFAULT 'general' COMMENT 'FAQ category',
  `priority` int(11) NOT NULL DEFAULT 1 COMMENT 'Priority for sorting (higher = more important)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Whether this FAQ is active',
  `keywords` text COMMENT 'Additional keywords for better search matching',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When this FAQ was created',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When this FAQ was last updated',
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`),
  KEY `idx_priority` (`priority`),
  KEY `idx_active` (`is_active`),
  KEY `idx_query` (`query`),
  FULLTEXT KEY `idx_fulltext` (`query`, `response`, `keywords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Chatbot FAQ table for storing questions and answers';

-- Insert sample FAQ data
INSERT INTO `chatbot_faq` (`query`, `response`, `category`, `priority`, `keywords`) VALUES
-- Store Information (High Priority)
('What are your store hours?', 'Our store is open Monday to Friday from 9:00 AM to 8:00 PM, Saturday from 10:00 AM to 6:00 PM, and Sunday from 12:00 PM to 5:00 PM.', 'store_info', 10, 'hours, open, close, time, schedule, business hours'),
('Where is your store located?', 'We are located at 123 Main Street, Downtown Area. We have plenty of parking available and are easily accessible by public transportation.', 'store_info', 10, 'location, address, where, find, directions, parking'),
('Do you have a return policy?', 'Yes! We offer a 30-day return policy for most items. Products must be in original condition with original packaging. Electronics have a 14-day return window. Please bring your receipt for returns.', 'policies', 9, 'return, refund, exchange, policy, receipt, condition'),
('What payment methods do you accept?', 'We accept cash, all major credit cards (Visa, MasterCard, American Express), debit cards, and digital payments like Apple Pay and Google Pay.', 'store_info', 8, 'payment, credit card, cash, apple pay, google pay, visa, mastercard'),
('Do you offer delivery?', 'Yes! We offer local delivery within 10 miles for $15, and free delivery for orders over $100. Delivery typically takes 1-2 business days.', 'services', 8, 'delivery, shipping, free delivery, local delivery'),

-- Products (Medium Priority)
('Do you have laptops?', 'Yes! We carry a wide selection of laptops including MacBooks, Windows laptops, and Chromebooks. We have options for every budget and need.', 'products', 7, 'laptop, computer, macbook, windows, chromebook'),
('What brands do you carry?', 'We carry top brands including Apple, Samsung, Nike, Adidas, Sony, Bose, and many more. We focus on quality brands that our customers trust.', 'products', 6, 'brands, apple, samsung, nike, adidas, sony, bose'),
('Do you have the latest iPhone?', 'Yes! We typically get the latest iPhone models within a week of release. Please call ahead to check current availability.', 'products', 7, 'iphone, latest, new, release, availability'),
('Can I order online?', 'Yes! You can order online through our website. We offer in-store pickup or delivery. Online orders get the same great service as in-store purchases.', 'services', 7, 'online, order, website, pickup, delivery'),

-- General (Lower Priority)
('How can I contact customer service?', 'You can reach our customer service team by phone at (555) 123-4567, email at support@rmbstore.com, or through our live chat on the website.', 'general', 5, 'contact, customer service, phone, email, support, help'),
('Do you offer warranties?', 'Yes! Most products come with manufacturer warranties. We also offer extended warranty options for additional protection on electronics and appliances.', 'policies', 6, 'warranty, extended warranty, protection, electronics'),
('Are you hiring?', 'We occasionally have openings! Please check our website careers page or stop by the store to ask about current job opportunities.', 'general', 3, 'hiring, jobs, careers, employment, work'),
('Do you have a loyalty program?', 'Yes! Join our RMB Rewards program to earn points on every purchase, get exclusive discounts, and receive special offers.', 'services', 6, 'loyalty, rewards, points, discounts, offers, program');

-- Create indexes for better performance
CREATE INDEX `idx_query_lower` ON `chatbot_faq` (LOWER(`query`));
CREATE INDEX `idx_category_priority` ON `chatbot_faq` (`category`, `priority`);

-- Show the created table structure
DESCRIBE `chatbot_faq`;

-- Show sample data
SELECT `id`, `query`, `category`, `priority`, `is_active` FROM `chatbot_faq` ORDER BY `priority` DESC, `category` ASC;
