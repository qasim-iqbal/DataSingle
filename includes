<?php
 
function db_connect()
{
	$query = "host=" . HOSTNAME . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASSWORD;
	$conn = pg_connect("$query");	
	return $conn;
}

$conn = db_connect();
$statement1 = pg_prepare($conn, "login_update", 'UPDATE users SET last_access = $1 WHERE user_id = $2');
$statement2 = pg_prepare($conn, "login_query", 'SELECT * FROM users WHERE user_id = $1 AND password = $2');
$statement3 = pg_prepare($conn, "user_query", 'SELECT * FROM users WHERE user_id = $1');
$statement4 = pg_prepare($conn, "login_insert", 'INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9)');
$statement5 = pg_prepare($conn, "profile_insert", 'INSERT INTO profiles(user_id, gender, gender_sought, city, images, match_description, ethnicity, marital_status, religion, education, language, 
political_view, occupation, salary, headline, smoke, drink, have_kids, want_kids, self_description, excercise_frequency, hair_color, eye_color, body_type, looking_for, height_inches) 
VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23, $24, $25, $26)');
$statement6 = pg_prepare($conn, "profile_update", 'UPDATE profiles SET gender = $2, gender_sought = $3, city = $4, images=$5, match_description=$6, ethnicity=$7, marital_status=$8, religion=$9, 
education=$10, language=$11, political_view=$12, occupation=$13, salary=$14, headline=$15, smoke=$16, drink=$17, have_kids=$18, want_kids=$19, self_description=$20, excercise_frequency=$21, 
hair_color=$22, eye_color=$23, body_type=$24, looking_for=$25, height_inches=$26 WHERE user_id = $1');
$statement7 = pg_prepare($conn, "password_update", "UPDATE users SET password = $1 WHERE user_id = $2");

$statement6 = pg_prepare($conn,"fetch_profiles",'SELECT * FROM profiles WHERE gender = $1');
$statement8 =pg_prepare($conn, "profile_display", 'SELECT  * FROM profiles join users on profiles.user_id= users.user_id where profiles.user_id=$1');
$statement9 = pg_prepare($conn, "count_images", 'SELECT images FROM profiles WHERE user_id = $1');
$statement10 = pg_prepare($conn, "update_images", 'UPDATE profiles SET images = $2 WHERE user_id = $1');
$statement11 = pg_prepare($conn, "check_user", 'SELECT * FROM users WHERE user_id =$1 AND email_address=$2');
$statement12 = pg_prepare($conn, "update_client", ' UPDATE users SET first_name=$2, last_name=$3,email_address=$4 WHERE user_id=$1');
$statement13 = pg_prepare($conn, "update_user_type", ' UPDATE users SET user_type=$2  WHERE user_id=$1');
$statement14 = pg_prepare($conn, "update_offense_case", 'UPDATE offensives SET status=$2 WHERE offender=$1 ');
$statement15 = pg_prepare($conn, "report_user", 'INSERT INTO offensives(reporter, offender,status,last_reported) VALUES($1,$2,$3,$4)');

function getProperty($conn, $table, $value)
{
	$sql = "SELECT property FROM " . $table . " WHERE value = " . $value;
	return pg_fetch_result(pg_query($conn, $sql), 0, 0);
}

//  Build DropDown Functions

function buildRadio($table,$title="",$class="",$includeFirstIndex = true,$post_val=-1,$simple=false)
{
	 $conn = db_connect();
	 $sql = $includeFirstIndex ? "SELECT * FROM $table" : "SELECT * FROM $table WHERE value <> 0";

	 $result = pg_query($conn, $sql);
	 
	 if ($title == "")
	 {
		$title = ucwords(str_replace("_"," ",$table));
	 }
	 if ($simple == false)
	 {
		if($class != ""){
			echo '<div class="' . $class . '">';
		 }
	  echo '<div><h2>'.$title.'</h2></div>
			<div>';
	 }


	 if($includeFirstIndex == true)
	 {
		echo '<input type="radio" name="' . $table . '" value="'.DEFAULT_OPTION_VALUE.'">'.DEFAULT_OPTION_TEXT.'</input>';
	 } 
	 while ($row = pg_fetch_assoc($result)) 
	 {
		 if($post_val == $row['value'])
		 {
			echo "<input type=\"radio\" name=\"" . $table . "\" value=\"".$row['value']."\" checked=\"checked\">".$row['property']."</input>";
		 }
		 else
		 {
			echo "<input type=\"radio\" name=\"" . $table . "\" value=\"".$row['value']."\">".$row['property']."</input>";
		 }
	 }        
	if ($simple == false){
		echo "</div>"; 
		if($class!=""){
			echo"</div>";
		}
	}

 
}

function buildDropdown($table,$title="",$class="",$includeFirstIndex = true,$post_val=-1,$simple=false)
{

 $conn = db_connect();

 if ($includeFirstIndex == false){
  $sql = "SELECT * FROM $table WHERE value <> 0";
 } else {
  $sql = "SELECT * FROM $table";
 }

 $result = pg_query($conn, $sql);
 if ($title == ""){
  $title = ucword(str_replace("_"," ",$table));
 }
 if ( $simple == false){
	 if($class != ""){
		echo '<div class="' . $class . '">';
	 }
  echo '<div><h2>'.$title.'</h2></div>
		<div>';
 }
 if($simple== true & $class!=""){
	echo "<select class=\"" . $class . "\" name=\"" . $table . "\">";
 }else{
	echo "<select name=\"" . $table . "\">";
 }

 
 if($includeFirstIndex == true){
  echo "<option value=\"".DEFAULT_OPTION_VALUE."\">".DEFAULT_OPTION_TEXT."</option>";
 } 
 while ($row = pg_fetch_assoc($result)) {
  if($post_val == $row['value'])
  {
   echo "<option value=\"".$row['value']."\" selected=\"selected\"> ".$row['property']." </option>";
  }else{
  echo "<option value=\"".$row['value']."\"> ".$row['property']." </option>";
  }
 }        

 echo "</select>";
 if ($simple == false){
	echo "</div>"; 
	if($class!=""){
		echo"</div>";
	}
 }


}
#function buildDropdown($table,$title="",$class="",$includeFirstIndex = true,$post_val=-1,$simple=false)

function buildCheckbox($table,$title="",$class="",$includeFirstIndex = true,$post_val=-1,$simple=false, $include_ids=false)
{
	$conn = db_connect();
	$sql = $includeFirstIndex ? "SELECT * FROM $table" : "SELECT * FROM $table WHERE value <> 1";
	$id = $include_ids ? "id=\"" . $row['value'] . "\"" : "";

	$result = pg_query($conn, $sql);

	if ($title == ""){
		$title = ucwords(str_replace("_"," ",$table));
	}
	if($simple == false){
		if($class != ""){
			echo 'div<class="'.$class.'">';
		}
		echo '<div><h2>'.$title.'</h2></div>';
	}


	echo '<div class="checkbox-grid"><ul>';
	

	while ($row = pg_fetch_assoc($result)) {
		
		echo "<li>
				<label class=\"control control--checkbox\">" . $row['property'] .""; 
		if($post_val & intval($row['value']))
		{
		echo"<input type=\"checkbox\"" . $id . " name=\"".$table."[]\"  value=\"".$row['value']."\" checked=\"checked\"/>
						<div class=\"control__indicator\"></div>";
		}else{
			echo"<input type=\"checkbox\" " . $id . " name=\"".$table."[]\"  value=\"".$row['value']."\"/>
			<div class=\"control__indicator\"></div>";
		}
		echo "</label>
		</li>"; 
	}        


	echo '</ul></div>';
}

function getPropertyByValue($table,$post_val){
	$conn = db_connect();

	$val = "";
	$sql = "SELECT * FROM $table";
	$results = pg_query($conn,$sql);

	while ($row = pg_fetch_assoc($results)) {
		if($post_val & intval($row['value']))
		{
			
			$val .= " ".$row['property']."," ;

		}
	}
	return $val;

}
?>
