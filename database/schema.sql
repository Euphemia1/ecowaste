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
    province VARCHAR(100) NOT NULL DEFAULT 'Lusaka',
    district VARCHAR(100),
    township VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) NOT NULL DEFAULT 'Zambia',
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
INSERT INTO waste_categories (name, slug, description, icon, color) VALUES
('Recyclables', 'recyclables', 'Paper, cardboard, plastic bottles, aluminum cans', 'recycle', '#22c55e'),
('Electronics', 'electronics', 'Computers, phones, batteries, electronic devices', 'laptop', '#3b82f6'),
('Organic Waste - Household', 'organic-household', 'Household food scraps, yard waste, compostable materials', 'leaf', '#84cc16'),
('Organic Waste - Commercial', 'organic-commercial', 'Restaurant, hotel, hospital food waste for composting', 'utensils', '#65a30d'),
('Hazardous Materials', 'hazardous', 'Chemicals, paints, oils, toxic materials', 'warning', '#ef4444'),
('Bulky Items', 'bulky', 'Furniture, appliances, large household items', 'truck', '#6366f1');

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

-- Pricing plans table
CREATE TABLE pricing_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    plan_type ENUM('individual', 'business', 'commercial') NOT NULL,
    base_fee DECIMAL(10,2) DEFAULT 0.00,
    per_kg_rate DECIMAL(10,2) NOT NULL,
    monthly_subscription DECIMAL(10,2) DEFAULT 0.00,
    description TEXT,
    features JSON,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default pricing plans
INSERT INTO pricing_plans (name, slug, plan_type, base_fee, per_kg_rate, monthly_subscription, description) VALUES
('Pay Per Pickup - Individual', 'pay-per-pickup-individual', 'individual', 50.00, 5.00, 0.00, 'Best for occasional waste disposal needs'),
('Monthly Subscription - Small Business', 'monthly-small-business', 'business', 0.00, 3.00, 150.00, 'Unlimited pickups, reduced per-kg rate'),
('Monthly Subscription - Large Business', 'monthly-large-business', 'business', 0.00, 2.50, 500.00, 'Unlimited pickups, lowest rates, priority service'),
('Commercial Food Waste - Hospital/Restaurant', 'commercial-food-waste', 'commercial', 0.00, 1.50, 300.00, 'Specialized food waste collection for commercial entities');

-- User subscriptions table
CREATE TABLE user_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pricing_plan_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    status ENUM('active', 'cancelled', 'expired') DEFAULT 'active',
    auto_renew BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pricing_plan_id) REFERENCES pricing_plans(id)
);

-- Payments table
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pickup_request_id INT NULL,
    subscription_id INT NULL,
    payment_reference VARCHAR(100) NOT NULL UNIQUE,
    payment_method ENUM('mobile_money_mtn', 'mobile_money_airtel', 'cash', 'bank_transfer') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'ZMW',
    phone_number VARCHAR(20),
    status ENUM('pending', 'processing', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    payment_gateway_response JSON,
    transaction_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pickup_request_id) REFERENCES pickup_requests(id),
    FOREIGN KEY (subscription_id) REFERENCES user_subscriptions(id)
);

-- Worker profiles table
CREATE TABLE worker_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    worker_id_number VARCHAR(50) NOT NULL UNIQUE,
    nrc_number VARCHAR(20) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    emergency_contact VARCHAR(20),
    vehicle_type ENUM('bicycle', 'motorbike', 'tricycle', 'truck', 'van') NULL,
    vehicle_registration VARCHAR(50),
    service_areas JSON,
    rating DECIMAL(3,2) DEFAULT 0.00,
    total_pickups INT DEFAULT 0,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    joined_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Worker earnings table
CREATE TABLE worker_earnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id INT NOT NULL,
    pickup_request_id INT NOT NULL,
    base_earnings DECIMAL(10,2) NOT NULL,
    bonus DECIMAL(10,2) DEFAULT 0.00,
    total_earnings DECIMAL(10,2) NOT NULL,
    payout_status ENUM('pending', 'processing', 'paid') DEFAULT 'pending',
    payout_date DATE NULL,
    payout_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (worker_id) REFERENCES worker_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (pickup_request_id) REFERENCES pickup_requests(id)
);

