USE judge_system;

CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_code VARCHAR(20) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participant_code VARCHAR(20) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    participant_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL CHECK (score BETWEEN 0 AND 100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    FOREIGN KEY (participant_id) REFERENCES participants(id)
);

-- Sample data
INSERT INTO judges (judge_code, display_name) VALUES
('J001', 'Judge Alice'),
('J002', 'Judge Bob');

INSERT INTO participants (participant_code, display_name, category) VALUES
('P001', 'Participant One', 'Dance'),
('P002', 'Participant Two', 'Music');
