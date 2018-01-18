<?php
/*
Names: Qasim Iqbal, Nathan Williams, Jonathan Hermans, Karence Ma
Last Modified: Sept 28th 2017
File: functions.php
Desc: Create all your functions here for use in the pages
*/

/* -- Imported from webd3201 deliverable specific requirement by darren
	this function should be passed a integer power of 2, and any 
	decimal number,	it will return true (1) if the power of 2 is 
	contain as part of the decimal argument
*/
function isBitSet($power, $decimal) {
	$val = 0;
	if($power & $decimal){
		$val = 1;
	}

	else{
		$val = 0;
	}
	return $val;

} 
// function works on refrence 
function switchValues(&$val1,&$val2){
	$temp = $val1;
	$val1 = $val2;
	$val2 = $temp;
}


/* -- Imported from webd3201 deliverable specific requirement by darren
	this function can be passed an array of numbers 
	(like those submitted as part of a named[] check 
	box array in the $_POST array).
*/
function sumCheckBox($array)
{
	$num_checks = count($array); 
	$sum = 0;
	for ($i = 0; $i < $num_checks; $i++)
	{
	  $sum += $array[$i]; 
	}
	return $sum;
}

function createPagination($records, $current_page, $url="profile-search-result.php?current_page=", $results_per_page=MATCHES_PER_PAGE)
{
	if($records > $results_per_page)
	{
		$total_pages = ceil($records/$results_per_page);
		
		$min_displayed_page = $current_page > PAGINATION_RANGE_FROM_CURRENT ? $current_page - PAGINATION_RANGE_FROM_CURRENT : 1;

		/*if($current_page >= $total_pages - PAGINATION_RANGE_FROM_CURRENT)
		{
			$min_displayed_page -= $current_page + PAGINATION_RANGE_FROM_CURRENT - $total_pages;
		}*/
		
		$max_displayed_page = $current_page + PAGINATION_RANGE_FROM_CURRENT > $total_pages ? $total_pages : $current_page + PAGINATION_RANGE_FROM_CURRENT;
		
		/*if($current_page <= PAGINATION_RANGE_FROM_CURRENT)
		{
			$max_displayed_page += PAGINATION_RANGE_FROM_CURRENT - $current_page + 1;
		}*/
		
		echo '<hr/>
			  <h1 class="centered_text">';
		
		for($page_num=$min_displayed_page;$page_num<=$max_displayed_page;$page_num++)
		{
			echo '<a href="' . $url . ''.$page_num.'">';
			if($page_num == $current_page)
			{
				echo "<b>" . $page_num . "</b>  ";
			}
			else
			{
				echo $page_num . "  ";
			}
			echo '</a>';
			
		}
		
		echo '</h1>
			  <hr/>';
	}
}
function isExistingUser($conn, $user_id)
{
	$sql = "SELECT * FROM users WHERE user_id = '" . $user_id . "'";
	return boolval(pg_num_rows(pg_query($conn, $sql)));
}
function getReorderedArray($array_to_change, $ordered_keys)
{
	$new_array = "";
	foreach($ordered_keys as $field)
	{
		$new_array[$field] = isset($array_to_change[$field]) ? trim($array_to_change[$field]) : "";
	}
	return $new_array;
}
function getRequiredFieldsErrorMessages($post_names, $post_array)
{
	$error_message = "";
	foreach($post_names as $input)
	{
		if((!isset($post_array[$input]) || $post_array[$input] === ""))
		{
			$input_readable = strtolower(str_replace("_"," ",$input));
			$error_message .= ucfirst($input_readable) . " is a mandatory field, please enter a " . $input_readable . ".<br/>";
		}
	}
	return $error_message;
}
function getRequiredFieldErrorMessage($array_key, $post_array)
{
	$error_message = "";
	if((!isset($post_array[$array_key]) || $post_array[$array_key] === ""))
	{
		$input_readable = strtolower(str_replace("_"," ",$array_key));
		$error_message .= ucfirst($input_readable) . " is a mandatory field, please enter a " . $input_readable . ".<br/>";
	}
	return $error_message;
}
function getFieldSizeErrorMessage($array_key, $post_array, $max, $min = -1, $is_number = false)
{
	$error_message = "";
	if(isset($post_array[$array_key]))
	{
		$input_readable = strtolower(str_replace("_"," ",$array_key));
		
		if($is_number)
		{
			if($post_array[$array_key] < $min || $post_array[$array_key] > $max)
			{
				if($min == -1)
				{
					$error_message .= ucfirst($input_readable) . " is out of range, please ensure it is less than " . $max . " in value<br/>";
				}
				else
				{
					$error_message .= ucfirst($input_readable) . " is out of range, please ensure it is between " . $min . " and " . $max . " in value<br/>";
				}
			}
		}
		else
		{
			if(strlen($post_array[$array_key]) < $min || strlen($post_array[$array_key]) > $max)
			{
				if($min == -1)
				{
					$error_message .= ucfirst($input_readable) . " is out of range, please ensure it is less than " . $max . " characters in length<br/>";
				}
				else
				{
					$error_message .= ucfirst($input_readable) . " is out of range, please ensure it is between " . $min . " and " . $max . " characters in length<br/>";
				}
			}
		}
	}

	return $error_message;
}
function convertFormattedHeightToInches($formatted_height)
{
	$feet = substr($formatted_height, 0, strpos($formatted_height,"'"));
	$inches = substr($formatted_height, strpos($formatted_height,"'")+1, strpos($formatted_height,"\""));
	return ($feet*INCHES_IN_FOOT) + $inches;
}
function convertInchesToFormattedHeight($inches)
{
	$feet = floor($inches/INCHES_IN_FOOT);
	$inches = $inches - $feet*12;
	$formatted_height = $feet . "'" . $inches . "\"";
	return $formatted_height;
}
function displayCopyright()
{
	echo "&copy; " . date('Y');
}
function calculateAge($birth_date) 
{

	
	$numberdate1= str_replace("-","",$birth_date);    
	$numberdate2=  str_replace("-","",date("Y-m-d")); 
	$age = ($numberdate2-$numberdate1)/10000;

	
	return floor($age);
	
}
function generateSelect($values, $select_tag_name, $default_value,$includeFirstIndex=false)
{
	echo "<select name = '".$select_tag_name."'>";
	if($includeFirstIndex==true){
		echo '<option value='.DEFAULT_OPTION_VALUE.'>'.DEFAULT_OPTION_TEXT.'</option>';
	}
	foreach ($values as $value)
	{
		if($value == $default_value)
		{
			echo "<option selected=\"selected\">" . $value . "</option>";
		}
		else
		{
			echo "<option>" . $value . "</option>";
		}
	}
	echo "</select>";
}
function generateElementsInRows($type, $names='', $values='', $checked='')
{
	for($i = 0; $i < count($values); $i++)
	{
		switch($type)
		{
			case "checkbox":
				echo '<li>
					  <label class="control control--checkbox">' . $values[$i] . '
							<input type="checkbox" name="' . $names[$i] . '" checked="' . $checked . '"/>
							<div class="control__indicator"></div>
					  </label>
					  </li>';
			break;
			case "p":
				if($i == 0)
				{
					echo "<li>";
				}
				elseif($i % GENERATE_ELEMENT_ROW_SIZE == 0)
				{
					echo "</li><li>";
				}
				echo '<p>' . $values[$i] . ', </p>';
				
				if($i == count($values) - 1)
				{
					echo "</li>";
				}
			break;
		}
		
	}
}
function generateSelectInputRow($row_class, $title, $name, $values, $default_value,$includeFirstIndex=false,$simple=false)
{
	if($simple == false){
		echo '<div class="' . $row_class . '" >';
	}

	echo '<div><h2>' . $title . '</h2></div>';

		echo '<div>';

	generateSelect($values, $name, $default_value,$includeFirstIndex);
	echo '</div>';
	if($simple == false){
	  echo 	'</div>';		
	}
}
function generateSelectRangeInputRow($row_class, $title, $names, $values)
{
	echo '<div class="' . $row_class . '" >
		  <div><h2>' . $title . '</h2></div>
	      <div class="value_range">';
		  generateSelect($values, $names[0]);
		  echo '<p>&nbsp;to&nbsp;</p>';
		  generateSelect($values, $names[1]);
		  echo '</div>
		  </div>';
}
function buildDropdownOnArray($array,$title,$name,$post_val=-1,$class="",$simple=false,$includeFirstIndex=true){
	if($simple == false){
		echo "<div><h2> $title </h2></div>";
		echo "<div>";
	}

		echo "<select class=\"".$class."\" name = \"".$name."\">"; 
		if($includeFirstIndex==true){
			echo '<option value='.DEFAULT_OPTION_VALUE.'>'.DEFAULT_OPTION_TEXT.'</option>';
		}


		for($value = 0; $value<count($array);$value++){
			// take care of zero later as 2^0 = 1 zero is skipped
			//$squared = pow(2,$value);
			if($post_val == $squared)
			{
			 	echo "<option value=\"".$array[$value]."\" selected=\"selected\"> ".$array[$value]." </option>";
			}else{
				echo "<option value=\"".$squared."\"> ".$array[$value]." </option>";
			}
			
		} 
		echo "</select>";
		if ($simple == false){
			echo "</div>";
		}

}

