<!--         
    Author: Group 09
    Filename: profile-display.php			
    Date: 2017 - 09 - 18			
    Description: Profile-display page for the website, contains css and links			
-->

<?php 
$title = "Datasingle - View Profile";


include 'header.php'; 
define("PROFILE_IMAGE_INDEX", 1);
define("GALLERY_ROW_WIDTH", 6);
if(isset($_GET))
$action = isset($_GET['user_id'])? $_SERVER['PHP_SELF'] . "?user_id=" . $_GET['user_id']: $_SERVER['PHP_SELF'];

?>

<form class="profile_container" action="<?php echo $action?>" method="POST" >


<?php
$profile = array();
$user_id = "";
$result_message="";
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
{
	header('Location: aup.php');
}

if (!isset($_SESSION['user_id'] ) || $_SESSION['user_type']==INCOMPLETE.CLIENT)
{
	header("Location:user-login.php");
}

//get the variable passed through the profile search results <a> tag href
if(isset($_POST['user_id']) && $_POST['user_id'] != "")
{
	$user_id = $_POST['user_id'];
}
else if(isset($_GET['user_id']) && $_GET['user_id'] != "")
{
	$user_id = $_GET['user_id'];
	
}
else
{
	//no GET variable is passed, assume the regular Profile link was clicked on the navbar,
	//there getting the logged on users info instead
	$user_id = $_SESSION['user_id'];
}

if(isset($user_id) && $user_id != "")
{
	//get the users profile information
	$results = pg_execute($conn,"profile_display", array($user_id));
	$profile = pg_fetch_assoc($results, 0);
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	if(isset($_POST['btn_enable']))
	{
		pg_execute($conn,"update_user_type",array($profile['user_id'],CLIENT));
		$result_message = "User has been Enabled";
	}
	if(isset($_POST['btn_disable']))
	{
		//$sql_disable = ' UPDATE users,offensives SET users.user_type= DISABLED.CLIENT offensives.status="CLOSED" FROM users JOIN offensives ON users.user_id = offensives.offender WHERE user_id=$1');
		pg_execute($conn,"update_offense_case",array($profile['user_id'],CLOSED));
		pg_execute($conn,"update_user_type",array($profile['user_id'],DISABLED.CLIENT));
		$result_message = "User has been disabled";
		
	}
	else if(isset($_POST['btn_interested']))
	{
		//sert", 'INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name,birth_date,enrol_date,last_access) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9)');
		$sql = "INSERT INTO interests(user_id, interest_id, interest_time) VALUES('" . $_SESSION['user_id'] . "', '" . $user_id . "', '" . date("Y-m-d", time()) . "')";
		$results = pg_query($conn, $sql);
		
		
		if($results != false)
		{
			$result_message = "You have shown interest in " . $user_id;
		}
		else
		{
			$result_message = "Error! Failed to shown interest in " . $user_id;
		}
	}
	else if(isset($_POST['btn_remove_interest']))
	{
		$sql = "DELETE FROM interests WHERE interest_id='" . $user_id . "' AND user_id='" . $_SESSION['user_id'] . "'";
		$results = pg_query($conn, $sql);
		
		if($results != false)
		{
			$result_message = "You are now uninterested in " . $user_id;
		}
		else
		{
			$result_message = "Error! Failed to remove interest in " . $user_id;
		}
	}
	else if(isset($_POST['btn_report']))
	{

		pg_execute($conn,"report_user",array($_SESSION['user_id'],$user_id,OPEN,date("Y-m-d")));
		echo "user reported";

	}
		
}

