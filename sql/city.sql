/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS city;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE city(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(25) NOT  NULL
	);


INSERT INTO city(value,property) VALUES(
	'1','Oshawa');
INSERT INTO city(value,property) VALUES(
	'2','Whitby');

INSERT INTO city(value,property) VALUES(
	'4','Ajax');

INSERT INTO city(value,property) VALUES(
	'8','Pickering');

INSERT INTO city(value,property) VALUES(
	'16','Bowmanville');

INSERT INTO city(value,property) VALUES(
	'32','Porty Perry');

INSERT INTO city(value,property) VALUES(
	'64','Brooklyn');