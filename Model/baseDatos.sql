create database GameHub;

use GameHub;

create table User (
id int primary key auto_increment, 
email varchar(200) not null,
username varchar(50) not null,
age int not null,
password varchar(50) not null,
check (char_length(password) > 8), 
role boolean
);

