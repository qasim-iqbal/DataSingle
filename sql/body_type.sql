/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS body_type;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE body_type(
	value SMALLINT PRIMARY KEY,
	Property VARCHAR(25) NOT  NULL
	);



INSERT INTO body_type(value,property) VALUES(
	'1','Slender');
INSERT INTO body_type(value,property) VALUES(
	'2','Curvy');

INSERT INTO body_type(value,property) VALUES(
	'4','Average');

INSERT INTO body_type(value,property) VALUES(
	'8','Athletic');




