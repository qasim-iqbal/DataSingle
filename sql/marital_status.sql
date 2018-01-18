/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS marital_status;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE marital_status(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(25) NOT  NULL
	);



INSERT INTO marital_status(value,property) VALUES(
	'1','Single');
INSERT INTO marital_status(value,property) VALUES(
	'2','Married');

INSERT INTO marital_status(value,property) VALUES(
	'4','Divorced');
INSERT INTO marital_status(value,property) VALUES(
	'8','Widowed');

INSERT INTO marital_status(value,property) VALUES(
	'16','In an Open Relationship');

