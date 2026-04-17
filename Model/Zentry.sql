
DROP DATABASE IF EXISTS Zentry;
DROP USER IF EXISTS 'Zentry_team'@'localhost';
DROP USER IF EXISTS 'app_web'@'localhost';

create database Zentry;
use Zentry;

drop table User;
create table User (
id int primary key auto_increment, 
email varchar(200) not null,
username varchar(50) not null,
password varchar(50) not null,
check (char_length(password) > 8), 
repeat_password varchar(50) not null,
check (password = repeat_password),
role boolean
);


CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP ON Zentry.* TO 'Zentry_team'@'localhost';

CREATE USER 'app_web'@'localhost' IDENTIFIED BY '1234!';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP ON Zentry.* TO 'app_web'@'localhost';

CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';
GRANT ALL PRIVILEGES ON Zentry.* TO 'Zentry_team'@'localhost';

CREATE USER 'app_web'@'localhost' IDENTIFIED BY '1234!';
GRANT ALL PRIVILEGES ON Zentry.* TO 'app_web'@'localhost';

FLUSH PRIVILEGES;
