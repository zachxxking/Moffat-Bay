CREATE DATABASE IF NOT EXISTS moffat_bay_lodge;
USE moffat_bay_lodge;

CREATE TABLE IF NOT EXISTS Guests (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20)
);

CREATE TABLE Rooms (
	room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) UNIQUE NOT NULL, 
    type VARCHAR(10),
    price DECIMAL(10,2) NOT NULL
);



