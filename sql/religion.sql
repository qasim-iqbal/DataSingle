/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS religion;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE religion(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT  NULL
	);


INSERT INTO religion(value,property) VALUES(
	'1','Agnostic');
INSERT INTO religion(value,property) VALUES(
	'2','Buddhist');

INSERT INTO religion(value,property) VALUES(
	'4','Atheist');

INSERT INTO religion(value,property) VALUES(
	'8','Catholic');
INSERT INTO religion(value,property) VALUES(
	'16','Christian');
INSERT INTO religion(value,property) VALUES(
	'32','Muslim');
