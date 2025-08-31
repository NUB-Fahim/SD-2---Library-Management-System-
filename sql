-- Create and use the database
CREATE DATABASE IF NOT EXISTS nub_library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE nub_library_db;

-- Table: users
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) DEFAULT NULL,
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255) DEFAULT NULL,
  role ENUM('user','admin') DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: books
CREATE TABLE books (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(150) NOT NULL,
  department VARCHAR(100) DEFAULT NULL,
  isbn VARCHAR(50) UNIQUE,
  available INT(11) DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: borrowed_books
CREATE TABLE borrowed_books (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) NOT NULL,
  book_id INT(11) NOT NULL,
  borrow_date DATE DEFAULT CURDATE(),
  return_date DATE DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for users
INSERT INTO users (id, full_name, email, password, role, created_at) VALUES
(1, 'Admin', 'admin@nub.edu.bd', '$2y$10$tdE/mZNe6dY9zopFpMhIxuaoXIzhtL8KbBDAAedR2ciSdc9ALDZLK', 'admin', '2025-08-20 13:52:33'),
(2, 'Fahim', 'fahim@gmail.com', '$2y$10$tdE/mZNe6dY9zopFpMhIxuaoXIzhtL8KbBDAAedR2ciSdc9ALDZLK', 'user', '2025-08-20 14:56:32'),
(4, 'Urmi', 'urmi@gmail.com', '$2y$10$tdE/mZNe6dY9zopFpMhIxuaoXIzhtL8KbBDAAedR2ciSdc9ALDZLK', 'user', '2025-08-20 14:56:32'),
(15, NULL, 'fahimjaman@gmail.com', '$2y$10$C7P.5Er5liHo/CAGk8VZv.rsFHxexf3QqXJnRqRFI1Sw6Dz0iFCZm', 'admin', '2025-08-30 16:03:05'),
(17, NULL, 'asm@gmail.com', '$2y$10$nmKrIAIQDgtC2KcLCKITUO1XBEIYcXzGCqqOSctQQ2kmAYoZpLWQK', 'admin', '2025-08-30 16:04:42'),
(18, NULL, 'chhanda@gmail.com', '$2y$10$EAzs8.eLqHN9FyArZadrv.iIc65HEf.Jh/S5Uc1VVdsnXoc9Oce9a', 'user', '2025-08-30 16:38:29'),
(19, NULL, 'rasel@gmail.com', '$2y$10$THqOfFlwcl5K05zOiFBJk.av0cFYNHEwmsf9Ug1YyT20PfYZEQuJC', 'admin', '2025-08-31 05:55:36'),
(21, NULL, 'rase1l@gmail.com', '$2y$10$VA3oZpksXxLIBnegjEqwf.eduHC/ry46nGC1chFVhwsvLvtRVCROS', 'admin', '2025-08-31 05:57:24');

-- Sample data for books
INSERT INTO books (id, title, author, department, isbn, available, created_at) VALUES
(1, 'Business 101', 'Author A', 'Business', 'BUS001', 1, '2025-08-20 15:07:09'),
(2, 'Marketing Basics', 'Author B', 'Business', 'BUS002', 1, '2025-08-20 15:07:09'),
(3, 'Finance Principles', 'Author C', 'Business', 'BUS003', 1, '2025-08-20 15:07:09'),
(4, 'Entrepreneurship Guide', 'Author D', 'Business', 'BUS004', 1, '2025-08-20 15:07:09'),
(5, 'Corporate Strategy', 'Author E', 'Business', 'BUS005', 1, '2025-08-20 15:07:09'),
(6, 'Human Anatomy', 'Author F', 'Health Science', 'HEA001', 1, '2025-08-20 15:07:09'),
(7, 'Nutrition Essentials', 'Author G', 'Health Science', 'HEA002', 1, '2025-08-20 15:07:09'),
(8, 'Public Health Basics', 'Author H', 'Health Science', 'HEA003', 1, '2025-08-20 15:07:09'),
(9, 'Medical Ethics', 'Author I', 'Health Science', 'HEA004', 1, '2025-08-20 15:07:09'),
(10, 'Pharmacology 101', 'Author J', 'Health Science', 'HEA005', 1, '2025-08-20 15:07:09'),
(11, 'Sociology Intro', 'Author K', 'Humanities & Social Science', 'HSS001', 1, '2025-08-20 15:07:09'),
(12, 'Philosophy Basics', 'Author L', 'Humanities & Social Science', 'HSS002', 1, '2025-08-20 15:07:09'),
(13, 'History of Art', 'Author M', 'Humanities & Social Science', 'HSS003', 1, '2025-08-20 15:07:09'),
(14, 'Psychology 101', 'Author N', 'Humanities & Social Science', 'HSS004', 1, '2025-08-20 15:07:09'),
(15, 'Cultural Studies', 'Author O', 'Humanities & Social Science', 'HSS005', 1, '2025-08-20 15:07:09'),
(16, 'Constitutional Law', 'Author P', 'Law', 'LAW001', 1, '2025-08-20 15:07:09'),
(17, 'Criminal Law', 'Author Q', 'Law', 'LAW002', 1, '2025-08-20 15:07:09'),
(18, 'Civil Procedure', 'Author R', 'Law', 'LAW003', 1, '2025-08-20 15:07:09'),
(19, 'International Law', 'Author S', 'Law', 'LAW004', 1, '2025-08-20 15:07:09'),
(20, 'Legal Ethics', 'Author T', 'Law', 'LAW005', 1, '2025-08-20 15:07:09'),
(21, 'Physics Fundamentals', 'Author U', 'Science & Engineering', 'SCI001', 1, '2025-08-20 15:07:09'),
(22, 'Chemistry Basics', 'Author V', 'Science & Engineering', 'SCI002', 1, '2025-08-20 15:07:09'),
(23, 'Biology Essentials', 'Author W', 'Science & Engineering', 'SCI003', 1, '2025-08-20 15:07:09'),
(24, 'Mechanical Engineering', 'Author X', 'Science & Engineering', 'SCI004', 1, '2025-08-20 15:07:09'),
(25, 'Electrical Engineering', 'Author Y', 'Science & Engineering', 'SCI005', 1, '2025-08-20 15:07:09');-- Create and use the database
CREATE DATABASE IF NOT EXISTS nub_library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE nub_library_db;

-- Table: users
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) DEFAULT NULL,
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255) DEFAULT NULL,
  role ENUM('user','admin') DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: books
