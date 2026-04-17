CREATE DATABASE IF NOT EXISTS Zentry;
USE Zentry;

DROP USER IF EXISTS 'Zentry_team'@'localhost';

CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';

GRANT ALL PRIVILEGES ON Zentry.* TO 'Zentry_team'@'localhost';

FLUSH PRIVILEGES;
