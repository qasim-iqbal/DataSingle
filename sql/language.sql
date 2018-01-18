/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS language;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE language(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(25) NOT  NULL
	);

INSERT INTO language(value,property) VALUES(
	'1','Arabic');
INSERT INTO language(value,property) VALUES(
	'2','Chinese');

INSERT INTO language(value,property) VALUES(
	'4','Spanish');
INSERT INTO language(value,property) VALUES(
	'8','English');

INSERT INTO language(value,property) VALUES(
	'16','French');
INSERT INTO language(value,property) VALUES(
	'32','German');

INSERT INTO language(value,property) VALUES(
	'64','Italian');

