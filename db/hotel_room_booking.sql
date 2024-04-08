DROP DATABASE IF EXISTS hotel_room_booking;
CREATE DATABASE hotel_room_booking;
USE hotel_room_booking;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `Role`
CREATE TABLE `Role` (
    `rid` int(11) NOT NULL AUTO_INCREMENT,
    `rolename` varchar(50) NOT NULL,
    PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `Role`
INSERT INTO `Role` (`rid`, `rolename`) VALUES
(1, 'superadmin'),
(2, 'admin'),
(3, 'standard');

-- Table structure for table `Users`
CREATE TABLE `Users` (
    `User_ID` int(11) NOT NULL AUTO_INCREMENT,
    `fname` varchar(50),
    `lname` varchar(50),
    `gender` enum('Male','Female') NOT NULL,
    `dob` date NOT NULL,
    `email` varchar(255) UNIQUE NOT NULL,
    `passwd` varchar(255) NOT NULL,
    `tel` varchar(20) NOT NULL,
    `address` varchar(255) NOT NULL,
    `rid` int(11) NOT NULL,
    PRIMARY KEY (`User_ID`),
    CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `Role` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `Users`
INSERT INTO `Users` (fname, lname, gender, dob, email, passwd, tel, address, rid)
VALUES
    ('John', 'Mensah', 'Male', '1970-08-20', 'kfcadmin126@gmail.com', '$2y$10$6fnTRb.sjgJr8QB/bwRK2.jdRnpzx4n6wRZBBnMgTbDjGkjTeDily', '+233-59-444-4444', 'Accra', 2),
    ('Kwaku', 'Afif', 'Male', '2000-01-31', 'kwakuafif@gmail.com', '$2y$10$6fnTRb.sjgJr8QB/bwRK2.jdRnpzx4n6wRZBBnMgTbDjGkjTeDily', '+233-59-666-6666', 'Accra', 3);

-- Table structure for table `RoomTypes`
CREATE TABLE `RoomTypes` (
    `RoomType_ID` int(11) NOT NULL AUTO_INCREMENT,
    `Room_Type` varchar(50) NOT NULL,
    `Occupancy` int(11) NOT NULL,
    `Price_Per_Night` decimal(10,2) NOT NULL,
    PRIMARY KEY (`RoomType_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `RoomTypes`
INSERT INTO `RoomTypes` (`Room_Type`, `Occupancy`, `Price_Per_Night`) VALUES
('Single', 1, 50.00),
('Double', 2, 70.00),
('Suite', 4, 120.00);

-- Table structure for table `Rooms`
CREATE TABLE `Rooms` (
    `Room_ID` int(11) NOT NULL AUTO_INCREMENT,
    `RoomType_ID` int(11) NOT NULL,
    `Availability` enum('0', '1') NOT NULL,
    PRIMARY KEY (`Room_ID`),
    CONSTRAINT `Rooms_ibfk_1` FOREIGN KEY (`RoomType_ID`) REFERENCES `RoomTypes` (`RoomType_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `Bookings`
CREATE TABLE `Bookings` (
    `Booking_ID` int(11) NOT NULL AUTO_INCREMENT,
    `User_ID` int(11) NOT NULL,
    `Room_ID` int(11) NOT NULL,
    `Check_In_Date` date NOT NULL,
    `Check_Out_Date` date NOT NULL,
    `Total_Price` decimal(10,2) NOT NULL,
    PRIMARY KEY (`Booking_ID`),
    CONSTRAINT `Bookings_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `Bookings_ibfk_2` FOREIGN KEY (`Room_ID`) REFERENCES `Rooms` (`Room_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `Payments`
CREATE TABLE `Payments` (
    `Payment_ID` int(11) NOT NULL AUTO_INCREMENT,
    `Booking_ID` int(11) NOT NULL,
    `Amount` decimal(10,2) NOT NULL,
    `Payment_Date_Time` datetime NOT NULL,
    `Payment_Method` varchar(50) NOT NULL,
    `Transaction_ID` varchar(255) NOT NULL,
    PRIMARY KEY (`Payment_ID`),
    KEY `Booking_ID` (`Booking_ID`),
    CONSTRAINT `Payments_ibfk_1` FOREIGN KEY (`Booking_ID`) REFERENCES `Bookings` (`Booking_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
