<!--         
    Author: Group 09
    Filename: user-password-change.php			
    Date: 2017 - 09 -18			
    Description: Header page for the website, contains css, globals, required files and links			
-->

<?php
$title = "Datasingle - Change Password";
include("header.php");
$login = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "No user found";
$error = "";

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
{
	header('Location: aup.php');
}

if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == "")
{
	header("Location: user-login.php");
	ob_flush();
}

if($_SERVER['REQUEST_METHOD'] == "GET")
{
	$old_password = "";
	$new_password = "";
	$confirm_password = "";
}
else if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$old_password = isset($_POST['old_password']) ? $_POST['old_password'] : "";
	$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : "";
	$confirm_password = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : "";
	
	$error .= getRequiredFieldsErrorMessages(array("old_password","new_password","confirm_new_password"), $_POST);
	$error .= getFieldSizeErrorMessage("old_password",$_POST, MAXIMUM_PASSWORD_LENGTH, MINIMUM_PASSWORD_LENGTH);
	$error .= getFieldSizeErrorMessage("new_password",$_POST, MAXIMUM_PASSWORD_LENGTH, MINIMUM_PASSWORD_LENGTH);
	$error .= getFieldSizeErrorMessage("confirm_new_password",$_POST, MAXIMUM_PASSWORD_LENGTH, MINIMUM_PASSWORD_LENGTH);
	
	if(strcmp($new_password, $confirm_password) !== 0)
	{
		$error .= "Your new password and the confirm password do not match, please try again!";
		$error .= "<br/>"; 
		$new_password = "";
		$confirm_password = "";
	}
	
	if($error == "")
	{
		
		$results = pg_execute($conn, "login_query", array($_SESSION['user_id'], hash('md5',$old_password)));
		
		if(pg_num_rows($results) == 0)
		{
			//old password does not match an existing user
			$error .= "Entered old password is incorrect";
		}
		else
		{
			//old password matches a user
			
			$results = pg_execute($conn, "password_update", array(hash('md5', $new_password), $_SESSION['user_id']));
			
			if($results != false)
			{
				
				if(isset($_SESSION['message'])){ unset($_SESSION['message']); }
				
				$_SESSION['message'] = "Your password has been updated successfully";
				header("Location: user-dashboard.php");
				
			}
		}
		
	}
}

?>


<div class="container_row">
    <div class="welcomezone">
	<div class="profile_container">
        <div class="blueboldheading">
			<h1 class="centered_text">Change your password</h1>
		</div>
			<div class="profile_row">
			<h2>Enter your login ID to receive a new password.</h2>
			<h2><?php echo $error ?></h2>
			</div>
				<hr/>
				<form class="profile_container" href="#" action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">
					<div class="profile_row">
						<div><h2>User ID: </h2></div>
						<div>
							<label><?php echo $login ?></label>
						</div>
					</div>
			<?php
				generatePasswordInputRow("profile_row","Old Password: ",$old_password,"old_password");
				generatePasswordInputRow("profile_row","New Password: ",$new_password,"new_password");
				generatePasswordInputRow("profile_row","Confirm New Password: ",$confirm_password,"confirm_new_password");
			?>
			<div class="profile_row extended_row">
				<div class="center_submit_button">
					<input type="submit" value="Change Password">
				</div>
			</div>

			</form>
		</div>
	</div>
</div>

<?php
include("footer.php");
?>