function buildInputType($type,$title,$name="",$simple=false,$min=MIN_INPUT_RANGE,$max=MAX_INPUT_RANGE,$value=MIN_INPUT_VALUE,$readOnly=false)
{
	if($simple == false){
		echo '<div><h2>'.$title.'</h2></div>';
		echo '<div>';
	}

	if ($readOnly == true){
		echo "<input type='$type' name='$name' min='$min' max='$max' value='$value' readonly'>";
	} else {
		echo "<input type='$type' name='$name' min='$min' max='$max' value='$value'>";
	}

	if($simple == false){
		echo '</div>';
	}

}
function generateCheckboxInputRow($row_class, $title, $names, $values)
{
	echo '<div class="' . $row_class . '" >
	<div><h2>' . $title . '</h2></div>';
	if(is_array($names))
	{
	  echo '<div class="checkbox-grid"><ul>';
	  
	  for($i = 0; $i < count($names); $i++)
	  {
		echo '<li>
			  <label class="control control--checkbox">' . $values[$i] . '
					<input type="checkbox" name="' . $names[$i] . '"/>
					<div class="control__indicator"></div>
			  </label>
			  </li>';
	  }
	  echo '</ul></div>';
	}
	else
	{
		echo '
		  <label class="control control--checkbox">' . $values . '
			 <input type="checkbox" name="' . $names . '" checked="' . $checks . '"/>
			 <div class="control__indicator"></div>
		  </label>';
	}
	echo '</div>';
	
}
function generateNumberInputRangeRow($row_class, $title, $names, $values, $min_values=0, $max_values=100)
{
	echo '
	      <div class="' . $row_class . '" >
		  <div><h2>' . $title . '</h2></div>
		  <div class="value_range">
		  <h2>&nbsp; From &nbsp;</h2>
	      <input type="number" name="' . $names[0] . '" value="' . $values[0] . '" min="' . $min_values[0] . '" max="' . $max_values[0] . '" size="30" />
	      <h2>&nbsp; To &nbsp;</h2>
	      <input type="number" name="' . $names[1] .'" value="' . $values[1] . '" min="' . $min_values[1] . '" max="' . $max_values[1] . '"  size="30" />
	      </div>
		  </div>';
}
function generateNumberInputRow($row_class, $title, $names, $values, $min_value, $max_value)
{
	echo '<div class="' . $row_class . '" >
		  <div><h2>' . $title . '</h2></div>
		  <div><input type="number" name="' . $names . '" value="' . $values . '" size="30" /></div>
		  </div>';
}
function generateTextareaRow($row_class, $title, $name, $value, $is_read_only)
{
	echo '<div class = "' . $row_class . '">
		  <div><h2>' . $title . '</h2></div>';
	if($is_read_only)
	{
		echo '<textarea readonly="readonly" name="' . $name . '" rows="8" cols="30">' . $value . '</textarea>';
	}
	else
	{
		echo '<textarea name="' . $name . '" rows="8" cols="30">' . $value . '</textarea>';
	}
	echo '</div>';

}
function generateTextRow($row_class, $title, $values)
{
	echo '<div class = "' . $row_class . '">
		  <div><h2>' . $title . '</h2></div>';
	if(is_array($values))
	{
		echo "<div><ul>";
		generateElementsInRows("p", "", $values);
		echo "</ul></div>";
	}
	else
	{
		echo '<div><p>' . $values . '</p></div>';
	}
	echo '</div>';
}
function displayImage($user_id, $image_index)
{
	
	$image_directory = USER_IMAGES_DIRECTORY . $user_id . "/" . $user_id . "_" . $image_index . ".jpg";
	echo '<img src="' . $image_directory . "?random=" . time() . '" alt="No Image Available"/>';
}
function displayImagesFormatted($user_id, $img_cell_styling, $image_row_width = IMAGE_ROW_WIDTH, $hasOptions=true)
{
	$conn = db_connect();
	$results = pg_execute($conn, "count_images", array($user_id));
	$row = pg_fetch_row($results);
	
	//if the images don't have options, it's probably being used on the profile-display page, so don't redisplay the profile picture
	$counter_offset = $hasOptions ? 0 : 1; 

	if($row[0] > 0)
	{
		echo "<div class=\"img_row\">";
	}
	
	for($image_counter = 1 + $counter_offset; $image_counter < $row[0]+1; $image_counter++)
	{
		if(($image_counter-(1+$counter_offset)) % $image_row_width == 0)
		{
			//current image starts on the next row
			echo "
			</div>
			<div class=\"img_row\">";
		}
		
		echo "<div class=" . $img_cell_styling . ">";
		displayImage($user_id, $image_counter);

		if($hasOptions)
		{
			if($row[0] > 1 && $image_counter != 1)
			{
				echo "<input type=\"radio\" name=\"profile_image\" value=\"" . $image_counter . "\">Choose</input>";
			}
			echo "<input type=\"checkbox\" name=\"delete_image[]\" value=\"" . $image_counter . "\">Delete</input>";
		}

		echo "</div>";
	}

	if($row[0] > 0)
	{
		echo "</div>";
	}
}
function generateTextInputRow($row_class, $title, $value, $name, $size=30)
{
	echo '<div class = "' . $row_class . '">
		  <div><h2>' . $title . '</h2></div>
		  <div><input type="text" name="' . $name . '" value="' . $value . '" size="' . $size . '"/></div>
		  </div>';
}

