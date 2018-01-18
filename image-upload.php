<!--         
    Author: Group 09
    Filename: image-upload.php			
    Date: 2017 - 09 - 18			
    Description: Image upload 			

	
-->

<?php 
$title = "Datasingle - Upload Images";
include 'header.php';
?>
<?php

	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{	
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
		{
			header('Location: aup.php');
		}
		// check if the user is logged in 
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == CLIENT || $_SESSION['user_type'])
		{
			$is_user = isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && 
			$_SESSION['user_type'] == CLIENT || $_SESSION['user_type'] == ADMIN ? true : false;	
		}
		else 
		{
			$_SESSION['message'] = LOGIN_UPLOAD_MESSAGE;
			header('Location: user-login.php');
		}
    } // end of get 
	
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	
		if(isset($_POST['submit']))
		{
			//create a file array from the file that was submitted in post
			$file = $_FILES['userFile'];
			print_r($file);
			//extract the file array, which can be done use print_r($file)
			$fileTmpname = $_FILES['userFile']['tmp_name'];
			
			// need a SQL count statement for image names that exist within the db 
			$results = pg_execute($conn, "count_images", array($_SESSION['user_id']));
			$row = pg_fetch_row($results);
			
				// check user id exists 
				if ($user_id = "")
				{
					echo "<br>Hi there, please login to upload images!";
				}
				else
				{
					$user_id = $_SESSION['user_id'];
					echo "<br>You currently have " . strval($row[0] + 1) . " images uploaded!";
					echo "<br>This is your id: " . $user_id;
					
					// target directory is made 
					$target_dir = USER_IMAGES_DIRECTORY . $user_id . "/";
					
					
					// Check if directory exists, if not create it
					if (!file_exists($target_dir)) 
					{
						mkdir($target_dir, 0777, true);
					}

					// file type 
					$fileType = $_FILES['userFile']['type'];
					$fileName = $_FILES['userFile']['name'];
					
					//to get the file extension, break up the file name with extentsion, where they are separating by the "."
					//you get two piece of information
					$fileExt = explode('.', $fileName);
					
					//gets the last piece of information which is the extension			
					$fileActualExt = strtolower(end($fileExt));
					
					//specify what files are allowed 
					$allowed = array('jpg', 'jpeg');

					
					if($row[0] >= MAXIMUM_PROFILE_IMAGES)
					{
						echo "<br>You have $row[0] which is more than the maximum number of allowed images (" . MAXIMUM_PROFILE_IMAGES . " total).";
					}
					else
					{
						if(in_array($fileActualExt, $allowed))
						{
							$fileError = $_FILES['userFile']['error'];

							if($fileError==0)
							{
								$fileSize = $_FILES['userFile']['size'];
								//check for file size, REMEMBER TO MAKE The NUMBER A CONSTANT
								if($fileSize < MAX_UPLOAD)
								{
										//give the file a new name, by giving it the userid followed by an increment number and 	lastly by the extension
										$user_id = $_SESSION['user_id'];
										$fileNewName = $target_dir . $user_id . "_" . strval($row[0] + 1) . ".jpg";
										
										$target_file = $target_dir . basename($_FILES["userFile"]["name"]); 
										echo "<br>This is the target directory " . $target_dir;
										
										if (file_exists($target_file)) 
										{
											echo "<br>Sorry, your image already exists.";
											echo $fileNewName;
										}
										elseif (move_uploaded_file($_FILES["userFile"]["tmp_name"], $target_file))
										{
											$total = $row[0] + 1;
											$results = pg_execute($conn, "update_images", array($_SESSION['user_id'], $total));
											rename($target_file, $fileNewName);
										}

								}
								else
								{ 
										echo "<br>File is too large!";
								}
							}
							else 
							{
								echo "<br>There was an error uploading your file";
							}
							
							// remove directory if empty 
							$user_id = $_SESSION['user_id'];
							$target_dir = USER_IMAGES_DIRECTORY . $user_id;
							if (check_dir($target_dir)) 
							{
							  rmdir($target_dir); 
							}
						}
						else
						{
							// remove directory if empty 
							$user_id = $_SESSION['user_id'];
							$target_dir = USER_IMAGES_DIRECTORY . $user_id;
							if (check_dir($target_dir)) 
							{
							  rmdir($target_dir); 
							}
							
							echo "<br>You can only upload jpg/jpeg files";
						}
						
						 
					} // end of user images max 
			} // end of image upload check 
		} // end of submit 		
	} // end of post 
	
	
?>

<?php
include("footer.php");
?>