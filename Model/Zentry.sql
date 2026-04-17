create database Zentry;

use Zentry;

create table User (
id int primary key auto_increment, 
email varchar(200) not null,
username varchar(50) not null,
age int not null,
password varchar(50) not null,
check (char_length(password) > 8), 
repeat_password varchar(50) not null,
check (password = repeat_password),
role boolean
);


CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP ON Zentry.* TO 'Zentry_team'@'localhost';

CREATE USER 'app_web'@'localhost' IDENTIFIED BY '1234!';
GRANT SELECT, INSERT, UPDATE, DELETE ON nombre_bd.* TO 'app_web'@'localhost';

