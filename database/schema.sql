-- Drop the database if it exists
DROP DATABASE IF EXISTS roombooking;

-- Create the database
CREATE DATABASE roombooking CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Use the database
USE roombooking;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('guest', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Create the room_types table
CREATE TABLE room_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    max_adults INT NOT NULL,
    max_children INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Insert room types
INSERT INTO room_types (name, description, max_adults, max_children) VALUES
('Single Room', 'Liten, koselig rom med en enkeltseng.', 1, 0),
('Double Room', 'Rom med en dobbeltseng for par.', 2, 1),
('Junior Suite', 'Romslig rom med en dobbeltseng og stue.', 2, 2);

-- Create the rooms table
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE,
    type_id INT,
    available BOOLEAN DEFAULT TRUE,
    floor INT,
    proximity_to_elevator BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (type_id) REFERENCES room_types(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO rooms (room_number, type_id, available, floor, proximity_to_elevator) VALUES
('101', 1, TRUE, 1, FALSE),  -- Room 101, Type 1, Available, Floor 1, Not near elevator
('102', 1, TRUE, 1, TRUE),   -- Room 102, Type 1, Available, Floor 1, Near elevator
('103', 1, TRUE, 1, TRUE),   -- Room 103, Type 1, Available, Floor 1, Near elevator
('104', 2, TRUE, 1, FALSE),  -- Room 104, Type 2, Available, Floor 1, Not near elevator
('105', 2, TRUE, 1, TRUE),   -- Room 105, Type 2, Available, Floor 1, Near elevator
('106', 2, TRUE, 1, FALSE),  -- Room 106, Type 2, Available, Floor 1, Not near elevator
('107', 3, TRUE, 1, TRUE),   -- Room 107, Type 3, Available, Floor 1, Near elevator
('108', 3, TRUE, 1, FALSE),  -- Room 108, Type 3, Available, Floor 1, Not near elevator
('109', 3, TRUE, 1, TRUE),   -- Room 109, Type 3, Available, Floor 1, Near elevator
('110', 3, TRUE, 1, FALSE),  -- Room 110, Type 3, Available, Floor 1, Not near elevator
('201', 3, TRUE, 2, FALSE),  -- Room 201, Type 3, Available, Floor 2, Not near elevator
('202', 3, TRUE, 2, TRUE),   -- Room 202, Type 3, Available, Floor 2, Near elevator
('203', 3, TRUE, 2, TRUE),   -- Room 203, Type 3, Available, Floor 2, Near elevator
('204', 3, TRUE, 2, FALSE),  -- Room 204, Type 3, Available, Floor 2, Not near elevator
('205', 2, TRUE, 2, TRUE),   -- Room 205, Type 2, Available, Floor 2, Near elevator
('206', 2, TRUE, 2, FALSE),  -- Room 206, Type 2, Available, Floor 2, Not near elevator
('207', 2, TRUE, 2, TRUE),   -- Room 207, Type 2, Available, Floor 2, Near elevator
('208', 2, TRUE, 2, FALSE),  -- Room 208, Type 2, Available, Floor 2, Not near elevator
('209', 2, TRUE, 2, TRUE),   -- Room 209, Type 2, Available, Floor 2, Near elevator
('210', 2, TRUE, 2, FALSE),  -- Room 210, Type 2, Available, Floor 2, Not near elevator
('211', 1, TRUE, 2, TRUE),    -- Room 211, Type 1, Available, Floor 2, Near elevator
('212', 1, TRUE, 2, FALSE),   -- Room 212, Type 1, Available, Floor 2, Not near elevator
('213', 2, TRUE, 2, TRUE),    -- Room 213, Type 2, Available, Floor 2, Near elevator
('214', 2, TRUE, 2, FALSE),   -- Room 214, Type 2, Available, Floor 2, Not near elevator
('215', 3, TRUE, 2, TRUE);    -- Room 215, Type 3, Available, Floor 2, Near elevator


-- Create the bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    room_id INT,
    check_in DATE,
    check_out DATE,
    adults INT NOT NULL,
    children INT NOT NULL,
    status ENUM('confirmed', 'canceled') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Create the preferences table
CREATE TABLE preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    preference_type VARCHAR(50),
    preference_value VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Create the loyalty_program table
CREATE TABLE loyalty_program (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    points INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Create the unavailable_rooms table
CREATE TABLE unavailable_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    unavailable_start DATE,
    unavailable_end DATE,
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


