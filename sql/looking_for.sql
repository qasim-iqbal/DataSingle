/*
Author:group09
Filename: looking_for.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS relationship_status; --old table, just making sure it's gone
DROP TABLE IF EXISTS looking_for;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE looking_for(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(10) NOT  NULL
	);

INSERT INTO looking_for(value,property) VALUES(
	'1','Marriage');
INSERT INTO looking_for(value,property) VALUES(
	'2','Casual');

INSERT INTO looking_for(value,property) VALUES(
	'4','Long term');

INSERT INTO looking_for(value,property) VALUES(
	'8','Friendship');

