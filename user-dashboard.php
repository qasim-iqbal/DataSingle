<!--         
    Author: Group 09
    Filename: user-dashboard.php			
    Date: 2017 - 09 - 18			
    Description: User dashboard page for the website, contains css and links			
-->

<?php 
$title = "Datasingle - Ideal Match Creation";
include 'header.php';

		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
		{
			header('Location: aup.php');
		}
?>

 <div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>
      <div class="container_row">

        <div class="welcomezone">
          <div class="blueboldheading centered_text">
            <h1>Welcome to the User-Dashboard page</h1>
			<?php
				if(!empty($_SESSION['message']))
				{
					echo "<p>" . $_SESSION['message'] . "</p>";
					unset($_SESSION['message']);
				}
			?>
            <p> <?php echo "Hello " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "! You last accessed the site on " . $_SESSION['last_access'] . ".";?> </p>
            </div>
            </div>
            </div>



<?php include 'footer.php' ?>