<?php
require './names.php';
require './includes/constants.php'; 
require './includes/functions.php'; 
require './includes/db.php';

define('EIGHTEEN_YEARS_IN_SECONDS', 60*60*24*365*18);
define('MIN_HEIGHT_INCHES', 36);
define('MAX_HEIGHT_INCHES', 107);
define('MIN_USERNAME_NUMBER', 0);
define('MAX_USERNAME_NUMBER', 1000);
define('USER_COUNT', 2500);
define('MAX_MIN_MATCH_AGE', 50); //the highest minimum value for the match age range
define('MAX_AGE_RANGE', 20); //the maximum difference between the min and max values of the match age range
define('MIN_AGE_RANGE', 5);
define('USERS_TEST_PASSWORD', "password");

//list of adjectives https://www.d.umn.edu/~rave0029/research/adjectives1.txt
//list of nouns http://www.desiquintans.com/downloads/nounlist/nounlist.txt
$adjective_list = file('./adjectivelist.txt');
$noun_list = file('./nounlist.txt');

define('NOUN_COUNT', count($noun_list));
define('ADJECTIVE_COUNT', count($adjective_list));

$email_list = array("@hotmail.com", "@gmail.com", "@yahoo.ca");

$headline_quotes = 
array(
"Life is about making an impact, not making an income. --Kevin Kruse",
"Strive not to be a success, but rather to be of value. –Albert Einstein",
"You miss 100% of the shots you don’t take. –Wayne Gretzky",
"Every strike brings me closer to the next home run. –Babe Ruth",
"We become what we think about. –Earl Nightingale",
"The mind is everything. What you think you become.  –Buddha",
"An unexamined life is not worth living. –Socrates",
"Eighty percent of success is showing up. –Woody Allen",
"Winning isn’t everything, but wanting to win is. –Vince Lombardi",
"Either you run the day, or the day runs you. –Jim Rohn"
);

$tables = ['gender', 'gender_sought', 'city', 'looking_for', 'ethnicity', 'marital_status', 'religion', 'education', 'language',
 'political_view', 'occupation', 'salary', 'smoke', 'drink', 'have_kids', 'want_kids', 'excercise_frequency', 'hair_color', 'eye_color', 'body_type'];
 
$user_types = ['a', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 'ic', 
	'ic', 'ic', 'ic', 'ic', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'dc'];
 
