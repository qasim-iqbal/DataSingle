<!--         
    Author: Group 09
    Filename: profile-images.php			
    Date: 2017 - 09 - 18			
    Description: User images webpage			
-->

<?php 
$title = "Datasingle - Upload Images";
include 'header.php';

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
	//DEBUGGING: print_r($_POST);
	if(isset($_POST['delete']))
	{
		$user_id = $_SESSION['user_id'];
		$target_dir = USER_IMAGES_DIRECTORY . $user_id . "/";
		$images_to_delete = $_POST['delete_image'];
		
		$results = pg_execute($conn, "count_images", array($_SESSION['user_id']));
		$row = pg_fetch_row($results);
		$new_image_count = $row[0];
		
		for($i=count($images_to_delete) - 1;$i>=0;$i--)
		{
			$fileNewName = $target_dir . $user_id . "_" . $images_to_delete[$i] . ".jpg";
			echo "<br>Deleted image " . $fileNewName;
			unlink($fileNewName);
			
			if($new_image_count > 1)
			{
				for($j=$images_to_delete[$i]+1;$j <= $new_image_count;$j++)
				{
					$old_file_name = $target_dir . $user_id . "_" . $j . ".jpg";
					if(file_exists($old_file_name))
					{
						$new_file_name = $target_dir . $user_id . "_" . ($j-1) . ".jpg";
						rename($old_file_name, $new_file_name);
					}
				}
			}
			
			$new_image_count = $row[0] - (count($images_to_delete) - $i);
			
		}
		
		$results = pg_execute($conn, "update_images", array($_SESSION['user_id'], $new_image_count));
		
		echo "<br>this is how many images there are in the database: " . $new_image_count;
		
		// need to check a second time after row is deleted 
		$files = array_slice(scandir($target_dir), 2);
		$results = pg_execute($conn, "count_images", array($_SESSION['user_id']));
		$row = pg_fetch_row($results);
		
		
		// while i is less than the number of images 
		//DEBUGGING:
		/*for($i=0;$i < $row[0];$i++)
		{

			echo "<br>This is the files array: " . $files[$i];
						
						
			// get last part of files
		}*/
		
		// remove directory if empty 
		$user_id = $_SESSION['user_id'];
		$target_dir = USER_IMAGES_DIRECTORY . $user_id;
		if (check_dir($target_dir)) 
		{
		  rmdir($target_dir); 
		}

	}
	else if(isset($_POST['profile_image']))
	{
		$profile_image = $_POST['profile_image'];
		$new_pic = USER_IMAGES_DIRECTORY . $_SESSION['user_id'] . "/" . $_SESSION['user_id'] . "_" . $profile_image . ".jpg";
		$old_pic = USER_IMAGES_DIRECTORY . $_SESSION['user_id'] . "/" . $_SESSION['user_id'] . "_1.jpg";
		$temp_old_pic = USER_IMAGES_DIRECTORY . $_SESSION['user_id'] . "/" . $_SESSION['user_id'] . "_temp.jpg";
		
		if(file_exists($new_pic) && file_exists($old_pic))
		{
			rename($old_pic, $temp_old_pic);
			rename($new_pic, $old_pic);
			rename($temp_old_pic, $new_pic);
		}
		else
		{
			echo "<br/>Error! Picture doesn't exist";
		}
		
	}

	if(isset($_POST['upload']))
	{
		//create a file array from the file that was submitted in post
		$file = $_FILES['userFile'];
		//DEBUGGING: print_r($file);
		//extract the file array, which can be done use print_r($file)
		$fileTmpname = $_FILES['userFile']['tmp_name'];
		
		// need a SQL count statement for image names that exist within the db 
		$results = pg_execute($conn, "count_images", array($_SESSION['user_id']));
		$row = pg_fetch_row($results);
		
			// check user id exists 
			if (!isset($_SESSION['user_id']))
			{
				$_SESSION['message'] = LOGIN_UPLOAD_MESSAGE;
				header('Location: user-login.php');
			}
			else
			{
				$user_id = $_SESSION['user_id'];

				echo "<br>This is your id: " . $user_id;
				
				// target directory is made 
				$target_dir = USER_IMAGES_DIRECTORY . $user_id . "/";
				
				// Check if directory exists, if not create it
				if (!file_exists($target_dir)) 
				{
					mkdir($target_dir, IMAGE_DIRECTORY_PERMISSIONS, true);
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

						if($fileError == UPLOAD_ERR_OK)
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
										echo "<br>You currently have " . strval($row[0] + 1) . " images uploaded!";
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

<script language="javascript">
function click_event(selection)
{
	if (document.getElementById(selection).checked == true) 
	{
		document.getElementById(selection).checked = false;
	} 
	else 
	{
		document.getElementById(selection).checked = true;
	}
}
</script>

<form id="uploadform" action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" enctype="multipart/form-data">


<div class="container_row">
    <div class="welcomezone">
		<input type="file" name="userFile" id="userFile">
	</div>
</div>

<div class="container_row">
    <div class="welcomezone">
		<input type="submit" value="Upload New Image" name="upload">
	</div>
</div>

<div class="container_row">
    <div class="welcomezone">
		<input type="submit" value="Delete Image" name="delete">
	</div>
</div>

<div class="container_row">
    <div class="welcomezone">
		<input type="submit" value="Set Profile Image" name="set_profile">
	</div>
</div>

<?php
displayImagesFormatted($_SESSION['user_id'], "img_cell");
?>
</form>

<?php	

include("footer.php");
?>

