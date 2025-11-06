CREATE DATABASE IF NOT EXISTS moffat_bay_lodge;
USE moffat_bay_lodge;

CREATE TABLE IF NOT EXISTS Customers (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    password_has VARCHAR(255),
    created_at DATETIME
);

CREATE TABLE IF NOT EXISTS Rooms (
	room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS room_type (
	room_type VARCHAR(50), 
    price_per_night DECIMAL(5,2),
    max_guests INT, 
    description TEXT
); 

CREATE TABLE IF NOT EXISTS Reservations (
	reservation_id INT PRIMARY KEY, 
    customer_id INT, 
    room_id INT, 
    check_in_date DATE,
    check_out_date DATE, 
    num_guests INT, 
    total_price DECIMAL(10,2),
    status ENUM('Pending','Confirmed','Cancelled'),
    created_at DATETIME,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (room_id) REFERENCES Rooms(room_id)
);
	



 



