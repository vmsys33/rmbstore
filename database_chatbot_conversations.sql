-- Database structure for Chatbot Conversations with CICI AI Integration
-- Run this SQL to create the necessary tables

-- Table for storing user information
CREATE TABLE IF NOT EXISTS chatbot_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    user_name VARCHAR(100) NULL,
    user_email VARCHAR(255) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_session_id (session_id),
    INDEX idx_user_email (user_email)
);

-- Table for storing conversation sessions
CREATE TABLE IF NOT EXISTS chatbot_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    user_id INT NULL,
    status ENUM('active', 'completed', 'abandoned') DEFAULT 'active',
    total_messages INT DEFAULT 0,
    first_message_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_message_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES chatbot_users(id) ON DELETE SET NULL,
    INDEX idx_session_id (session_id),
    INDEX idx_status (status)
);

-- Table for storing individual messages
CREATE TABLE IF NOT EXISTS chatbot_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    user_id INT NULL,
    message_type ENUM('user', 'bot', 'system') DEFAULT 'user',
    message_content TEXT NOT NULL,
    cici_ai_used BOOLEAN DEFAULT FALSE,
    cici_ai_response TEXT NULL,
    product_search_query VARCHAR(255) NULL,
    products_found INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES chatbot_users(id) ON DELETE SET NULL,
    INDEX idx_session_id (session_id),
    INDEX idx_message_type (message_type),
    INDEX idx_created_at (created_at)
);

-- Table for storing CICI AI interactions
CREATE TABLE IF NOT EXISTS cici_ai_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    user_id INT NULL,
    user_query TEXT NOT NULL,
    cici_ai_response TEXT NOT NULL,
    response_time_ms INT NULL,
    tokens_used INT NULL,
    cost DECIMAL(10,6) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES chatbot_users(id) ON DELETE SET NULL,
    INDEX idx_session_id (session_id),
    INDEX idx_created_at (created_at)
);

-- Table for storing user product inquiries
CREATE TABLE IF NOT EXISTS user_product_inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_id VARCHAR(255) NOT NULL,
    product_query VARCHAR(255) NOT NULL,
    products_found JSON NULL,
    inquiry_status ENUM('pending', 'responded', 'followed_up', 'closed') DEFAULT 'pending',
    follow_up_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES chatbot_users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_product_query (product_query),
    INDEX idx_status (inquiry_status)
);

-- Insert sample data for testing
INSERT INTO chatbot_users (session_id, user_name, user_email, ip_address) VALUES
('session_sample_1', 'John Doe', 'john@example.com', '192.168.1.100'),
('session_sample_2', 'Jane Smith', 'jane@example.com', '192.168.1.101');

INSERT INTO chatbot_sessions (session_id, user_id, status, total_messages) VALUES
('session_sample_1', 1, 'completed', 5),
('session_sample_2', 2, 'active', 3);

INSERT INTO chatbot_messages (session_id, user_id, message_type, message_content, cici_ai_used) VALUES
('session_sample_1', 1, 'user', 'Do you have MacBook laptops?', FALSE),
('session_sample_1', 1, 'bot', 'Yes, we have several MacBook models available. Let me show you our selection.', FALSE),
('session_sample_2', 2, 'user', 'Looking for iPhone 15', FALSE),
('session_sample_2', 2, 'bot', 'Great choice! We have iPhone 15 in stock. Here are the details:', FALSE);
