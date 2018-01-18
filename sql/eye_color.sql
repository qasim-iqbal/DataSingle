/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS eye_color;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE eye_color(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(15) NOT  NULL
	);


INSERT INTO eye_color(value,property) VALUES(
	'1','Black');
INSERT INTO eye_color(value,property) VALUES(
	'2','Brown');

INSERT INTO eye_color(value,property) VALUES(
	'4','Blue');

INSERT INTO eye_color(value,property) VALUES(
	'8','Green');

INSERT INTO eye_color(value,property) VALUES(
	'16','Grey');

