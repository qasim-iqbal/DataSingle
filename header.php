<!--         
    Author: Group 09
    Filename: header.php			
    Date: 2017 - 09 -18			
    Description: Header page for the website, contains css, globals, required files and links			
-->
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css" media="screen">
        @import url("css/webd3201.css");
        </style>

		<?php
			if(session_id() == "")
			{
				session_start();
			}
			
            require './includes/constants.php'; 
            require './includes/functions.php'; 
            require './includes/db.php';
			
			//global $conn;
            //ob_start();
        ?>
		
        <!--         
			Author: Group 09
			Filename: header.php			
			Date: 2017 - 09 -18			
			Description: Header page for the website ... will add description later			
		 -->
		<!-- Title header -->
         <title> <?php echo $title ?> </title>

    </head>
    <!-- Body Section -->
    <body>
        <div id="layout">
            <div id="header">
                <div id="logo">
                     <a href="#"> <img src="images/data_single_logo.png" alt ="Data single logo for page"/></a>
                </div>
                    </div>
                    <div id="body_container">
                <div id="body_container_inner">
                    <div id="menu">
                        <ul>
                        <li><a href="index.php">Home</a></li>
						<li><a href="profile-city-select.php">Profile Search</a></li>
                        
						<?php
							if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']))
							{
								if($_SESSION['user_type'] == INCOMPLETE.CLIENT)
								{
									echo '<li><a href="profile-create.php">Create Profile</a></li>';
								}
								else if($_SESSION['user_type'] == CLIENT)
								{
									echo '<li><a href="profile-display.php">Profile</a></li>';
									echo '<li><a href="profile-create.php">Edit Profile</a></li>';
									echo '<li><a href="profile-images.php">Upload Images</a></li>';	
									echo '<li><a href="interests.php">Interests</a></li>';
								}
								
								if($_SESSION['user_type'] == ADMIN)
								{
										
									echo '<li><a href="admin.php">Admin</a></li>';
									echo '<li><a href="disabled_users.php">Disabled Users</a></li>';
								}
								else
								{
									echo '<li><a href="user-dashboard.php">Dashboard</a></li>'; 
								}
								
								echo '<li><a href="user-password-change.php">Change Password</a></li>
									  <li><a href="user-update.php">Update user</a></li>								
									  <li><a href="user-logout.php">Logout</a></li>';
							}
							else
							{
								echo '<li><a href="user-register.php">Register</a></li>
									  <li><a href="user-login.php">Login</a></li>
									  <li><a href="user-password-request.php">Request Password</a></li>';
							}
						?>
                        
                        
                        </ul>
                    </div>     

                
                    
          

