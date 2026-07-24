-- =====================================
-- Coastal Blue Customer Credit Management System (CCMS)
-- Database: ccms
-- =====================================

DROP DATABASE IF EXISTS ccms;
CREATE DATABASE ccms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ccms;

-- =====================================
-- USERS TABLE
-- Stores both Admin and Customer Accounts
-- =====================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id VARCHAR(20) UNIQUE NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================
-- CUSTOMER BALANCES
-- Stores current balance summary
-- =====================================

CREATE TABLE customer_balances (
    customer_id INT PRIMARY KEY,
    total_credit DECIMAL(12,2) DEFAULT 0.00,
    total_payments DECIMAL(12,2) DEFAULT 0.00,
    current_balance DECIMAL(12,2) DEFAULT 0.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_balance_customer
    FOREIGN KEY (customer_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

-- =====================================
-- TRANSACTIONS TABLE
-- Stores all credit sales and payments
-- =====================================

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_id INT NOT NULL,

    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,

    description VARCHAR(255) NOT NULL,

    amount DECIMAL(12,2) NOT NULL,

    transaction_type ENUM('credit','payment') NOT NULL,

    balance_after DECIMAL(12,2) NOT NULL,

    created_by INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_transaction_customer
    FOREIGN KEY (customer_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_transaction_admin
    FOREIGN KEY (created_by)
    REFERENCES users(id)
    ON DELETE RESTRICT
);

-- =====================================
-- PASSWORD RESETS
-- Optional password reset support
-- =====================================

CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reset_token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,

    CONSTRAINT fk_reset_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

-- =====================================
-- LOGIN LOGS
-- Track login activity
-- =====================================

CREATE TABLE login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),

    CONSTRAINT fk_login_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

-- =====================================
-- REPORT VIEW
-- Customer Outstanding Balances
-- =====================================

CREATE VIEW vw_outstanding_balances AS
SELECT
    u.id,
    u.customer_id,
    u.full_name,
    u.phone,
    cb.total_credit,
    cb.total_payments,
    cb.current_balance
FROM users u
JOIN customer_balances cb
ON u.id = cb.customer_id
WHERE u.role = 'customer';

-- =====================================
-- REPORT VIEW
-- Customer Statements
-- =====================================

CREATE VIEW vw_customer_statement AS
SELECT
    t.id,
    u.customer_id,
    u.full_name,
    t.transaction_date,
    t.description,
    t.amount,
    t.transaction_type,
    t.balance_after
FROM transactions t
JOIN users u
ON t.customer_id = u.id;

-- =====================================
-- DEFAULT ADMIN ACCOUNT
-- Username: admin
-- Password: Admin@123
-- Replace hash after deployment
-- =====================================

INSERT INTO users (
    customer_id,
    full_name,
    phone,
    address,
    username,
    password_hash,
    role
)
VALUES (
    NULL,
    'System Administrator',
    '',
    '',
    'admin',
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy',
    'admin'
);

-- =====================================
-- SAMPLE CUSTOMER
-- =====================================

INSERT INTO users (
    customer_id,
    full_name,
    phone,
    address,
    username,
    password_hash,
    role
)
VALUES (
    'CUS001',
    'Demo Customer',
    '7000000',
    'Maldives',
    'customer1',
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy',
    'customer'
);

-- Create initial balance record

INSERT INTO customer_balances (
    customer_id,
    total_credit,
    total_payments,
    current_balance
)
VALUES (
    2,
    0.00,
    0.00,
    0.00
);
