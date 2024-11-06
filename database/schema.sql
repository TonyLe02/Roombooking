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
('Single Room', 'Small, cozy room with a single bed.', 1, 0),
('Double Room', 'Medium cozy room with a double bed.', 2, 1),
('Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2);

-- Create the rooms table
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE,
    type_id INT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    max_adults INT NOT NULL,
    max_children INT NOT NULL,
    available BOOLEAN DEFAULT TRUE,
    floor INT,
    proximity_to_elevator BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES room_types(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Insert rooms
INSERT INTO rooms (room_number, type_id, name, description, max_adults, max_children, available, floor, proximity_to_elevator) VALUES
('101', 1, 'Single Room', 'Small, cozy room with a single bed.', 1, 0, TRUE, 1, FALSE),
('102', 1, 'Single Room', 'Small, cozy room with a single bed.', 1, 0, TRUE, 1, TRUE),
('103', 1, 'Single Room', 'Small, cozy room with a single bed.', 1, 0, TRUE, 1, TRUE),
('104', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 1, FALSE),
('105', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 1, TRUE),
('106', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 1, FALSE),
('107', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 1, TRUE),
('108', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 1, FALSE),
('109', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 1, TRUE),
('110', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 1, FALSE),
('201', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 2, FALSE),
('202', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 2, TRUE),
('203', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 2, TRUE),
('204', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 2, FALSE),
('205', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, TRUE),
('206', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, FALSE),
('207', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, TRUE),
('208', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, FALSE),
('209', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, TRUE),
('210', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, FALSE),
('211', 1, 'Single Room', 'Small, cozy room with a single bed.', 1, 0, TRUE, 2, TRUE),
('212', 1, 'Single Room', 'Small, cozy room with a single bed.', 1, 0, TRUE, 2, FALSE),
('213', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, TRUE),
('214', 2, 'Double Room', 'Medium cozy room with a double bed.', 2, 1, TRUE, 2, FALSE),
('215', 3, 'Junior Suite', 'Spacious room with a double bed and a living area.', 2, 2, TRUE, 2, TRUE);

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
