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


if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
{
	header('Location: aup.php');
}

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] == DISABLED.CLIENT){
	header("Location:user-register.php");
}



if($_SERVER["REQUEST_METHOD"] == "GET")
{
	// *** previous code ****
	// $firstName=""; 
	// $lastName="";
	// $email="";
	$firstName=$_SESSION['first_name']; 
	$lastName=$_SESSION['last_name'];
	$email=$_SESSION['email_address'];

}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$firstName=trim($_POST['first_name']);
	$lastName=trim($_POST['last_name']);
    $email=trim($_POST['email_address']);
    $userid = $_SESSION['user_id'];
	
//connects to the database 
$conn = db_connect();
	
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
	
	// ==================Processing after the Input validation has been completed======================
if($error == "")
	{  
		
	$results=pg_execute($conn,"update_client",array($userid,$firstName,$lastName,$email));
        //user has already created a profile, therefore grab his profile values and put it in the session
        $results = pg_query($conn, "SELECT * FROM users WHERE user_id = '" . $userid . "'");
        $profile_arguments = pg_fetch_assoc($results, 0);
        $_SESSION = array_merge($_SESSION, $profile_arguments);
		header("Location:user-dashboard.php");
			$_SESSION['message'] = UPDATE_USER_MESSAGE;		
		ob_flush();
		
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
	generateTextInputRow("profile_row","First Name: ", $firstName, "first_name");
	generateTextInputRow("profile_row","Last Name: ", $lastName, "last_name");
	generateTextInputRow("profile_row","Email: ", $email, "email_address");

?>

</div>

<div class ="profile_row centered_text">
	<ul>
		<li>
			<input  type="submit" value = "Update" />
			<input  type="reset" value = "Clear" />
		</li>
	</ul>
</div>

</form>

<?php
	include "footer.php";
?>