$conn = db_connect();
 
 for($i = 0; $i < USER_COUNT; $i++)
 {
	 $data = array();
	
	//iterate through each table which has a set series of characteristics (the drop downs) and pick one at random,
	//for both the user and his match_description
	foreach($tables as $table)
	{
		$sql = "SELECT * FROM " . $table . " WHERE value <> 0";
		$results = pg_query($conn, $sql);
		$value = pg_fetch_assoc($results, mt_rand(0, pg_num_rows($results) - 1));
		$data[$table] = $value['value'];
		
		//used for building the match_description
		$value = pg_fetch_assoc($results, mt_rand(0, pg_num_rows($results) - 1));
		$data['match_' . $table] = $value['value'];
	}
	 
	//randomly generate the user_id based on a list of adjectives, nouns, and a random number
		
	$data['user_id'] = pg_escape_string(trim($adjective_list[mt_rand(0, ADJECTIVE_COUNT - 1)]) . trim($noun_list[mt_rand(0, NOUN_COUNT - 1)]));
	$data['user_id'] = strlen($data['user_id'] . MAX_USERNAME_NUMBER) > MAXIMUM_ID_LENGTH ? substr($data['user_id'], 0, MAXIMUM_ID_LENGTH - strlen(MAX_USERNAME_NUMBER)) : $data['user_id'];

	do
	{
		$data['user_id_number'] = mt_rand(MIN_USERNAME_NUMBER, MAX_USERNAME_NUMBER);
	}
	while(isExistingUser($conn, $data['user_id'] . $data['user_id_number'])); //ensure the user_id isn't already taken
	
	$data['user_id'] .= $data['user_id_number'];
	
	//determine the values of user data which cannot be selected from a set of values (not the dropdowns)
	$data['password'] = hash('md5',USERS_TEST_PASSWORD);
	$data['user_type'] = $user_types[mt_rand(0, count($user_types) - 1)];
	$data['birth_date'] = date("Y-m-d", mt_rand(0, time()-(EIGHTEEN_YEARS_IN_SECONDS)));
	$data['enrol_date'] = date("Y-m-d", mt_rand(strtotime($data['birth_date']), time()));
	$data['last_access'] = date("Y-m-d", mt_rand(strtotime($data['enrol_date']), time()));
	$data['first_name'] = ucfirst(strtolower(($data['gender'] == 'male') ? $male_names[mt_rand(0, count($male_names)-1)] : $female_names[mt_rand(0, count($female_names)-1)]));
	$data['last_name'] = ucfirst(strtolower($last_names[mt_rand(0, count($last_names)-1)]));
	$data['email_address'] = strtolower(trim($data['first_name']) . "." . trim($data['last_name'])) . trim($email_list[mt_rand(0, count($email_list) - 1)]);
	$data['headline'] = pg_escape_string($headline_quotes[mt_rand(0, count($headline_quotes) - 1)]);
	$data['height_inches'] = mt_rand(MIN_HEIGHT_INCHES, MAX_HEIGHT_INCHES);

	//generate the users self description based on his randomly generated characteristics
	$data['self_description'] = "I am a " . calculateAge($data['birth_date']) . " year old " . 
	strtolower(getProperty($conn, "ethnicity",$data['ethnicity'])) . " " . 
	strtolower(getProperty($conn, "gender",$data['gender'])) . " from " . 
	strtolower(getProperty($conn, "city",$data['city'])) . " looking for a " . 
	strtolower(getProperty($conn, "gender_sought",$data['gender_sought'])) . " who can have a " . 
	strtolower(getProperty($conn, "looking_for",$data['looking_for'])) . " relationship with me.";
	$data['self_description'] = strlen($data['self_description']) > MAXIMUM_DESCRIPTION_LENGTH ? substr($data['self_description'], 0, MAXIMUM_DESCRIPTION_LENGTH) : $data['self_description'];
	
	//generate the users match description based on randomly generated characteristics independent of
	//the users data
	$match_min_age = mt_rand(MINIMUM_AGE, MAX_MIN_MATCH_AGE);
	$match_max_age = mt_rand($match_min_age, $match_min_age+mt_rand(MIN_AGE_RANGE,MAX_AGE_RANGE));
	
	$data['match_description'] = "Looking for a " . strtolower(getProperty($conn,"eye_color",$data['match_eye_color'])) . " eyed " . strtolower(getProperty($conn,"hair_color",$data['match_hair_color'])) . 
	" haired " . $match_min_age . " - " . $match_max_age . " year old " . strtolower(getProperty($conn, "gender", $data['match_gender'])) . " who wants a " . 
	strtolower(getProperty($conn, "looking_for", $data['looking_for'])) . " relationship";
	$data['match_description'] = strlen($data['match_description']) > MAXIMUM_DESCRIPTION_LENGTH ? substr($data['match_description'], 0, MAXIMUM_DESCRIPTION_LENGTH) : $data['match_description'];
	
	//display the data for testing
	  print_r($data);
	  echo "<br/>
		    <br/>";
		  
	//uncomment to insert the randomly generated user and profile into the database
	$result = pg_execute($conn, 'login_insert', array($data['user_id'], $data['password'], $data['user_type'], $data['email_address'], 
	$data['first_name'], $data['last_name'], $data['birth_date'], $data['enrol_date'], $data['last_access']));
	
	//only add a profile for complete or disabled complete users
	if($data['user_type'] == 'c' || $data['user_type'] == 'dc')
	{
		$result = pg_execute($conn, 'profile_insert', array($data['user_id'], $data['gender'], $data['gender_sought'], $data['city'], 0, 
		$data['match_description'], $data['ethnicity'], $data['marital_status'], $data['religion'], $data['education'], $data['language'], 
		$data['political_view'], $data['occupation'], $data['salary'], $data['headline'], $data['smoke'], $data['drink'], $data['have_kids'],
		$data['want_kids'], $data['self_description'], $data['excercise_frequency'], $data['hair_color'], $data['eye_color'], $data['body_type'], 
		$data['looking_for'], $data['height_inches']));
	}
 }
 
 echo "<h1>User Generation Complete</h1>";
 
?>
