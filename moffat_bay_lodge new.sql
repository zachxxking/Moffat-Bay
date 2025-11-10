DROP DATABASE IF EXISTS moffat_bay_lodge;
CREATE DATABASE IF NOT EXISTS moffat_bay_lodge;
USE moffat_bay_lodge;


CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    phone_number VARCHAR(20),
    password_hash VARCHAR(255),
    created_at DATETIME
);

CREATE TABLE Rooms (
	room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) UNIQUE NOT NULL,
    room_type_id INT,
    availability_status ENUM('available','booked','maintenance'),
    photo_url VARCHAR(255),
    FOREIGN KEY (room_type_id) REFERENCES Room_type(room_type_id)
);

CREATE TABLE Room_type (
	room_type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(50),
    description TEXT,
    price_per_night DECIMAL(10,2),
    max_occupancy INT, 
    photo_url VARCHAR(255)
); 

CREATE TABLE Reservation (
	reservation_id INT AUTO_INCREMENT PRIMARY KEY, 
    customer_id INT, 
    room_id INT, 
    check_in_date DATE,
    check_out_date DATE, 
    num_guests INT, 
    total_price DECIMAL(10,2),
    status ENUM('Pending','Confirmed','Cancelled'),
    created_at DATETIME,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (room_id) REFERENCES Rooms(room_id)
);

CREATE TABLE Payment (
	payment_id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    amount DECIMAL(10,2),
    payment_method ENUM('card','paypal','cash'),
    payment_status ENUM('pending','completed','failed'),
    payment_date DATETIME,
    transaction_hash VARCHAR(255),
    FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id)
);	

CREATE TABLE Staff (
	staff_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    role ENUM ('Manager','Security','Chef','Maid','Maintenance'),
    email VARCHAR(100) UNIQUE,
    password_hash VARCHAR(255)
);

CREATE TABLE Managed_Reservation (
	reservation_id INT,
    staff_id INT,
    assigned_date DATETIME,
    PRIMARY KEY (reservation_id, staff_id),
    FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id),
    FOREIGN KEY (staff_id) REFERENCES Staff(staff_id)
);

CREATE TABLE Attractions (
	attraction_id INT AUTO_INCREMENT PRIMARY KEY,
    attraction_name VARCHAR(100),
    description TEXT,
    distance_from_lodge VARCHAR(100),
    photo_url VARCHAR(255)
);


INSERT INTO Customer (first_name, last_name, email, phone_number, password_hash, created_at) VALUES
('Jacob', 'Achenbach', 'jacobwachenbach@gmail.com', '444-3254', 'hash1', NOW()),
('Ryan', 'Monnier', 'rynkd21@gmail.com', '333-5478', 'covert32', NOW()),
('Tabari', 'Harvey', 'tabari1993@gmail.com', '777-8567', 'kma69', NOW());

INSERT INTO Room_Type (type_name, description, price_per_night, max_occupancy, photo_url) VALUES
('Family room', 'Room with two queen-sized bed', '115.00', 4, 'faimilyroom.jpg'),
('Queen room', 'Room with a queen-sized bed', '115.00', 2,'queenroom.jpg'),
('King room', 'Room with a king-sized bed & living space','300.00', 1, 'kingroom.jpg');

INSERT INTO Rooms (room_number, room_type_id, availability_status, photo_url) VALUES
('101', 1, 'available', '101.jpg'),
('202', 2, 'booked', '202.jpg'),
('303', 3, 'maintenance', '303.jpg');

INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, num_guests, total_price, status, created_at) VALUES
(1, 1, '2025-07-08', '2025-07-11', 2, 230.00, 'Pending', NOW()),
(2, 2, '2025-07-14', '2025-07-18', 4, 460.00, 'Confirmed', NOW()),
(3, 3, '2025-11-25', '2025-11-28', 2, 600.00, 'Cancelled', NOW());

INSERT INTO Payment (reservation_id, amount, payment_method, payment_status, payment_date, transaction_hash) VALUES
(1, 230.00, 'cash', 'completed', NOW(), 'TX001'),
(2, 460.00, 'card', 'pending', NOW(), 'TX002'),
(3, 600.00, 'paypal', 'failed', NOW(), 'TX003');

INSERT INTO Staff (first_name, last_name, role, email, password_hash) VALUES
('Sarah', 'Chong', 'Manager', 'sjones@lodge.com', 'pc1'),
('Landon', 'Knight', 'Maintenance', 'lknight@lodge.com', 'pc2'),
('Annabeth', 'Jones', 'Maid', 'ajones@lodge.com', 'pc3');

INSERT INTO Managed_Reservation (reservation_id, staff_id, assigned_date) VALUES
(1, 1, NOW()),
(2, 2, NOW()),
(3, 3, NOW());

INSERT INTO Attractions (attraction_name, description, distance_from_lodge, photo_url) VALUES
('Lake Windermere', 'Sceneic lake with ice skating, golf, & fishing', '3.1 miles', 'lake.jpg'),
('Mount Rainier', 'Hiking and climbing with a fantastic view', '6.0 miles', 'mountain.jpg'),
('Vista House at Crown Point', 'A historic building and a beautiful view', '2.3 miles', 'house.jpg');

SELECT * FROM Customer;
SELECT * FROM Room_Type;
SELECT * FROM Rooms;
SELECT * FROM Reservation;
SELECT * FROM Payment;
SELECT * FROM Staff;
SELECT * FROM Managed_Reservation;
SELECT * FROM Attractions; 
    
    


