/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS smoke;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE smoke(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(100) NOT  NULL
	);



INSERT INTO smoke(value,property) VALUES(
	'1','Yes');
INSERT INTO smoke	(value,property) VALUES(
	'2','Socially');

INSERT INTO smoke(value,property) VALUES(
	'4','Trying to quit');

INSERT INTO smoke(value,property) VALUES(
	'8','No');

