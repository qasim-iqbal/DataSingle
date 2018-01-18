/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS salary;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE salary(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(100) NOT  NULL
	);



INSERT INTO salary(value,property) VALUES(
	'1','Less than $25,000');
INSERT INTO salary(value,property) VALUES(
	'2','$25,001 to $50,000');

INSERT INTO salary(value,property) VALUES(
	'4','$50,001 to $75,000');
INSERT INTO salary(value,property) VALUES(
	'8','$75,001 to $100,000');


INSERT INTO salary(value,property) VALUES(
	'16','greater than $100,000');



