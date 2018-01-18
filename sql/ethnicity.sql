/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS ethnicity;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE ethnicity(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT  NULL
	);


INSERT INTO ethnicity(value,property) VALUES(
	'1','Middle Eastern');
INSERT INTO ethnicity(value,property) VALUES(
	'2','Caucasian');

INSERT INTO ethnicity(value,property) VALUES(
	'4','Asian');

INSERT INTO ethnicity(value,property) VALUES(
	'8','African American');
INSERT INTO ethnicity(value,property) VALUES(
	'16','Latino/Hispanic');
