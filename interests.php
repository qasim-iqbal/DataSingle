<!--         
    Author: Group 09
    Filename: interests.php            
    Date: 2018 - 01 - 08            
    Description:           
-->

<?php 
$title = "Datasingle - Interests";
include 'header.php';

$current_interest_page = isset($_GET['current_interest_page']) ? $_GET['current_interest_page'] : 1;
$current_admirers_page = isset($_GET['current_admirers_page']) ? $_GET['current_admirers_page'] : 1;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	//concatenate together a sql statement to delete the selected interests
	$sql = isset($_POST['delete_interest']) ? "(user_id = '" . $_SESSION['user_id'] . "' AND interest_id IN ('" . implode("', '",$_POST['delete_interest']). "'))" : "";
	$sql .= $sql != "" && isset($_POST['delete_others_interest']) ? " OR " : "";
	$sql .= isset($_POST['delete_others_interest']) ? "(interest_id = '" . $_SESSION['user_id'] . "' AND user_id IN ('" . implode("', '",$_POST['delete_others_interest']) . "'))" : "";
	
	if(isset($_POST['delete_interest']) || isset($_POST['delete_others_interest']))
	{
		//delete the selected interests
		$results = pg_query($conn, "DELETE FROM interests WHERE " . $sql);
	}
	else
	{
		//no interests are selected, but the user has tried to delete some, display an error
		$error = "You have selected no interests to delete.";
	}

}

//get all the users who you are interested in
$results = pg_query($conn, "SELECT interests.user_id, interests.interest_id, users.first_name,users.last_name,profiles.city,users.birth_date,profiles.self_description,
profiles.images FROM interests join profiles on profiles.user_id = interests.interest_id join users on users.user_id = interests.interest_id WHERE interests.user_id = '" . $_SESSION['user_id'] . "'");

//get all the users who are interested in you
$admirer_results = pg_query($conn, "SELECT interests.user_id, interests.interest_id, users.first_name,users.last_name,profiles.city,users.birth_date,profiles.self_description,
profiles.images FROM interests join profiles on interests.user_id = profiles.user_id join users on interests.user_id = users.user_id WHERE interests.interest_id = '" . $_SESSION['user_id'] . "'");

//made in order to reduce use of count() function
$interest_count = 0;
$interest_in_you_count = 0;

$error = "";

//get query results
$interest = pg_fetch_all($results);
if($interest == false)
{
	$interest = array();
}
else
{
	$interest_count = count($interest);
}

//get query results
$interest_in_you = pg_fetch_all($admirer_results);
if($interest_in_you == false)
{
	$interest_in_you = array();
}
else
{
	$interest_in_you_count = count($interest_in_you);
}

//find all the mutual interests and add an additional field saying if it's mutual or not
for($i=0;$i<$interest_count;$i++)
{
	for($j=0;$j<$interest_in_you_count;$j++)
	{
		if($interest[$i]['interest_id'] == $interest_in_you[$j]['user_id'] && $interest_in_you[$j]['interest_id'] == $interest[$i]['user_id'])
		{
			//mutual interest
			$interest[$i]['is_mutual'] = true;
			$interest_in_you[$j]['is_mutual'] = true;
		}
	}
}

?>

<div class="banner"><a href="#"><img src="images/banner_1.gif" alt="" /></a></div>
<div class="container_row">
	<div class="welcomezone">
		<div class="blueboldheading centered_text">
			<h1>Match Interests</h1>
		</div>
	</div>
	<h2><?php echo $error; ?></h2>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div class="profile_container">
			<div class="left_side">
				<hr/>
				<h2 class="profile_subtitle">Interests</h2>
				<hr/>
					<?php
					
					createPagination($interest_count, $current_interest_page, "interests.php?current_admirers_page=" . $current_admirers_page . "&current_interest_page=", MATCHES_PER_PAGE);
					if($interest_count == 0)
					{
						echo "You aren't interested in anyone currently";
					}
					else
					{
						$starting_index = ($current_interest_page - ONE_PAGE) * MATCHES_PER_PAGE;
		
						if(($current_interest_page)*MATCHES_PER_PAGE > $interest_count)
						{
							$ending_index = $starting_index + ($interest_count - $starting_index);
						}
						else
						{
							$ending_index = $starting_index + MATCHES_PER_PAGE;
						}
						
						//get all profiles of those you've shown interest in
						for($i=$starting_index;$i<$ending_index;$i++)
						{
							createResultProfile($interest[$i]['interest_id'], $interest[$i]['first_name'], $interest[$i]['last_name'], $interest[$i]['city'], $interest[$i]['birth_date'], $interest[$i]['self_description'], $interest[$i]['images'], true, array_key_exists('is_mutual',$interest[$i]));
							echo "<input type=\"checkbox\" name=\"delete_interest[]\" value=\"" . $interest[$i]['interest_id'] . "\">Delete</input>";
						}
					}
					createPagination($interest_count, $current_interest_page, "interests.php?current_admirers_page=" . $current_admirers_page . "&current_interest_page=", MATCHES_PER_PAGE);
					?>
			</div>
			<div class="right_side">
				<hr/>
				<h2 class="profile_subtitle">Admirers</h2>
				<hr/>
					<?php
					createPagination($interest_in_you_count, $current_admirers_page, "interests.php?current_interest_page=" . $current_interest_page . "&current_admirers_page=", MATCHES_PER_PAGE);
					if($interest_in_you_count == 0)
					{
						echo "Nobody is currently interested in you.";
					}
					else
					{
						$starting_index = ($current_admirers_page - ONE_PAGE) * MATCHES_PER_PAGE;
		
						if(($current_admirers_page)*MATCHES_PER_PAGE > $interest_in_you_count)
						{
							$ending_index = $starting_index + ($interest_in_you_count - $starting_index);
						}
						else
						{
							$ending_index = $starting_index + MATCHES_PER_PAGE;
						}
						
						//get all profiles of users who are interested in you
						for($i=$starting_index;$i<$ending_index;$i++)
						{
							createResultProfile($interest_in_you[$i]['user_id'], $interest_in_you[$i]['first_name'], $interest_in_you[$i]['last_name'], $interest_in_you[$i]['city'], $interest_in_you[$i]['birth_date'], $interest_in_you[$i]['self_description'], $interest_in_you[$i]['images'], true, array_key_exists('is_mutual',$interest_in_you[$i]));
							echo "<input type=\"checkbox\" name=\"delete_others_interest[]\" value=\"" . $interest_in_you[$i]['user_id'] . "\">Delete</input>";
						}
					}
					createPagination($interest_in_you_count, $current_admirers_page, "interests.php??current_interest_page=" . $current_interest_page . "&current_admirers_page=", MATCHES_PER_PAGE);
					?>
			</div>
		</div>
		<?php 
		if($interest_count != 0 || $interest_in_you_count != 0)
		echo '<input class="center_submit_button" type="submit" value="Delete Interests">'
		?>
	</form>
</div>

<?php include 'footer.php' ?>