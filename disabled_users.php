<!--         
    Author: Group 09
    Filename: user-admin.php            
    Date: 2017 - 09 - 18            
    Description: User admin page for the website, contains css and links            
-->

<?php 
$title = "Datasingle - Disabled Users";
include 'header.php';
if(!isset($_SESSION['user_id']))
{
    header("Location:user-login.php");
}
elseif(isset($_SESSION['user_id']) && $_SESSION['user_type'] != ADMIN)
{
    header("Location:index.php");
}

	$current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;
	$row=array();
	$count="";

?>
	
<div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>

<div class="container_row">
    <div class="welcomzone">

		<?php

			$sql="SELECT * FROM profiles,users where 1=1 AND users.user_id = profiles.user_id AND users.user_type = '".DISABLED.CLIENT."'ORDER BY users.last_access DESC LIMIT ".MAX_RECORDS."";			$results = pg_query($conn,$sql);
			$row = pg_fetch_all($results);
			$count=pg_num_rows($results);
			$val =pg_last_error($conn);
			$_SESSION['countresults']=$count;
			$_SESSION['resultsarray']=$row;

			if($_SESSION['resultsarray'] !="")
			{
				$row=$_SESSION['resultsarray'];
			}

			$records = count($row);
			
			if($records == "")
			{
				echo "No user found with that search criteria";
			} 
			else
			{
				createPagination($records, $current_page);
				
				//-1 because current_page starts at 1 while the records indexes start at 0
				$starting_index = ($current_page - ONE_PAGE) * MATCHES_PER_PAGE;
				
				if(($current_page)*MATCHES_PER_PAGE > $records)
				{
					$ending_index = $starting_index + ($records - $starting_index);
				}
				else
				{
					$ending_index = $starting_index + MATCHES_PER_PAGE;
				}
				
				for($i=$starting_index; $i < $ending_index;$i++)
				{
					$entry=$row[$i]['user_id'];
					$age=$row[$i]['birth_date'];
					$city=$row[$i]['city'];
					$first_name=$row[$i]['first_name'];
					$last_name=$row[$i]['last_name'];
					$self=$row[$i]['self_description'];
					$image_index=$row[$i]['images'];
					if (strlen($self) > MAX_DESCRIPTION_LENGTH)
					$self = substr($self, MIN_DESCRIPTION_LENGTH, MAX_DESCRIPTION_LENGTH) . '...';
					
					createResultProfile($entry,$first_name,$last_name,$city,$age,$self,$image_index);

				}
				createPagination($records, $current_page);
			}


		?>
        <div class="blueboldheading centered_text">
            <h1> Matches Found: <?php echo $records; ?> </h1>
        </div>	
		
		
    </div>




<?php include 'footer.php' ?>