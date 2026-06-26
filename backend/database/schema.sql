-- Database Setup
CREATE DATABASE IF NOT EXISTS college_voting_system;
USE college_voting_system;

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'student', 'candidate') DEFAULT 'student',
    department VARCHAR(100),
    enrollment_number VARCHAR(50) UNIQUE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Candidates Table
CREATE TABLE candidates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    position VARCHAR(100) NOT NULL,
    manifesto TEXT,
    votes_count INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Votes Table
CREATE TABLE votes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    voter_id INT NOT NULL,
    candidate_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_vote (voter_id, candidate_id),
    FOREIGN KEY (voter_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE
);

-- Voting Positions Table
CREATE TABLE positions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sessions Table
CREATE TABLE sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample positions
INSERT INTO positions (name, description) VALUES
('President', 'College President'),
('Vice President', 'Vice President'),
('Secretary', 'General Secretary'),
('Treasurer', 'Finance Manager');

-- Create admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role, department, status) VALUES
('admin', 'admin@college.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/KFm', 'Admin User', 'admin', 'Administration', 'active');

-- Create sample students
INSERT INTO users (username, email, password, full_name, role, department, enrollment_number, status) VALUES
('student1', 'student1@college.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/KFm', 'Student One', 'student', 'CSE', '2024001', 'active'),
('student2', 'student2@college.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/KFm', 'Student Two', 'student', 'ECE', '2024002', 'active'),
('student3', 'student3@college.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/KFm', 'Student Three', 'student', 'ME', '2024003', 'active');

-- Create sample candidates
INSERT INTO candidates (user_id, position, manifesto, votes_count, status) VALUES
(2, 'President', 'My vision for college...', 0, 'active'),
(3, 'Vice President', 'Supporting students...', 0, 'active'),
(4, 'Secretary', 'Organizing events...', 0, 'active');
