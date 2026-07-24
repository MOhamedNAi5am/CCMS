-- ==========================================
-- Coastal Blue Customer Credit Management System
-- Database: ccms
-- ==========================================


CREATE DATABASE IF NOT EXISTS ccms;

USE ccms;



-- ==========================================
-- Admin Table
-- ==========================================

CREATE TABLE admins (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);




-- Default Admin
-- Username: admin
-- Password hash should be generated using PHP password_hash()

INSERT INTO admins

(
name,
username,
password
)

VALUES

(
'System Administrator',
'admin',
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llM4L1s5N9z9JwX6gQqvK'
);





-- ==========================================
-- Customer Table
-- ==========================================


CREATE TABLE customers (

    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_code VARCHAR(50) UNIQUE NOT NULL,

    name VARCHAR(100) NOT NULL,

    phone VARCHAR(30),

    email VARCHAR(100),

    address TEXT,

    credit_limit DECIMAL(10,2) DEFAULT 0,

    password VARCHAR(255) NOT NULL,

    status ENUM('active','inactive') DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);






-- ==========================================
-- Credit Transactions Table
-- ==========================================


CREATE TABLE credit_transactions (

    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_id INT NOT NULL,

    type ENUM('credit','payment') NOT NULL,

    amount DECIMAL(10,2) NOT NULL,

    description TEXT,

    transaction_date DATE NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    FOREIGN KEY(customer_id)

    REFERENCES customers(id)

    ON DELETE CASCADE

);







-- ==========================================
-- Business Settings
-- ==========================================


CREATE TABLE settings (

    id INT AUTO_INCREMENT PRIMARY KEY,

    business_name VARCHAR(150),

    phone VARCHAR(30),

    email VARCHAR(100),

    address TEXT

);





INSERT INTO settings

(
business_name,
phone,
email,
address
)

VALUES

(
'Coastal Blue',
'+9600000000',
'info@coastalblue.com',
'Maldives'
);







-- ==========================================
-- Sample Customer
-- ==========================================


INSERT INTO customers

(
customer_code,
name,
phone,
email,
address,
credit_limit,
password,
status
)

VALUES

(
'CUS10001',
'Ahmed Ali',
'7777777',
'ahmed@email.com',
'Maldives',
5000.00,

'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llM4L1s5N9z9JwX6gQqvK',

'active'

);







-- ==========================================
-- Sample Transactions
-- ==========================================


INSERT INTO credit_transactions

(
customer_id,
type,
amount,
description,
transaction_date
)

VALUES


(
1,
'credit',
2500.00,
'Grocery purchase',
CURDATE()
),


(
1,
'payment',
1000.00,
'Cash payment',
CURDATE()
);





-- ==========================================
-- Indexes
-- ==========================================


CREATE INDEX customer_search

ON customers(name,phone);



CREATE INDEX transaction_search

ON credit_transactions(customer_id,type);




-- ==========================================
-- End of CCMS Database
-- ==========================================
