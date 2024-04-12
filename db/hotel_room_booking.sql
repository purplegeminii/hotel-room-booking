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
    `Img_Src` VARCHAR(255),
    PRIMARY KEY (`RoomType_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `RoomTypes`
INSERT INTO `RoomTypes` (`Room_Type`, `Occupancy`, `Price_Per_Night`, `Img_Src`) VALUES
('Single', 1, 50.00, '../assets/images/Single.jpeg'),
('Double', 2, 70.00, '../assets/images/Double.jpeg'),
('Suite', 4, 120.00, '../assets/images/Suite.jpeg');

-- Table structure for table `Rooms`
CREATE TABLE `Rooms` (
    `Room_ID` int(11) NOT NULL AUTO_INCREMENT,
    `RoomType_ID` int(11) NOT NULL,
    `Availability` enum('0', '1') NOT NULL,
    PRIMARY KEY (`Room_ID`),
    CONSTRAINT `Rooms_ibfk_1` FOREIGN KEY (`RoomType_ID`) REFERENCES `RoomTypes` (`RoomType_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `Rooms`
INSERT INTO `Rooms` (`RoomType_ID`, `Availability`) VALUES
(1, '1'),   -- Single
(1, '1'),   -- Single
(1, '1'),   -- Single
(1, '1'),   -- Single
(1, '1'),   -- Single
(1, '1'),   -- Single
(1, '1'),   -- Single
(2, '1'),   -- Double
(2, '1'),   -- Double
(2, '1'),   -- Double
(2, '1'),   -- Double
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1'),   -- Suite
(3, '1');   -- Suite

-- Table structure for table `Bookings`
CREATE TABLE `Bookings` (
    `Booking_ID` int(11) NOT NULL AUTO_INCREMENT,
    `User_ID` int(11) NOT NULL,
    `RoomType_ID` int(11) NOT NULL,
    `Check_In_Date` datetime NOT NULL,
    `Check_Out_Date` datetime,
    `Qty` int(11) NOT NULL,
    `Total_Price` decimal(10,2) NOT NULL,
    PRIMARY KEY (`Booking_ID`),
    CONSTRAINT `Bookings_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `Bookings_ibfk_2` FOREIGN KEY (`RoomType_ID`) REFERENCES `RoomTypes` (`RoomType_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `Bookings`
INSERT INTO `Bookings` (`User_ID`, `RoomType_ID`, `Check_In_Date`, `Check_Out_Date`, `Qty`, `Total_Price`)
VALUES
    (1, 1, '2024-03-01 11:00:00', '2024-03-05 12:00:00', 1, 120.00),
    (1, 1, '2024-03-02 08:00:00', '2024-03-06 12:00:00', 1, 150.00),
    (1, 1, '2024-03-03 09:00:00', '2024-03-07 12:00:00', 1, 110.00),
    (1, 1, '2024-03-04 10:00:00', '2024-03-08 12:00:00', 1, 140.00),
    (1, 1, '2024-03-05 08:00:00', '2024-03-09 12:00:00', 1, 170.00),
    (1, 1, '2024-03-06 12:00:00', '2024-03-10 12:00:00', 1, 130.00),
    (1, 1, '2024-03-07 11:00:00', '2024-03-11 12:00:00', 1, 160.00),
    (1, 1, '2024-03-08 08:00:00', '2024-03-12 12:00:00', 1, 190.00),
    (1, 1, '2024-03-09 09:00:00', '2024-03-13 12:00:00', 1, 100.00),
    (1, 1, '2024-03-10 10:00:00', '2024-03-14 12:00:00', 1, 180.00),
    (2, 2, '2024-04-01 10:00:00', '2024-04-06 11:00:00', 2, 420.00),
    (2, 2, '2024-04-02 14:00:00', '2024-04-07 10:00:00', 2, 460.00),
    (2, 2, '2024-04-03 15:00:00', '2024-04-08 10:00:00', 2, 430.00),
    (2, 2, '2024-04-04 14:00:00', '2024-04-09 11:00:00', 2, 470.00),
    (2, 2, '2024-04-05 16:00:00', '2024-04-10 10:00:00', 2, 400.00),
    (2, 2, '2024-04-06 12:00:00', '2024-04-11 10:00:00', 2, 490.00),
    (2, 2, '2024-04-07 13:00:00', '2024-04-12 10:00:00', 2, 440.00),
    (2, 2, '2024-04-08 14:00:00', '2024-04-13 11:00:00', 2, 520.00),
    (2, 2, '2024-04-09 15:00:00', '2024-04-14 10:00:00', 2, 480.00),
    (2, 2, '2024-04-10 16:00:00', '2024-04-15 10:00:00', 2, 570.00),
    (2, 3, '2024-04-01 11:00:00', '2024-04-08 12:00:00', 1, 840.00),
    (2, 3, '2024-04-02 13:00:00', '2024-04-09 12:00:00', 1, 870.00),
    (2, 3, '2024-04-03 12:00:00', '2024-04-10 12:00:00', 1, 880.00),
    (2, 3, '2024-04-04 09:00:00', '2024-04-11 12:00:00', 1, 810.00),
    (2, 3, '2024-04-05 10:00:00', '2024-04-12 12:00:00', 1, 930.00),
    (2, 3, '2024-04-06 11:00:00', '2024-04-13 12:00:00', 1, 820.00),
    (2, 3, '2024-04-07 12:00:00', '2024-04-14 12:00:00', 1, 940.00),
    (2, 3, '2024-04-08 13:00:00', '2024-04-15 12:00:00', 1, 850.00),
    (2, 3, '2024-04-09 14:00:00', '2024-04-16 12:00:00', 1, 960.00),
    (2, 3, '2024-04-10 15:00:00', '2024-04-17 12:00:00', 1, 870.00);




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
