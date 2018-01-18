/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS occupation;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE occupation(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(25) NOT  NULL
	);


INSERT INTO occupation(value,property) VALUES(
	'1','Administrative');
INSERT INTO occupation(value,property) VALUES(
	'2','Artistic');

INSERT INTO occupation(value,property) VALUES(
	'4','Labor');
INSERT INTO occupation(value,property) VALUES(
	'8','Financial');


INSERT INTO occupation(value,property) VALUES(
	'16','Medical');
INSERT INTO occupation(value,property) VALUES(
	'32','Political');
INSERT INTO occupation(value,property) VALUES(
	'64','Sales');

INSERT INTO occupation(value,property) VALUES(
	'128','Engineer');
INSERT INTO occupation(value,property) VALUES(
	'256','Teacher');
INSERT INTO occupation(value,property) VALUES(
	'512','Law');






