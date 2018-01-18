/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS have_kids;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE have_kids(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(100) NOT  NULL
	);


INSERT INTO have_kids(value,property) VALUES(
	'1','Yes');
INSERT INTO have_kids(value,property) VALUES(
	'2','Yes, but they live on their own');
INSERT INTO have_kids(value,property) VALUES(
	'4','No');
INSERT INTO have_kids(value,property) VALUES(
	'8','No do not want any');




