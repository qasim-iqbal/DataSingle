<!--         
    Author: Group 09
    Filename: user-password-change.php			
    Date: 2017 - 09 -18			
    Description: Header page for the website, contains css, globals, required files and links			
-->

<?php
$title = "Datasingle - Change Password";
include("header.php");
$error = "";

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
{
	header('Location: aup.php');
}

if(isset($_SESSION['user_id']))
{
    header("Location: user-password-change.php");
	ob_flush();
} 

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    $email = "";
	$user_id = "";
    $new_password = "";
    $message = "";
}
else if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$email = isset($_POST['email_address']) ? trim($_POST['email_address']) : "";
	$user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : "";
    
    // Validation for user Login
	if(!isset($user_id) || $user_id == "") {
        //means the user did not enter anything
        $error .= "You did not enter a user id";
        $error .= "<br/>"; 
    } elseif(strlen($user_id)< MINIMUM_ID_LENGTH || strlen($user_id) > MAXIMUM_ID_LENGTH) {
        $error .= "user ID must be between ".MINIMUM_ID_LENGTH ." and ".MAXIMUM_ID_LENGTH ." characters long";
        $error .= "<br/>"; 
    }
    
    //email validation
    if(!isset($email) || $email == ""){
        //means the user did not enter anything
        $error .= "You did not enter an email address!";
        $error .= "<br/>"; 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error .= "<em>". $email . "</em> is not a valid email address";
		$error .= "<br/>"; 
  		$email ="";
    }	


    // check if user exists
    //connects to the database 
    $conn = db_connect();
    if($error == ""){
        $results = pg_execute($conn,"check_user", array($_POST['user_id'],$_POST['email_address']));
        if(!pg_num_rows($results)){
            $error.= "Error!, no user found with email <em><b> " . $email . "</b></em> and User Id <em><b> ".$user_id." </b></em>";
            $email = "";
            $user_id = "";
        }
    }
    
	if($error == "")
	{
        // generate new password
        $new_password = random_password(MAXIMUM_PASSWORD_LENGTH);
        
        $new_password = hash(HASH_TYPE, $new_password); // hash the password 
        $results=pg_execute($conn,"password_update",array($new_password,$user_id));
        
        $user_result = pg_execute($conn,"user_query",array($user_id));
        $user_row = pg_fetch_assoc($user_result);
        $first_name = $user_row['first_name'];
        
        $date_time = date('Y-m-d H:i:s');

        $mail_to =$email;
        $mail_subject = "Password Update";
        $mail_body = "<html>
                            <body>
                                <div id=\"logo\">
                                <a href=\"#\"> <img src=\"images/data_single_logo.png\" alt =\"Data single logo for page\"/></a>
                                </div>
                                <p> Hello ".$first_name."!<p>
                                <p> we had just recieved password reset request on <b> ".$date_time."</b></p>
                                <p> Here is your temporary password <em> <b>".$new_password."</b></em></p></p>
                                <p> click on the link below to log back on to Data Single</p>
                                <p> <url>".DATA_SINGLE_LOGIN_URL."</url></p>
                                <p> Don't Forget to update your password </p>
                                <p> Than you </p>
                                <p> ".WEBSITE_NAME." </p>
                            </body>
                        </html>";
        $mail_header = WEBSITE_EMAIL;
            // **** Mail function commented out ****//

        // if(mail($mail_to, $mail_subject, $mail_body,$mail_header)){
        $message= "E-mail \"$mail_subject\" to $mail_to was accepted for sending.";

        if(isset($_SESSION['message']))
		{
			unset($_SESSION['message']);
        }
        
        $_SESSION['message']= $message;
        header('Location: user-login.php');
        // }
        // else
        // echo "E-mail \"$mail_subject\" to $mail_to was not accepted for sending.";

		ob_flush();
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
            <h2><?php echo $message ?></h2>
			</div>
				<hr/>
				<form class="profile_container" href="#" action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">
					
			<?php
                generateTextInputRow("profile_row","User Id: ", $user_id, "user_id");
                generateTextInputRow("profile_row","Email: ", $email, "email_address");

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
