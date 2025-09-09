-- Create database
CREATE DATABASE IF NOT EXISTS news_portal;
USE news_portal;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create news table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@example.com', 'admin123', 'admin');

-- Insert sample news articles
INSERT INTO news (title, content, category, author) VALUES 
('Welcome to News Portal', 'This is the first article on our news portal. Stay tuned for more updates and breaking news from around the world.', 'General', 'Admin'),
('Technology Trends 2024', 'Artificial Intelligence and Machine Learning continue to shape the future of technology. Here are the top trends to watch this year.', 'Technology', 'Tech Reporter'),
('Sports Update', 'Latest updates from the world of sports including football, basketball, and tennis championships.', 'Sports', 'Sports Desk');