?>
<input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
      <!--<div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>-->
      <div class="container_row">
        <div class="welcomezone">
			
			<div class="profile_heading">
				<div class="img_cell_standalone">
					<?php displayImage($user_id, PROFILE_IMAGE_INDEX); ?>
				</div>
				<div>
					<h1 class="big_text"> <?php echo $profile['user_id']?> </h1>
				</div>
				<h2><?php echo $result_message; ?></h2>

				<?php 

				if($_SESSION['user_id'] == $profile['user_id'])// session id and userId passed from getArray
				{
					echo "<p> this is what your profile looks like to others </p></br>";
				}
				if($_SESSION['user_type'] == ADMIN)
				{
					echo "<input name = 'btn_disable' type='submit' value='Disable'></input>";
					$post_val = "";
	
					if( $profile['user_type'] == DISABLED.CLIENT)
					{
						echo "<input name='btn_enable' type='submit' value='Enable'></input>";
					}
				}
			
				$results = pg_query($conn, "SELECT interests.user_id, interests.interest_id, users.first_name,users.last_name,profiles.city,users.birth_date,profiles.self_description,profiles.images FROM interests join profiles on profiles.user_id = interests.interest_id join users on users.user_id = interests.interest_id WHERE interests.user_id = '" . $_SESSION['user_id'] . "'");
				$admirer_results = pg_query($conn, "SELECT interests.user_id, interests.interest_id, users.first_name,users.last_name,profiles.city,users.birth_date,profiles.self_description,profiles.images FROM interests join profiles on interests.user_id = profiles.user_id join users on interests.user_id = users.user_id WHERE interests.interest_id = '" . $_SESSION['user_id'] . "'");
				
				$interest = pg_fetch_all($results);
				if($interest == false)
				{
					$interest = array();
				}
				
				$interest_in_you = pg_fetch_all($admirer_results);
				if($interest_in_you == false)
				{
					$interest_in_you = array();
				}
				

				if(in_array($profile['user_id'], array_column($interest_in_you,'user_id')) && in_array($profile['user_id'], array_column($interest,'interest_id')))
				{ 
					if($_SERVER['REQUEST_METHOD'] == "GET")
					echo 'you both have mutual interest in each other';
				
					echo "<input name ='btn_remove_interest' type = 'submit' value = 'Remove Interest'></input>";
				}
				elseif(in_array($profile['user_id'], array_column($interest,'interest_id'))) 
				{
					if($_SERVER['REQUEST_METHOD'] == "GET")
					echo 'you are interested in this person';
				
					echo "<input name='btn_remove_interest' type = 'submit' value = 'Remove Interest'></input>";
				}
				elseif(in_array($profile['user_id'], array_column($interest_in_you,'user_id')))
				{ 
					if($_SERVER['REQUEST_METHOD'] == "GET")
					echo 'this person is interested in you';
				
					echo "<input name='btn_interested' type = 'submit' value = 'Add To Interested'></input>";
				}
				elseif($profile['user_id']!=$_SESSION['user_id'])
				{
					echo "<input name='btn_interested' type = 'submit' value = 'Add To Interested'></input>";
				}
				// ads remove button for all profile except your own
				if($profile['user_id']!=$_SESSION['user_id'] && $_SESSION['user_type'] != ADMIN)
				{
					$sql1 = "SELECT * FROM offensives WHERE reporter= '".$_SESSION['user_id']."'";
					$results = pg_query($conn,$sql1);
					$results1 = pg_fetch_all($results);
					if (is_array($results1))
					{
						if(!in_array($user_id, array_column($results1,'offender')))
						{
							echo "<input name='btn_report' type = 'submit' value = 'Report User'></input>";
						}
					}
					else
					{
						echo "<input name='btn_report' type = 'submit' value = 'Report User'></input>";

					}
					
					
				}

				
				?>

			</div>

			
			<?php displayImagesFormatted($user_id, "img_cell_gallery", GALLERY_ROW_WIDTH, false); ?>
			
		  <hr/>
			<div class="profile_container">
				<div class="left_side">
					<hr/>
					<h2 class="profile_subtitle"> <?php echo "About " .$profile['first_name']. " " .$profile['last_name']. " " ?> </h2>
					<hr/>
					<?php
						generateTextRow("profile_row","Age:",calculateAge($profile['birth_date']));
						generateTextRow("profile_row","Gender:", getProperty($conn,'gender',$profile['gender']));
						generateTextRow("profile_row","City:", getProperty($conn,'city',$profile['city']));
						generateTextRow("profile_row","Looking for:", getProperty($conn,'looking_for',$profile['looking_for']));
                        
						
						?>

						<hr/>
					<h2 class="profile_subtitle">Appearance</h2>
					<hr/>
					<?php
						generateTextRow("profile_row","Height:", convertInchesToFormattedHeight($profile['height_inches']));
						generateTextRow("profile_row","Eye Colour:",getProperty($conn,'eye_color',$profile['eye_color']));
						generateTextRow("profile_row","Hair Colour:",getProperty($conn,'hair_color',$profile['hair_color']));
						generateTextRow("profile_row","Body Type:", getProperty($conn,'body_type',$profile['body_type']));
						
					?>
						<hr/>
						<h2 class="profile_subtitle">Background/Values</h2>
						<hr/>
					<?php
						generateTextRow("profile_row","Ethnicity:", getProperty($conn,'ethnicity',$profile['ethnicity']));
						generateTextRow("profile_row","Marital Status:", getProperty($conn,'marital_status',$profile['marital_status']));
						generateTextRow("profile_row","Faith:", getProperty($conn,'religion',$profile['religion']));
						generateTextRow("profile_row","Highest level of Education:",getProperty($conn,'education',$profile['education']));
						generateTextRow("profile_row","Languages:", getProperty($conn,'language',$profile['language']));
						generateTextRow("profile_row","Political View:", getProperty($conn,'political_view',$profile['political_view']));
						generateTextRow("profile_row","Occupation:", getProperty($conn,'occupation',$profile['occupation']));
						generateTextRow("profile_row","Salary range:", getProperty($conn,'salary',$profile['salary']));
					?>
				</div>
				<div class="right_side">
				
					<hr/>
					<h2 class="profile_subtitle">Additional Details</h2>
					<hr/>
					<?php
						generateTextRow("profile_row","Exercise Frequency:", getProperty($conn,'excercise_frequency',$profile['excercise_frequency']));
						generateTextRow("profile_row","Smoke?", getProperty($conn,'smoke',$profile['smoke']));
						generateTextRow("profile_row","Drink?", getProperty($conn,'drink',$profile['drink']));
						generateTextRow("profile_row","Have kids?", getProperty($conn,'have_kids',$profile['have_kids']));
						generateTextRow("profile_row","Want kids?", getProperty($conn,'want_kids',$profile['want_kids']));
						generateTextareaRow("profile_row","*Description of you", "self_description", $profile['self_description'], true);
						generateTextareaRow("profile_row","*Description of your ideal match", "match_description", $profile['match_description'], true); 
					?>
				</div>
			</div>
        </div>
      </div>

      </form>
<?php include 'footer.php' ?>;
