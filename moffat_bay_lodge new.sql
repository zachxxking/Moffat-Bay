-- 
-- CSD460 Capstone - Red Team
-- Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
-- Instructor: Sue Sampson
-- Created October-December 2025
--

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2025 at 04:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moffat_bay_lodge`
--

-- --------------------------------------------------------

--
-- Table structure for table `Attractions`
--

CREATE TABLE `Attractions` (
  `attraction_id` int(11) NOT NULL,
  `attraction_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `distance_from_lodge` varchar(100) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Attractions`
--

INSERT INTO `Attractions` (`attraction_id`, `attraction_name`, `description`, `distance_from_lodge`, `photo_url`) VALUES
(1, 'Lake Windermere', 'Sceneic lake with ice skating, golf, & fishing', '3.1 miles', 'lake.jpg'),
(2, 'Mount Rainier', 'Hiking and climbing with a fantastic view', '6.0 miles', 'mountain.jpg'),
(3, 'Vista House at Crown Point', 'A historic building and a beautiful view', '2.3 miles', 'house.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL
);

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'Helga Blue', 'helgablue22@gmail.com', 'Hate the lodge :(', '2025-11-24 02:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone_number`, `password_hash`, `created_at`) VALUES
(1, 'Jacob', 'Achenbach', 'jacobwachenbach@gmail.com', '444-3254', 'hash1', '2025-11-22 19:35:07'),
(2, 'Ryan', 'Monnier', 'rynkd21@gmail.com', '333-5478', 'covert32', '2025-11-22 19:35:07'),
(3, 'Tabari', 'Harvey', 'tabari1993@gmail.com', '777-8567', 'kma69', '2025-11-22 19:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `Managed_Reservation`
--

CREATE TABLE `Managed_Reservation` (
  `reservation_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `assigned_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Managed_Reservation`
--

INSERT INTO `Managed_Reservation` (`reservation_id`, `staff_id`, `assigned_date`) VALUES
(1, 1, '2025-11-22 19:35:07'),
(2, 2, '2025-11-22 19:35:07'),
(3, 3, '2025-11-22 19:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `payment_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('card','paypal','cash') DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `transaction_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Payment`
--

INSERT INTO `Payment` (`payment_id`, `reservation_id`, `amount`, `payment_method`, `payment_status`, `payment_date`, `transaction_hash`) VALUES
(1, 1, 230.00, 'cash', 'completed', '2025-11-22 19:35:07', 'TX001'),
(2, 2, 460.00, 'card', 'pending', '2025-11-22 19:35:07', 'TX002'),
(3, 3, 600.00, 'paypal', 'failed', '2025-11-22 19:35:07', 'TX003');

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `reservation_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `num_guests` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Reservation`
--

INSERT INTO `Reservation` (`reservation_id`, `customer_id`, `room_id`, `check_in_date`, `check_out_date`, `num_guests`, `total_price`, `status`, `created_at`) VALUES
(1, 1, 1, '2025-07-08', '2025-07-11', 2, 230.00, 'Pending', '2025-11-16 18:40:34'),
(2, 2, 2, '2025-07-14', '2025-07-18', 4, 460.00, 'Confirmed', '2025-11-16 18:40:34'),
(3, 3, 3, '2025-11-25', '2025-11-28', 2, 600.00, 'Cancelled', '2025-11-16 18:40:34'),
(4, 8, 3, '2024-06-10', '2024-06-12', 2, 300.00, 'Confirmed', '2024-06-12 10:00:00'),
(6, 16, 8, '2024-03-23', '2026-04-05', 1, 222900.00, 'Pending', '2025-11-24 03:12:02'),
(7, 8, 1, '2026-02-02', '2026-03-03', 1, 3654.00, 'Pending', '2025-11-30 23:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type_id` int(11) DEFAULT NULL,
  `availability_status` enum('available','booked','maintenance') DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`room_id`, `room_number`, `room_type_id`, `availability_status`, `photo_url`) VALUES
(1, '101', 1, 'available', '101.jpg'),
(2, '202', 2, 'booked', '202.jpg'),
(3, '303', 3, 'maintenance', '303.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Room_type`
--

CREATE TABLE `Room_type` (
  `room_type_id` int(11) NOT NULL,
  `type_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price_per_night` decimal(10,2) DEFAULT NULL,
  `max_occupancy` int(11) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Room_type`
--

INSERT INTO `Room_type` (`room_type_id`, `type_name`, `description`, `price_per_night`, `max_occupancy`, `photo_url`) VALUES
(1, 'Double full beds', 'Room with two full-sized beds', 126.00, 4, 'doublefull.jpg'),
(2, 'Queen', 'Room with a queen-sized bed', 141.75, 2, 'queenroom.jpg'),
(3, 'Double queen beds', 'Room with two queen-sized beds', 157.50, 4, 'doublequeen.jpg'),
(4, 'King', 'Room with a king-sized bed', 168.00, 2, 'kingroom.jpg');
-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE `Staff` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` enum('Manager','Security','Chef','Maid','Maintenance') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`staff_id`, `first_name`, `last_name`, `role`, `email`, `password_hash`) VALUES
(1, 'Sarah', 'Chong', 'Manager', 'sjones@lodge.com', 'pc1'),
(2, 'Landon', 'Knight', 'Maintenance', 'lknight@lodge.com', 'pc2'),
(3, 'Annabeth', 'Jones', 'Maid', 'ajones@lodge.com', 'pc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Attractions`
--
ALTER TABLE `Attractions`
  ADD PRIMARY KEY (`attraction_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Managed_Reservation`
--
ALTER TABLE `Managed_Reservation`
  ADD PRIMARY KEY (`reservation_id`,`staff_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_number` (`room_number`),
  ADD KEY `room_type_id` (`room_type_id`);

--
-- Indexes for table `Room_type`
--
ALTER TABLE `Room_type`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Attractions`
--
ALTER TABLE `Attractions`
  MODIFY `attraction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Room_type`
--
ALTER TABLE `Room_type`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Staff`
--
ALTER TABLE `Staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Managed_Reservation`
--
ALTER TABLE `Managed_Reservation`
  ADD CONSTRAINT `managed_reservation_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `Reservation` (`reservation_id`),
  ADD CONSTRAINT `managed_reservation_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `Staff` (`staff_id`);

--
-- Constraints for table `Payment`
--
ALTER TABLE `Payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `Reservation` (`reservation_id`);

--
-- Constraints for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customer` (`customer_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `Rooms` (`room_id`);

--
-- Constraints for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `Room_type` (`room_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
