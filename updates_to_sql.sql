-- ========================================
-- Update Customer Table
-- ========================================

-- 1. Add customer_id primary key if it doesn't exist
ALTER TABLE Customer
ADD COLUMN IF NOT EXISTS customer_id INT AUTO_INCREMENT PRIMARY KEY FIRST;

-- 2. Ensure email is unique
ALTER TABLE Customer
ADD UNIQUE IF NOT EXISTS (email);

-- 3. Ensure created_at exists with default timestamp
ALTER TABLE Customer
MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- 4. Ensure password_hash column exists and can store hashed passwords
ALTER TABLE Customer
MODIFY COLUMN password_hash VARCHAR(255) NOT NULL;


-- ========================================
-- Update Staff Table
-- ========================================

-- 1. Add staff_id primary key if it doesn't exist
ALTER TABLE Staff
ADD COLUMN IF NOT EXISTS staff_id INT AUTO_INCREMENT PRIMARY KEY FIRST;

-- 2. Ensure email is unique
ALTER TABLE Staff
ADD UNIQUE IF NOT EXISTS (email);

-- 3. Ensure password_hash column exists and can store hashed passwords
ALTER TABLE Staff
MODIFY COLUMN password_hash VARCHAR(255) NOT NULL;

-- 4. Ensure role column exists
ALTER TABLE Staff
MODIFY COLUMN role VARCHAR(50) NOT NULL;