function generateTextDateRow($row_class, $title, $value, $name, $size=30)
{
	echo '<div class = "' . $row_class . '">
		  <div><h2>' . $title . '</h2></div>
		  <div><input type="date" name="' . $name . '" value="' . $value . '" size="' . $size . '"/></div>
		  </div>';
}
function generatePasswordInputRow($row_class, $title, $value, $name, $size=30)
{
	echo '<div class = "' . $row_class . '">
		  <div><h2>' . $title . '</h2></div>
		  <div><input type="password" name="' . $name . '" value="' . $value . '" size="' . $size . '"/></div>
		  </div>';
}
// Gets height in feet and inches then returns value in array
function getHeightInFeetInches()
{
		$arrayVal =  array();
		// get MAX_FT and MAX_IN values from constants.php
		for($ft=4; $ft<=MAX_FT; $ft++){
			for($in=0; $in<MAX_IN; $in+=1){
				$arrayVal[]= "".$ft."'".$in."\"";
			}
		}
	return $arrayVal; // returns string ft and inces array
}
function getInchesFromDbVal($postVal,$arraySent){
	$val = $arraySent[pow($postVal,1/3)];

	$val = explode("'", $val);      // Create an array, split on '
	$feet = $val[0];                   // Feet is everything before ', so in [0]
	$inches = substr($val[1], 0, -1);  // Inches is [1]; Remove the " from the end
	
	$total = ($feet * MAX_IN) + $inches; 
	return $total;   
}

