/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS active;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE active(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(100) NOT  NULL
	);



INSERT INTO active(value,property) VALUES(
	'1','1 to 2 days a week');
INSERT INTO active(value,property) VALUES(
	'2','3 to 4 days a week');

INSERT INTO active(value,property) VALUES(
	'4','5 or more days a week');




