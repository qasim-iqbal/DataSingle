/*
Author:group09
Filename: interests.sql
Date: January 10th 2018
Course code: Webd3201
Description: Used to store interest shown between users
*/

DROP TABLE IF EXISTS interests;

CREATE TABLE interests
(
  PRIMARY KEY(user_id, interest_id),
  user_id VARCHAR(20) NOT NULL,
  interest_id VARCHAR(20) NOT NULL,
  interest_time Date NOT NULL
);