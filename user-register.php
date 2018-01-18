<!--         
    Author: Group 09
    Filename: user-register.php			
    Date: 2017 - 09 - 18			
    Description: User register page for the website, contains css and links			
-->

<?php 
$title = "Datasingle - Ideal Match Creation";
include 'header.php'
?>
<div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>
<?php 
$error = "";
$result = "";
$results_insert="";


 

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
	{
		header('Location: aup.php');
	}

	$userid = "";
	$password = "";
	$usertype="";
	$confPass="";
	$firstName="";
	$lastName="";
	$email="";
	$birth_date="";
	$_POST = "";
	$age="";
}


else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$userid = trim($_POST['user_id']);
	$password = trim($_POST['passwd']);
	$usertype=INCOMPLETE.CLIENT;
	$confPass=trim($_POST['conf_passwd']);
	$firstName=trim($_POST['first_name']);
	$lastName=trim($_POST['last_name']);
	$email=trim($_POST['email_address']);
	$birth_date=trim($_POST['date_of_birth']);
	
	



//connects to the database 
$conn = db_connect();
	
$results = pg_execute($conn,"user_query", array($_POST['user_id']));

	

  
   
  

// Validation for user Login
	if(!isset($userid) || $userid == "")
		{
			//means the user did not enter anything
			$error .= "You did not enter a user id";
			$error .= "<br/>"; 
		}
	elseif(strlen($userid)< MINIMUM_ID_LENGTH || strlen($userid) > MAXIMUM_ID_LENGTH)
	{
		$error .= "user ID must be between ".MINIMUM_ID_LENGTH ." and ".MAXIMUM_ID_LENGTH ." characters long";
		$error .= "<br/>"; 


	}
	elseif(pg_num_rows($results))
		{ 
			$error .= "<em>". $userid . "</em> already exist! Please enter a new User ID";
			$error .= "<br/>"; 
			$loginid="";
		}

// Validation for user passwords
		if(!isset($password) || $password == "")
		{
			//means the user did not enter anything
			$error .= "You did not enter a password";
			$error .= "<br/>"; 
		}
		 elseif(strcmp($password, $confPass) !== 0)
		{
			$error .= "Your password and the confirm password do not match, please try again!";
			$error .= "<br/>"; 
			$password ="";
			$confPass ="";

		}
		elseif (strlen($password)< MINIMUM_PASSWORD_LENGTH || strlen($password) > MAXIMUM_PASSWORD_LENGTH)
	{
		$error .="Password must be between ". MINIMUM_PASSWORD_LENGTH . " characters and ". MAXIMUM_PASSWORD_LENGTH ." characters long";
		$error .= "<br/>"; 
	}

	//validatation for First and Last names

	if(!isset($firstName) || $firstName == "")
		{
			//means the user did not enter anything
			$error .= "You did not enter a first name!";
			$error .= "<br/>"; 
		}
		elseif (is_numeric($firstName)) 
		{
			$error .= "The first name can not be numbers";
			$error .= "<br/>"; 
			$error .="You entered: ".$firstName;
			$error .= "<br/>"; 
		}
		elseif (strlen($firstName) > MAX_NAME_LENGTH)
		{
			$error .="First name must be less than ". MAX_NAME_LENGTH . " characters.";
		$error .= "<br/>"; 
		}
		
	if(!isset($lastName) || $lastName == "")
		{
			//means the user did not enter anything
			$error .= "You did not enter a last name!";
			$error .= "<br/>"; 
		}
		elseif (strlen($lastName) > MAX_NAME_LENGTH)
		{
			$error .="Last name must be less than ". MAX_NAME_LENGTH . " characters.";
		$error .= "<br/>"; 
		}

		elseif (is_numeric($lastName)) 
		{
			$error .= "The last name can not be numbers";
			$error .= "<br/>"; 
			$error .="You entered: ".$lastName;
			$error .= "<br/>"; 
		}
		
	//email validation
	if(!isset($email) || $email == "")
		{
			//means the user did not enter anything
			$error .= "You did not enter an email address!";
			$error .= "<br/>"; 
		}
	
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$error .= "<em>". $email . "</em> is not a valid email address";
		$error .= "<br/>"; 
  		$email="";
	}	

	// age verification
   if(!isset($birth_date) || $birth_date=="")
   		{

   			$error .= "Please enter your date of birth";
   			$error .= "<br/>";

   		}

   	//calculate thier age with the current year minus the user's date of birth

	// if age is less than 18 give an error telling the user is too young to be on the site
	else if (calculateAge($birth_date) < $age = MINIMUM_AGE) 

	{
		$error .= "Sorry, you must be 18 and older to register!";
   			$error .= "<br/>";
	}

	
	
	
	// ==================Processing after the Input validation has been completed======================
if($error == "")
	{  
		
 	$password = hash(HASH_TYPE, $password); // hash the password 
	$today = date("Y-m-d");
	$results=pg_execute($conn,"login_insert",array($userid,$password,$usertype,$email,$firstName,$lastName,$birth_date,$today,$today));
		
		header("Location:user-login.php");
			$_SESSION['message'] = REGISTER_MESSAGE;		
		ob_flush();
		
	}
		

else
		{

		}	
	
	
	
	

	

}
?>


<div>
<hr/>


<h2 class="centered_text">Please register into our system</h2>
<h3 style="text-align:center;"> <?php echo "*All fields must be completed"; ?> </h3>
<h3 style="text-align:center;"><?php echo $error; ?></h3>

<form class="profile_container" action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" >

<?php
	generateTextInputRow("profile_row","User Id: ", $userid, "user_id");
	generatePasswordInputRow("profile_row","Password: ", $password, "passwd");
	generatePasswordInputRow("profile_row","Confirm Password: ", $confPass, "conf_passwd");
	generateTextInputRow("profile_row","First Name: ", $firstName, "first_name");
	generateTextInputRow("profile_row","Last Name: ", $lastName, "last_name");
	generateTextInputRow("profile_row","Email: ", $email, "email_address");
	generateTextDateRow("profile_row","Date of Birth: ", $birth_date, "date_of_birth");
	
?>

</div>

<div class ="profile_row centered_text">
	<ul>
		<li>
			<input  type="submit" value = "Register" />
			<input  type="reset" value = "Clear" />
		</li>
	</ul>
</div>

</form>

<?php
	include "footer.php";
?>