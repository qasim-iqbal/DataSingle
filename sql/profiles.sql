DROP TABLE IF EXISTS profiles;


-- CREATE the table, note that id has to be unique, and you must have a name

CREATE TABLE profiles(
	user_id VARCHAR(20) Primary Key REFERENCES users(user_id),
	gender SMALLINT NOT  NULL,
	gender_sought SMALLINT NOT NULL,
	city INTEGER NOT NULL,
	images SMALLINT NOT NULL DEFAULT 0,
	match_description VARCHAR(1000) NOT NULL,
	ethnicity INTEGER NOT NULL DEFAULT 0,
	marital_status INTEGER NOT NULL DEFAULT 0,
	religion INTEGER NOT NULL DEFAULT 0,
	education SMALLINT NOT NULL DEFAULT 0,
	language INTEGER NOT NULL DEFAULT 0,
	political_view  INTEGER NOT NULL DEFAULT 0,
	occupation INTEGER NOT NULL DEFAULT 0,
	salary SMALLINT NOT NULL DEFAULT 0,
	headline VARCHAR(100) NOT NULL,
	smoke SMALLINT NOT NULL DEFAULT 0,
	drink SMALLINT NOT NULL DEFAULT 0,
	have_kids SMALLINT NOT NULL DEFAULT 0,
	want_kids SMALLINT NOT NULL DEFAULT 0,
	self_description VARCHAR(1000) NOT NULL,
	excercise_frequency INTEGER NOT NULL DEFAULT 0,
	hair_color INTEGER NOT NULL DEFAULT 0,
	eye_color INTEGER NOT NULL DEFAULT 0,
	body_type INTEGER NOT NULL DEFAULT 0,
	looking_for INTEGER NOT NULL DEFAULT 0,
	height_inches INTEGER NOT NULL DEFAULT 0
	
	);