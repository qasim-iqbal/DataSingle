<!--         
    Author: Group 09
    Filename: profile-search-result.php			
    Date: 2017 - 09 - 18			
    Description: Search page for the website, contains css and links			
-->

<?php 
    $title= "Data Single - Search Results";
    include("header.php");


	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
	{
		header('Location: aup.php');
	}
	
	$current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;
	$row=array();
	$count="";
	if(!isset($_SESSION['user_id'])){
		header("Location:user-login.php");
	}elseif(isset($_SESSION['user_id'])&& $_SESSION['user_type'] == DISABLED.CLIENT){
		header("Location:index.php");
	}elseif(isset($_SESSION['user_id']) && $_SESSION['user_type'] == INCOMPLETE.CLIENT){
		header("Location:profile-create.php");
	}
	if($_SESSION['resultsarray'] !="")
	{
		$row=$_SESSION['resultsarray'];
	}

	$records = count($row);

?>
<div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>

<div class="container_row">
    <div class="welcomzone">
        <div class="blueboldheading centered_text">
            <h1> Matches Found: <?php echo $records; ?> </h1>
        </div>	


		<?php
		//starting_index: the profile record index to start displaying from on the current page
		//ending_index: the index of the last profile displayed on the current page
		//records: the total amount of profiles
		//MATCHES_PER_PAGE: how many profiles to display per page
		//current_page: the current page index
		if($records == ""){
			echo "No user found with that search criteria";
		} elseif($records == 1){
			header("Location:profile-display.php?user_id=".$row[0]['user_id']."");
		}
		else{
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
		
    </div>
<?php 
include("footer.php");?>