/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS want_kids;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE want_kids(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(100) NOT  NULL
	);



INSERT INTO want_kids(value,property) VALUES(
	'1','Definitely');
INSERT INTO want_kids(value,property) VALUES(
	'2','Undecided');


INSERT INTO want_kids(value,property) VALUES(
	'4','No');


