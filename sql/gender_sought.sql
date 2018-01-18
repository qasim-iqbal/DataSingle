/*
Author:group09
Filename: gender_sought.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS gender_sought;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE gender_sought(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(6) NOT  NULL
	);

INSERT INTO gender_sought(value,property) VALUES(
	'1','male');
INSERT INTO gender_sought(value,property) VALUES(
	'2','female');

