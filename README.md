# LAMP-Scoring-App
This application will allow pre-defined "judges" to submit scores for "participants," with results displayed on a public scoreboard.
# Judge Scoring System - LAMP Stack Implementation

A complete web application built on Kali Linux using LAMP (Linux, Apache, MySQL, PHP) stack that allows judges to submit scores for participants, with real-time scoreboard display.

## Features

- **Admin Panel**
  - Add/manage judges
  - Add/manage participants
- **Judge Portal**
  - Submit scores (0-100 scale)
  - View submission history
- **Public Scoreboard**
  - Real-time ranking
  - Auto-refreshing display
  - Score statistics (average, total)

## System Requirements

- Kali Linux
- Apache 2.4+
- MariaDB/MySQL 10.3+
- PHP 7.4+
- Web browser (Chrome/Firefox recommended)

## Installation Guide

### 1. LAMP Stack Setup
```bash
sudo apt update
sudo apt install apache2 mariadb-server php libapache2-mod-php php-mysql
sudo systemctl start apache2 mariadb
```
##Database Configuration
```bash
sudo mysql -u root -p < /var/www/judge_system/config/schema.sql
```
##Directory Setup
```bash
sudo chown -R www-data:www-data /var/www/judge_system
sudo chmod -R 755 /var/www/judge_system
```
##Apache Virtual Host
-Create /etc/apache2/sites-available/judge_system.conf
```bash
<VirtualHost *:80>
    ServerName judge.local
    DocumentRoot /var/www/judge_system/public
    <Directory /var/www/judge_system/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
-Enable the site:
```bash
sudo a2ensite judge_system.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```
## Hosts File Entry
```bash
echo "your.ip judge.local" | sudo tee -a /etc/hosts
```
## Accessing the Application
    Admin Panel: http://judge.local/admin/judges.php

    Judge Portal: http://judge.local/judge/score.php

    Public Scoreboard: http://judge.local/scoreboard.php

#Database Schema
```sql
CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_code VARCHAR(20) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL
);

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    participant_code VARCHAR(20) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    participant_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL CHECK (score BETWEEN 0 AND 100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    FOREIGN KEY (participant_id) REFERENCES participants(id)
);
```
##File Structure
```
/var/www/judge_system/
├── config/               # Configuration files
│   ├── database.php      # DB connection settings
│   └── schema.sql        # Database schema
├── includes/             # PHP includes
│   ├── auth.php          # Authentication functions
│   ├── functions.php     # Business logic
│   ├── header.php        # Common header
│   └── footer.php        # Common footer
└── public/               # Web accessible files
    ├── admin/            # Admin interface
    ├── judge/            # Judge portal
    ├── assets/           # Static files
    ├── index.php         # Landing page
    └── scoreboard.php    # Public scoreboard
```
#Usage Instructions
For Administrators

    Access http://judge.local/admin/judges.php

    Add judges with unique codes and display names

    Manage participants and their details

For Judges

    Access the judge portal (in production, would require login)

    Select participant from dropdown

    Enter score (0-100)

    Submit scores

For Public View

    The scoreboard auto-refreshes every 30 seconds

    Displays participants ranked by total score

    Shows average scores and number of evaluations

##Security Considerations
⚠️ Important: This is a demo implementation. For production use:

    Implement proper authentication

    Set up HTTPS

    Add CSRF protection

    Implement input validation

    Set stricter file permissions

 ##Troubleshooting
 Common issues and solutions:

Apache not serving PHP files:
```
sudo apt install libapache2-mod-php
sudo a2enmod php
sudo systemctl restart apache2
```
Database connection errors:

    Verify credentials in /var/www/judge_system/config/database.php

    Check MariaDB is running: sudo systemctl status mariadb

Permission issues:
```
sudo chown -R www-data:www-data /var/www/judge_system
sudo find /var/www/judge_system -type d -exec chmod 755 {} \;
sudo find /var/www/judge_system -type f -exec chmod 644 {} \;
```
##Future Enhancements

    User authentication system

    Score categories/rubrics

    CSV export functionality

    Judge assignment system
##License
MIT License - Free for educational and non-commercial use
    Mobile-responsive design
    
