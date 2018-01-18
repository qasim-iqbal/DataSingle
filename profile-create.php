<?php 
/*
Names: Qasim Iqbal, Nathan Williams, Jonathan Hermans, Karence Ma
Last Modified: Sept 28th 2017
File: profile-create.php
Desc: Create or edit your user profile on this page
*/

//****VARIABLES/CONSTANTS****//
$title = "Datasingle - Profile Creation";
$error = "";
$profile_arguments=[];
$fields = array("gender","gender_sought","city","images","match_description","ethnicity","marital_status","religion","education","language","political_view",
	"occupation","salary","headline","smoke","drink","have_kids","want_kids","self_description","excercise_frequency","hair_color","eye_color","body_type","looking_for","height_inches");
	
$content_title = "Create your profile";
$content_description = "Here you can create your profile. The entered information is what other users will see when they visit your profile.<br/> It's also used as search criteria for other users.";
$button_text = "Create";

define('PROFILE_INSERT_ERROR', 'Failed to execute profile_insert query');
define('PROFILE_UPDATE_ERROR', 'Failed to execute profile_update query');
//****END OF VARIABLES/CONSTANTS****//

include 'header.php'
?>
      <div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>
      <div class="container_row">
        <div class="welcomezone">
		
		<?php
		
		if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == CLIENT)
		{
			$content_title = "Update your profile";
			$content_description = "Here you can update your profile. The entered information is what other users will see when they visit your profile.<br/> It's also used as search criteria for other users.";
			$button_text = "Update";
		}
		
		if($_SERVER["REQUEST_METHOD"] == "GET")
		{
			if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
			{
				header('Location: aup.php');
			}

			if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == CLIENT)
			{
				//user has already created a profile, therefore grab his profile values to make the form sticky and ready to update
				$profile_arguments = getReorderedArray($_SESSION, $fields);
			}
			else
			{
				$profile_arguments = array_fill_keys($fields, null);
			}
		}
		else if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$error .= getRequiredFieldsErrorMessages(array("headline","self_description","match_description","gender","gender_sought","city"), $_POST);
			$error .= getFieldSizeErrorMessage("headline", $_POST, MAXIMUM_HEADLINE_LENGTH);
			$error .= getFieldSizeErrorMessage("self_description", $_POST, MAXIMUM_DESCRIPTION_LENGTH);
			$error .= getFieldSizeErrorMessage("match_description", $_POST, MAXIMUM_DESCRIPTION_LENGTH);
			
			$profile_arguments = getReorderedArray($_POST, $fields);
			
			if($error == "")
			{
				//no errors, so add variables which aren't inputs to the array and convert height to a suitable format
				$profile_arguments['images'] = 0;
				$profile_arguments['height_inches'] = convertFormattedHeightToInches($profile_arguments['height_inches']);
				$profile_arguments = array_merge(array('user_id' => $_SESSION['user_id']), $profile_arguments); //equivalent of using array_unshift for associative arrays
				
				//INSERT NEW USER
				if($_SESSION['user_type'] == INCOMPLETE.CLIENT)
				{
					$result = pg_execute($conn, 'profile_insert', $profile_arguments);
					
					if($result != false)
					{
						pg_query($conn, "UPDATE users SET user_type = '" . CLIENT . "' WHERE user_id = '" . $_SESSION['user_id'] . "'");
						
						$_SESSION = array_merge($_SESSION, $profile_arguments);
						
						if(isset($_SESSION['user_type'])){ unset($_SESSION['user_type']);}
						if(isset($_SESSION['message'])){ unset($_SESSION['message']);}
						
						$_SESSION['user_type'] = CLIENT;
						$_SESSION['message'] = PROFILE_CREATE_MESSAGE;
						
						header("Location:user-dashboard.php");
						ob_flush();
						
					}
					else
					{
						$error .= "<br/>" . PROFILE_INSERT_ERROR . "<br/>";
					}
					
				}
				//UPDATE EXISTING USER
				else if($_SESSION['user_type'] == CLIENT)
				{
					$result = pg_execute($conn, 'profile_update', $profile_arguments);
					
					$_SESSION = array_merge($_SESSION, $profile_arguments);
					
					$error = ($result == false) ? $error . "<br/>" . PROFILE_UPDATE_ERROR . "<br/>" : $error;
					
				}
			}

		}

		?>
			<div class="blueboldheading">
				<h1 class="centered_text"><?php echo $content_title ?></h1>
			</div>
			<p><?php echo $content_description ?></p>
		  <hr/>
		  
		  <p><?php echo $error?></p>
		  
		  <form class="profile_container" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
			<div class="left_side" >
				<hr/>
				<h2 class="profile_subtitle"> About You </h2>
				<hr/>
				<?php 
				buildRadio("gender","*Gender","profile_row",false,$profile_arguments['gender']);
				buildRadio("gender_sought","*Gender Sought", "profile_row", false, $profile_arguments['gender_sought']);
				buildDropdown("city", "City", "profile_row", false, $profile_arguments['city']);
				buildDropdown("looking_for", "Looking for", "profile_row", false, $profile_arguments['looking_for']);
				generateTextareaRow("profile_row","*Description of you", "self_description", $profile_arguments['self_description'], false);
				?>
				<br/>
				<br/>
				<hr/>
					<h2 class="profile_subtitle">Appearance</h2>
				<hr/>
				
				<?php 
				generateSelectInputRow("profile_row","Height", "height_inches", getHeightInFeetInches(), convertInchesToFormattedHeight($profile_arguments['height_inches']));
				buildDropdown("eye_color", "Eye Color", "profile_row", false, $profile_arguments['eye_color']);
				buildDropdown("hair_color", "Hair Color", "profile_row", false, $profile_arguments['hair_color']);
				buildDropdown("body_type", "Body Type", "profile_row", false, $profile_arguments['body_type']);
				?>
					
			</div>
			<div class="right_side">
			<hr/>
				<h2 class="profile_subtitle">Background/Values</h2>
				<hr/>
					<?php
					buildDropdown("ethnicity", "Ethnicity", "profile_row", false, $profile_arguments['ethnicity']);
					buildDropdown("marital_status", "Marital Status", "profile_row", false, $profile_arguments['marital_status']);
					buildDropdown("religion", "Religion", "profile_row", false, $profile_arguments['religion']);
					buildDropdown("education", "Education", "profile_row", false, $profile_arguments['education']);
					buildDropdown("language", "Language", "profile_row", false, $profile_arguments['language']);
					buildDropdown("political_view", "Political View", "profile_row", false, $profile_arguments['political_view']);
					buildDropdown("occupation", "Occupation", "profile_row", false, $profile_arguments['occupation']);
					buildDropdown("salary", "Salary", "profile_row", false, $profile_arguments['salary']);
					?>
			<hr/>
				<h2 class="profile_subtitle">Additional Details</h2>
			<hr/>
				
				<?php 
				generateTextInputRow("profile_row","*Headline", $profile_arguments['headline'], "headline"); 
				buildDropdown("excercise_frequency", "Excercise Frequency", "profile_row", false, $profile_arguments['excercise_frequency']);
				buildDropdown("smoke", "Smoke", "profile_row", false, $profile_arguments['smoke']);
				buildDropdown("drink", "Drink", "profile_row", false, $profile_arguments['drink']);
				buildDropdown("have_kids", "Have Kids", "profile_row", false, $profile_arguments['have_kids']);
				buildDropdown("want_kids", "Want Kids", "profile_row", false, $profile_arguments['want_kids']);
				generateTextareaRow("profile_row","*Description of your ideal match", "match_description", $profile_arguments['match_description'], false); 
				?>
				
			</div>

			<div><input class="center_submit_button" type="submit" value="<?php echo $button_text ?>"/></div>

		  </form>
        </div>
      </div>
<?php include 'footer.php' ?>