CREATE TABLE books (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(150) NOT NULL,
  department VARCHAR(100) DEFAULT NULL,
  isbn VARCHAR(50) UNIQUE,
  available INT(11) DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: borrowed_books
CREATE TABLE borrowed_books (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) NOT NULL,
  book_id INT(11) NOT NULL,
  borrow_date DATE DEFAULT CURDATE(),
  return_date DATE DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for users
INSERT INTO users (id, full_name, email, password, role, created_at) VALUES
(1, 'Admin', 'admin@nub.edu.bd', '$2y$10$tdE/mZNe6dY9zopFpMhIxuaoXIzhtL8KbBDAAedR2ciSdc9ALDZLK', 'admin', '2025-08-20 13:52:33'),
(2, 'Fahim', 'fahim@gmail.com', '$2y$10$tdE/mZNe6dY9zopFpMhIxuaoXIzhtL8KbBDAAedR2ciSdc9ALDZLK', 'user', '2025-08-20 14:56:32'),
(4, 'Urmi', 'urmi@gmail.com', '$2y$10$tdE/mZNe6dY9zopFpMhIxuaoXIzhtL8KbBDAAedR2ciSdc9ALDZLK', 'user', '2025-08-20 14:56:32'),
(15, NULL, 'fahimjaman@gmail.com', '$2y$10$C7P.5Er5liHo/CAGk8VZv.rsFHxexf3QqXJnRqRFI1Sw6Dz0iFCZm', 'admin', '2025-08-30 16:03:05'),
(17, NULL, 'asm@gmail.com', '$2y$10$nmKrIAIQDgtC2KcLCKITUO1XBEIYcXzGCqqOSctQQ2kmAYoZpLWQK', 'admin', '2025-08-30 16:04:42'),
(18, NULL, 'chhanda@gmail.com', '$2y$10$EAzs8.eLqHN9FyArZadrv.iIc65HEf.Jh/S5Uc1VVdsnXoc9Oce9a', 'user', '2025-08-30 16:38:29'),
(19, NULL, 'rasel@gmail.com', '$2y$10$THqOfFlwcl5K05zOiFBJk.av0cFYNHEwmsf9Ug1YyT20PfYZEQuJC', 'admin', '2025-08-31 05:55:36'),
(21, NULL, 'rase1l@gmail.com', '$2y$10$VA3oZpksXxLIBnegjEqwf.eduHC/ry46nGC1chFVhwsvLvtRVCROS', 'admin', '2025-08-31 05:57:24');

-- Sample data for books
INSERT INTO books (id, title, author, department, isbn, available, created_at) VALUES
(1, 'Business 101', 'Author A', 'Business', 'BUS001', 1, '2025-08-20 15:07:09'),
(2, 'Marketing Basics', 'Author B', 'Business', 'BUS002', 1, '2025-08-20 15:07:09'),
(3, 'Finance Principles', 'Author C', 'Business', 'BUS003', 1, '2025-08-20 15:07:09'),
(4, 'Entrepreneurship Guide', 'Author D', 'Business', 'BUS004', 1, '2025-08-20 15:07:09'),
(5, 'Corporate Strategy', 'Author E', 'Business', 'BUS005', 1, '2025-08-20 15:07:09'),
(6, 'Human Anatomy', 'Author F', 'Health Science', 'HEA001', 1, '2025-08-20 15:07:09'),
(7, 'Nutrition Essentials', 'Author G', 'Health Science', 'HEA002', 1, '2025-08-20 15:07:09'),
(8, 'Public Health Basics', 'Author H', 'Health Science', 'HEA003', 1, '2025-08-20 15:07:09'),
(9, 'Medical Ethics', 'Author I', 'Health Science', 'HEA004', 1, '2025-08-20 15:07:09'),
(10, 'Pharmacology 101', 'Author J', 'Health Science', 'HEA005', 1, '2025-08-20 15:07:09'),
(11, 'Sociology Intro', 'Author K', 'Humanities & Social Science', 'HSS001', 1, '2025-08-20 15:07:09'),
(12, 'Philosophy Basics', 'Author L', 'Humanities & Social Science', 'HSS002', 1, '2025-08-20 15:07:09'),
(13, 'History of Art', 'Author M', 'Humanities & Social Science', 'HSS003', 1, '2025-08-20 15:07:09'),
(14, 'Psychology 101', 'Author N', 'Humanities & Social Science', 'HSS004', 1, '2025-08-20 15:07:09'),
(15, 'Cultural Studies', 'Author O', 'Humanities & Social Science', 'HSS005', 1, '2025-08-20 15:07:09'),
(16, 'Constitutional Law', 'Author P', 'Law', 'LAW001', 1, '2025-08-20 15:07:09'),
(17, 'Criminal Law', 'Author Q', 'Law', 'LAW002', 1, '2025-08-20 15:07:09'),
(18, 'Civil Procedure', 'Author R', 'Law', 'LAW003', 1, '2025-08-20 15:07:09'),
(19, 'International Law', 'Author S', 'Law', 'LAW004', 1, '2025-08-20 15:07:09'),
(20, 'Legal Ethics', 'Author T', 'Law', 'LAW005', 1, '2025-08-20 15:07:09'),
(21, 'Physics Fundamentals', 'Author U', 'Science & Engineering', 'SCI001', 1, '2025-08-20 15:07:09'),
(22, 'Chemistry Basics', 'Author V', 'Science & Engineering', 'SCI002', 1, '2025-08-20 15:07:09'),
(23, 'Biology Essentials', 'Author W', 'Science & Engineering', 'SCI003', 1, '2025-08-20 15:07:09'),
(24, 'Mechanical Engineering', 'Author X', 'Science & Engineering', 'SCI004', 1, '2025-08-20 15:07:09'),
(25, 'Electrical Engineering', 'Author Y', 'Science & Engineering', 'SCI005', 1, '2025-08-20 15:07:09');