-- Pickup assignments table
CREATE TABLE pickup_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pickup_request_id INT NOT NULL,
    worker_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    accepted_at TIMESTAMP NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    status ENUM('assigned', 'accepted', 'rejected', 'in_progress', 'completed', 'cancelled') DEFAULT 'assigned',
    notes TEXT,
    FOREIGN KEY (pickup_request_id) REFERENCES pickup_requests(id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES worker_profiles(id)
);

-- Food waste partnerships table
CREATE TABLE food_waste_partnerships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organization_name VARCHAR(255) NOT NULL,
    organization_type ENUM('hospital', 'restaurant', 'hotel', 'supermarket', 'school', 'other') NOT NULL,
    contact_person VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    estimated_monthly_volume DECIMAL(10,2),
    contract_start_date DATE,
    contract_end_date DATE,
    pricing_plan_id INT,
    status ENUM('inquiry', 'negotiating', 'active', 'suspended', 'terminated') DEFAULT 'inquiry',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pricing_plan_id) REFERENCES pricing_plans(id)
);

-- Compost production table
CREATE TABLE compost_production (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_number VARCHAR(50) NOT NULL UNIQUE,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    input_weight_kg DECIMAL(10,2) NOT NULL,
    output_weight_kg DECIMAL(10,2) DEFAULT 0.00,
    quality_grade ENUM('premium', 'standard', 'basic') NULL,
    ph_level DECIMAL(3,1),
    moisture_content DECIMAL(5,2),
    status ENUM('composting', 'curing', 'ready', 'sold') DEFAULT 'composting',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Compost sales table
CREATE TABLE compost_sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_type ENUM('farmer', 'nursery', 'landscaper', 'retailer', 'individual') NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255),
    quantity_kg DECIMAL(10,2) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'partial') DEFAULT 'pending',
    delivery_status ENUM('pending', 'in_transit', 'delivered') DEFAULT 'pending',
    sale_date DATE NOT NULL,
    delivery_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES compost_production(id)
);

-- Service areas table
CREATE TABLE service_areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    townships JSON,
    is_active BOOLEAN DEFAULT TRUE,
    coverage_priority ENUM('high', 'medium', 'low') DEFAULT 'medium',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Lusaka service areas for pilot
INSERT INTO service_areas (name, province, district, townships, coverage_priority) VALUES
('Kabulonga Area', 'Lusaka', 'Lusaka', '["Kabulonga", "Woodlands", "Olympia"]', 'high'),
('City Center', 'Lusaka', 'Lusaka', '["CBD", "Ridgeway", "Northmead"]', 'high'),
('Kalingalinga Area', 'Lusaka', 'Lusaka', '["Kalingalinga", "Mtendere", "Chaisa"]', 'medium');

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_pickup_requests_user_id ON pickup_requests(user_id);
CREATE INDEX idx_pickup_requests_status ON pickup_requests(status);
CREATE INDEX idx_pickup_requests_date ON pickup_requests(pickup_date);
CREATE INDEX idx_environmental_impact_user_date ON user_environmental_impact(user_id, year, month);
CREATE INDEX idx_recycling_guides_category ON recycling_guides(category);
CREATE INDEX idx_recycling_guides_featured ON recycling_guides(is_featured);
CREATE INDEX idx_payments_user_id ON payments(user_id);
CREATE INDEX idx_payments_status ON payments(status);
CREATE INDEX idx_worker_profiles_status ON worker_profiles(status);
CREATE INDEX idx_pickup_assignments_worker ON pickup_assignments(worker_id);
CREATE INDEX idx_food_partnerships_status ON food_waste_partnerships(status);
CREATE INDEX idx_compost_production_status ON compost_production(status);
CREATE INDEX idx_environmental_impact_user_date ON user_environmental_impact(user_id, year, month);
CREATE INDEX idx_recycling_guides_category ON recycling_guides(category);
CREATE INDEX idx_recycling_guides_featured ON recycling_guides(is_featured);