<!--         
    Author: Group 09
    Filename: user-logout.php			
    Date: 2017 - 10 -12			
    Description: User logout page 			
-->

<?php
/*stuff to later */
include("header.php");
if(isset($_SESSION))
{
    session_unset();
    session_destroy();  //destroy session
}
session_start(); // start session
$_SESSION['message'] = LOGOUT_MESSAGE;
header('Location: user-login.php');
?>