/*
Author:group09
Filename: users.sql
Date: September 19 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data

DROP TABLE IF EXISTS users;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE users(
	user_id VARCHAR(20) PRIMARY KEY,
	password VARCHAR(32) NOT  NULL,
	user_type VARCHAR(2) NOT NULL,
	email_address VARCHAR(256) NOT NULL,
	first_name VARCHAR(128) NOT NULL,
	last_name VARCHAR(128) NOT NULL,
	birth_date Date NOT NULL,
	enrol_date Date NOT NULL,
	last_access Date NOT NULL
	);


INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES(
	'jdoe',
	md5('password'), 'a', 'j.doe@gmail.com', 'Jeff', 'Doe', '1981-03-12','2017-09-10','2017-03-04');

INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES(
	'jsmith',
	md5('password'), 'ic', 'j.smith@gmail.com', 'Janne', 'Smith', '1981-03-19','2017-09-10','2017-03-04');

INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES(
	'KSmith',
	md5('password'), 'ic', 'k.smith@gmail.com', 'Kevin', 'Smith', '1981-04-12','2017-09-10','2017-03-04');

INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES(
	'angelbaby',
	md5('password'), 'ic', 'E.Lacey@gmail.com', 'Eve', 'Lacey', '1983-02-12','2017-09-10','2017-03-04');
INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES(
	'testsubject',
	md5('password'), 'd', 'JanDoe@gmail.com', 'Eve', 'Lacey', '1983-02-12','2017-09-10','2017-03-04');


