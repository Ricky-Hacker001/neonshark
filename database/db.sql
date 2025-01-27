CREATE DATABASE college_notes;

USE college_notes;

-- Table: colleges
CREATE TABLE colleges (
    college_id INT AUTO_INCREMENT PRIMARY KEY,
    college_name VARCHAR(255) NOT NULL
);

-- Table: departments
CREATE TABLE departments (
    dept_id INT AUTO_INCREMENT PRIMARY KEY,
    college_id INT NOT NULL,
    dept_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (college_id) REFERENCES colleges(college_id) ON DELETE CASCADE
);

-- Table: semesters
CREATE TABLE semesters (
    sem_id INT AUTO_INCREMENT PRIMARY KEY,
    dept_id INT NOT NULL,
    semester INT NOT NULL,
    FOREIGN KEY (dept_id) REFERENCES departments(dept_id) ON DELETE CASCADE
);

-- Table: subjects
CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    sem_id INT NOT NULL,
    subject_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (sem_id) REFERENCES semesters(sem_id) ON DELETE CASCADE
);

-- Table: notes
CREATE TABLE notes (
    note_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    academic_year VARCHAR(9) NOT NULL, -- Example: "2024-2025"
    semester INT NOT NULL,
    note_file VARCHAR(255) NOT NULL,
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE
);

-- Table: admin
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


INSERT INTO colleges (college_name) VALUES 
('ABC College of Engineering'),
('XYZ Institute of Technology'),
('DEF University');
INSERT INTO departments (college_id, dept_name) VALUES 
(1, 'Computer Science and Engineering'),
(1, 'Electronics and Communication Engineering'),
(2, 'Mechanical Engineering'),
(2, 'Civil Engineering'),
(3, 'Electrical Engineering');
INSERT INTO semesters (dept_id, semester) VALUES 
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8),
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6), (2, 7), (2, 8),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6), (3, 7), (3, 8),
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6), (4, 7), (4, 8),
(5, 1), (5, 2), (5, 3), (5, 4), (5, 5), (5, 6), (5, 7), (5, 8);
INSERT INTO subjects (sem_id, subject_name) VALUES 
(1, 'Mathematics - I'), (1, 'Physics'), (1, 'Programming Basics'),
(2, 'Mathematics - II'), (2, 'Digital Circuits'), (2, 'Data Structures'),
(3, 'Database Management Systems'), (3, 'Computer Networks'), (3, 'Operating Systems'),
(4, 'Software Engineering'), (4, 'Microprocessors'), (4, 'Theory of Computation'),
(5, 'Machine Learning'), (5, 'Artificial Intelligence'), (5, 'Web Development'),
(6, 'Cloud Computing'), (6, 'Internet of Things'), (6, 'Big Data Analytics');
INSERT INTO notes (subject_id, academic_year, semester, note_file) VALUES 
(1, '2023-2024', 1, 'mathematics1_2023.pdf'),
(2, '2023-2024', 1, 'physics_2023.pdf'),
(3, '2023-2024', 1, 'programming_basics_2023.pdf'),
(4, '2024-2025', 2, 'mathematics2_2024.pdf'),
(5, '2024-2025', 2, 'digital_circuits_2024.pdf'),
(6, '2024-2025', 2, 'data_structures_2024.pdf'),
(7, '2024-2025', 3, 'dbms_2024.pdf'),
(8, '2024-2025', 3, 'computer_networks_2024.pdf'),
(9, '2024-2025', 3, 'operating_systems_2024.pdf');
INSERT INTO admin (username, password) VALUES 
('admin', 'admin123'),
('superadmin', 'superadmin123');
