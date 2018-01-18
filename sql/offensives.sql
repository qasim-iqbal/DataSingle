/*
Author:group09
Filename: offensive.sql
Date: October 10 2017
Course code: Webd3201
Description: This is the script which creates the data tables and also inserts four records
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS offensives;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE offensives(
	 PRIMARY KEY(reporter, offender),
	reporter VARCHAR(20) NOT NULL,
	offender VARCHAR(20) NOT NULL,
	status VARCHAR(1) NOT  NULL,
	last_reported Date NOT NULL
	);