function convertAgeToDate( $years ){
	$date = date('Y-m-d', strtotime($years . ' years ago'));
	return $date;
	}

function check_dir($dir) 
{
  $handle = opendir($dir);
  while (false !== ($entry = readdir($handle))) 
  {
    if ($entry != "." && $entry != "..") 
	{
      return FALSE;
    }
  }
  return TRUE;
}
// from https://hugh.blog/2012/04/23/simple-way-to-generate-a-random-password-in-php/ creates random passwrod
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
	
function image_checkbox($user_id, $conn)
{
	$results = pg_execute($conn, "count_images", array($user_id));
	$row = pg_fetch_row($results);

	if($row[0] > 0)
	{
		echo "
			<div class=\"img_container\">
			<div class=\"img_row\">";
	}

	for($image_counter = 0; $image_counter < $row[0]; $image_counter++)
	{
		if($image_counter % IMAGE_ROW_WIDTH == 0)
		{
			//current image starts on the next row
			echo "
			</div>
			<div class=\"img_row\">";
		}
		
		echo "<div class=\"img_cell\">";
		displayImage($_SESSION['user_id'], $image_counter+1);
		echo "<input type=\"radio\" name=\"profile_image\">Choose</input>
			  <input type=\"checkbox\" name=\"box[]\" value=\"$image_counter\">Delete</input>";
		echo "</div>";
	}

	if($row[0] > 0)
	{
		echo "</div>
			  </div>";
	}
}

function countFolder($dir) 
{
    $get = (count(scandir($dir)) - 2);
        if ($get == -2) {
                $get = 0;
        }
        return $get;
}

function createResultProfile($entry,$first_name,$last_name,$city,$age,$self,$image_index, $is_interest=false, $is_highlighted=false){
	$additional_class = $is_interest ? "" : "go_middle";
	$additional_class .= $is_highlighted ? " highlight" : "";
	echo "<div class=\"profile_preview " . $additional_class . "\">";
	 displayImage($entry, $image_index);
	echo "
	<div>
	 <h2><a href=profile-display.php?user_id=".$entry.">".$first_name." ".$last_name." </a></h2>
		<div>
			<h2> ".calculateAge($age).","." </h2>
			<h2> ".getPropertyByValue('city',$city)." </h2>
		</div>
		<h2> ".$self."</h2>
	</div>
</div>";
}
// function to find item in multidimensional array
function in_array_r($item , $array){
	return preg_match('/"'.$item.'"/i' , json_encode($array));
}



?>