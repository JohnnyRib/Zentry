create database Zentry;
drop user 'app_web'@'localhost';
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
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP ON Zentry.* TO 'app_web'@'localhost';


//-- Primero borramos si existen para evitar conflictos
DROP USER IF EXISTS 'Zentry_team'@'localhost';
DROP USER IF EXISTS 'app_web'@'localhost';

-- Creamos el usuario del equipo
CREATE USER 'Zentry_team'@'localhost' IDENTIFIED BY 'Zentry687';
GRANT ALL PRIVILEGES ON Zentry.* TO 'Zentry_team'@'localhost';

-- Creamos el usuario de la web
CREATE USER 'app_web'@'localhost' IDENTIFIED BY '1234!';
GRANT SELECT, INSERT, UPDATE, DELETE ON Zentry.* TO 'app_web'@'localhost';

-- Aplicamos los cambios
FLUSH PRIVILEGES;