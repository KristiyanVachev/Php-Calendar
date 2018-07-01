CREATE DATABASE calendar;

USE calendar;

CREATE TABLE lecture (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	subjectName VARCHAR(30) NOT NULL,
	room VARCHAR(30) NOT NULL,
	lecturerName VARCHAR(50) NOT NULL,
	startHour INT(3),
	endHour INT(3),
	dayId INT(3)
);

-- CREATE DATABASE test;

-- use test;

-- CREATE TABLE users (
	-- id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	-- firstname VARCHAR(30) NOT NULL,
	-- lastname VARCHAR(30) NOT NULL,
	-- email VARCHAR(50) NOT NULL,
	-- age INT(3),
	-- location VARCHAR(50),
	-- date TIMESTAMP
-- );