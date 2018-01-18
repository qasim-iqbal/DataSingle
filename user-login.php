<!--         
    Author: Group 09
    Filename: user-login.php			
    Date: 2017 - 09 - 29			
    Description: User login page, validates and checks username/password in the database. Then pulls associated records for it. 			
-->

<?php 
$title = "Data Single - Login";
include 'header.php'; 
?>


<?php //embed in a page with a two input box (named id and pass) form
$error = "";
$result = "";

if($_SERVER["REQUEST_METHOD"] == "GET")
{   //default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	$login = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : "";
	$password = "";
	$_POST = "";
	
}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// get id and password , then hash 
	$login = trim($_POST['id']);
	$password = trim($_POST['pass']);  
	$password = hash(HASH_TYPE, $password);
	
	// call db function 
	$conn = db_connect();
	
	// prepare
	
	// post equals pass
	$_POST['pass'] = $password;	
	
	// send off results 
	$results = pg_execute($conn,"login_query", $_POST);

	if(pg_num_rows($results))
	{ 		
		// update	
		$conn = db_connect();	
		
		//add required variables to the users session
	
		$_SESSION['user_id'] = $login;
		
		setcookie('user_id', $login, time()+COOKIE_USER_ID_EXPIRY_TIME);

		$row = pg_fetch_assoc($results);
		
		$_SESSION['user_type'] = $row['user_type'];
		
		if(isset($_SESSION['message']))
		{
			unset($_SESSION['message']);
		}
	
		$_SESSION['email_address'] = pg_fetch_result($results, 0, "email_address");
		$_SESSION['first_name'] = pg_fetch_result($results, 0, "first_name");
		$_SESSION['last_name'] = pg_fetch_result($results, 0, "last_name");
		$_SESSION['last_access'] = pg_fetch_result($results, 0, "last_access");
		$_SESSION['birth_date'] = pg_fetch_result($results, 0, "birth_date");
		$_SESSION['user_type'] = pg_fetch_result($results, 0, "user_type");


		
		// send off results 
		$results = pg_execute($conn, "login_update", array(date("Y-m-d"), $_POST['id']));
		
		if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == CLIENT)
		{
			//user has already created a profile, therefore grab his profile values and put it in the session
			$results = pg_query($conn, "SELECT * FROM profiles WHERE user_id = '" . $_SESSION['user_id'] . "'");
			$profile_arguments = pg_fetch_assoc($results, 0);
			$_SESSION = array_merge($_SESSION, $profile_arguments);
		}

		
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED.CLIENT)
		{
			$_SESSION['message'] = DISABLED_USER_AUP;
			header('Location: aup.php');
		}
		else
		{
			header('Location: user-dashboard.php');
			$password = "";
			$_POST['pass'] = "";		
		}
	}

	else
		{
			
			$results = pg_execute($conn, "user_query", array($_POST['id']));

			if(!pg_num_rows($results))
			{ 
				//user not found, empty $login to unstick it				
				echo "User " . "<b>$login</b>" . " was not found in the system, try again.";							
				$login = "";
				$password = "";
			}
					
			//user found but not password then empty password string
			else
			{
				echo " Password was incorrect.";				
				$password = "";
				$_POST['pass'] = "";
			}
			
		}
}
?>

<div class="container_row">
    <div class="welcomezone">
	<div class="profile_container">
        <div class="blueboldheading">
			<h1 class="centered_text">Please Login</h1>
		</div>
			<div class="profile_row">
			<h2>Enter your login ID and password to connect to this system.</h2>
			<h3><?php
						if(!empty($_SESSION['message']))
						{
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}
					?>
			</h3>
			</div>
				<hr/>
				<form class="profile_container" href="#" action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">

			<?php 
				generateTextInputRow("profile_row","Login ID: ",$login,"id");
				generatePasswordInputRow("profile_row","Password: ","","pass");
			?>
			<div class="profile_row extended_row">
				<div class="center_submit_button">
					<input type="submit" value="Login">
				</div>
			</div>

			</form>
		</div>
	</div>
</div>
			
<?php
	include "footer.php";
?>