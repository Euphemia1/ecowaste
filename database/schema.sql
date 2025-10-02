-- EcoWaste Database Schema
-- Sustainable Waste Management Platform

CREATE DATABASE IF NOT EXISTS ecowaste_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecowaste_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    account_type ENUM('individual', 'business') NOT NULL DEFAULT 'individual',
    company_name VARCHAR(255) NULL,
    email_verified BOOLEAN DEFAULT FALSE,
    email_verification_token VARCHAR(255) NULL,
    password_reset_token VARCHAR(255) NULL,
    password_reset_expires DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active'
);

-- User addresses table
CREATE TABLE user_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address_line_1 VARCHAR(255) NOT NULL,
    address_line_2 VARCHAR(255) NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL DEFAULT 'USA',
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Waste categories table
CREATE TABLE waste_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(100),
    color VARCHAR(7) DEFAULT '#22c55e',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default waste categories
INSERT INTO waste_categories (name, slug, description, icon) VALUES
('Recyclables', 'recyclables', 'Paper, cardboard, plastic bottles, aluminum cans', 'recycle'),
('Electronics', 'electronics', 'Computers, phones, batteries, electronic devices', 'laptop'),
('Organic Waste', 'organic', 'Food scraps, yard waste, compostable materials', 'leaf'),
('Hazardous Materials', 'hazardous', 'Chemicals, paints, oils, toxic materials', 'warning'),
('Bulky Items', 'bulky', 'Furniture, appliances, large household items', 'truck');

-- Pickup requests table
CREATE TABLE pickup_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address_id INT NOT NULL,
    request_number VARCHAR(20) NOT NULL UNIQUE,
    pickup_date DATE NOT NULL,
    time_slot ENUM('morning', 'afternoon', 'evening') NOT NULL,
    special_instructions TEXT,
    status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    total_weight DECIMAL(8,2) DEFAULT 0.00,
    estimated_weight DECIMAL(8,2) DEFAULT 0.00,
    pickup_fee DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (address_id) REFERENCES user_addresses(id) ON DELETE CASCADE
);

-- Pickup request items table
CREATE TABLE pickup_request_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pickup_request_id INT NOT NULL,
    waste_category_id INT NOT NULL,
    estimated_weight DECIMAL(8,2) NOT NULL,
    actual_weight DECIMAL(8,2) DEFAULT 0.00,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pickup_request_id) REFERENCES pickup_requests(id) ON DELETE CASCADE,
    FOREIGN KEY (waste_category_id) REFERENCES waste_categories(id) ON DELETE CASCADE
);

-- User environmental impact table
CREATE TABLE user_environmental_impact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    month TINYINT NOT NULL,
    year YEAR NOT NULL,
    total_recycled_weight DECIMAL(10,2) DEFAULT 0.00,
    co2_saved DECIMAL(10,2) DEFAULT 0.00,
    trees_saved DECIMAL(8,2) DEFAULT 0.00,
    water_saved DECIMAL(10,2) DEFAULT 0.00,
    recycling_rate DECIMAL(5,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_month_year (user_id, month, year)
);

-- Recycling guides table
CREATE TABLE recycling_guides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    tips TEXT,
    do_list JSON,
    dont_list JSON,
    recycling_codes JSON,
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample recycling guides
INSERT INTO recycling_guides (title, slug, category, content, tips, do_list, dont_list) VALUES
('Paper and Cardboard Recycling', 'paper-cardboard', 'Paper', 
'Paper and cardboard are among the most commonly recycled materials. Proper preparation ensures they can be effectively processed into new products.',
'Remove all staples, tape, and plastic components before recycling.',
'["Clean paper products", "Flatten cardboard boxes", "Remove plastic windows from envelopes"]',
'["Wet or contaminated paper", "Wax-coated paper", "Paper with food residue"]'
),
('Plastic Recycling Guide', 'plastic-recycling', 'Plastic',
'Understanding plastic recycling codes helps you properly sort and recycle plastic items. Not all plastics are recyclable in every program.',
'Check the recycling number on the bottom of plastic containers.',
'["Rinse containers clean", "Remove caps and lids", "Check local recycling guidelines"]',
'["Black plastic containers", "Plastic bags in curbside bins", "Styrofoam"]'
);

-- System settings table
CREATE TABLE system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default system settings
INSERT INTO system_settings (setting_key, setting_value, setting_type, description) VALUES
('site_name', 'EcoWaste', 'string', 'Website name'),
('site_email', 'admin@ecowaste.com', 'string', 'Site contact email'),
('pickup_fee_per_kg', '2.50', 'string', 'Fee per kilogram for pickup'),
('min_pickup_weight', '5.00', 'string', 'Minimum weight for pickup request'),
('max_pickup_weight', '500.00', 'string', 'Maximum weight per pickup'),
('email_notifications', 'true', 'boolean', 'Enable email notifications');

-- Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin', 'moderator') DEFAULT 'admin',
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_pickup_requests_user_id ON pickup_requests(user_id);
CREATE INDEX idx_pickup_requests_status ON pickup_requests(status);
CREATE INDEX idx_pickup_requests_date ON pickup_requests(pickup_date);
CREATE INDEX idx_environmental_impact_user_date ON user_environmental_impact(user_id, year, month);
CREATE INDEX idx_recycling_guides_category ON recycling_guides(category);
CREATE INDEX idx_recycling_guides_featured ON recycling_guides(is_featured);