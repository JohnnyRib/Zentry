CREATE DATABASE IF NOT EXISTS Zentry;
USE Zentry;

DROP USER IF EXISTS 'Zentry_team'@'localhost';

CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';

GRANT ALL PRIVILEGES ON Zentry.* TO 'Zentry_team'@'localhost';

FLUSH PRIVILEGES;


Create table if not exists Events(
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_category VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    evet_time TIME NOT NULL,
    event_location VARCHAR(255) NOT NULL,
    event_description TEXT,
    event_image BLOB,
    event_adio MEDIUMBLOB,
    event_video LONGBLOB 
);

