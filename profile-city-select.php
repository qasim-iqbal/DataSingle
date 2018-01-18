<!--         
    Author: Group 09
    Filename: profile-city-select.php			
    Date: 2017 - 09 - 18			
    Description: User register page for the website, contains css and links			
-->

<?php 
$title = "Datasingle - Image Map";
include 'header.php'
?>

<?php //embed in a page with a two input box (named id and pass) form
$error = "";
$result = "";
$checkbox_fields = array("city");
$profile_arguments="";

//boolean made here so I don't need to check for user_id repeatedly within the loops, or everytime when setting the values
if(isset($_SESSION['user_id'])){
	$can_save_search = isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && 
	$_SESSION['user_type'] == CLIENT || $_SESSION['user_type'] == ADMIN ? true : false;
}
else
{
	$can_save_search = false;
}


if($_SERVER["REQUEST_METHOD"] == "GET")

{   //default mode when the page loads the first time
	//can be used to make decisions and initialize variables

	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
	{
		header('Location: aup.php');
	}
	
	foreach($checkbox_fields as $field)
	{ 
		$profile_arguments[$field] = isset($_COOKIE[$field]) && $can_save_search ? $_COOKIE[$field] : "";

	}
}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{


		foreach($checkbox_fields as $field)
		{	
			$profile_arguments[$field] = isset($_POST[$field])?sumCheckBox($_POST[$field]): 0;
			
			if($can_save_search)
			{
				setcookie($field, $profile_arguments[$field], time()+COOKIE_SEARCH_EXPIRY_TIME);
			}
		}

		// Validation
		if($profile_arguments['city'] == NO_VALUE_FOUND){
			$error .= "Error! Atleast one city must be selected";
		  }
		// if(isset($_SESSION['user_id'])){
		// 	if($_SESSION['user_type'] != CLIENT){
		// 		$error.= "Error! Only complete users are allowed to search users.";
		// 		header('Location:profile-create.php');
		// 	}
		//}
		// else{
		// 	$error.="Error! Only complete users are allowed to search users";
		// 	header('Location:user-register.php');
		// }
		if($error == ""){

			header('Location:profile-search.php');
		}

}

?>

<form name="image_map" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<img id="image_map.jpg" src="images/image_map.jpg" border="0" width="760" height="488" orgWidth="760" orgHeight="488" usemap="#image_map" />
	<map name="image_map" id="map">
		<div class="welcomezone">
		<b> <?php echo $error; ?></b>
		</div>
		</hr>
		<br>Toggle All Cities<input type="checkbox"  id="city_toggle" onclick="cityToggleAll();" name="city[]" value="0">
		</br>
			<!-- city checkboxes -->
		<div class="profile_row extended_row">
			<?php buildCheckbox("city","","",true,$profile_arguments['city'],false);?>
		</div>
		<!-- Image map coordinations -->
		<area href="profile-search.php?city=32"	shape="poly" coords="282,1,300,54,300,81,308,126,319,148,339,149,372,153,404,144,429,133,448,119,458,85,465,56,477,36,480,9,480,2,389,0,326,0,456,0" style="outline:none;" target="_self"/>
		<area href="profile-search.php?city=64"	shape="poly" coords="210,178,310,153,336,194,348,238,372,291,257,290,233,244" style="outline:none;" target="_self"     />
		<area href="profile-search.php?city=1" shape="poly" coords="387,298,485,280,527,374,474,395,424,398,424,405,402,359" style="outline:none;" target="_self"     />
		<area href="profile-search.php?city=2" shape="poly" coords="254,301,373,297,412,404,382,414,340,411,310,419" style="outline:none;" target="_self"     />
		<area href="profile-search.php?city=4" shape="poly" coords="159,328,250,311,302,425,267,447,225,454,177,404" style="outline:none;" target="_self"     />
		<area  href="profile-search.php?city=8"	shape="poly" coords="25,383,79,344,150,335,166,360,170,409,194,424,213,456,178,470,144,470,118,480,74,460" style="outline:none;" target="_self"/>
		<area  href="profile-search.php?city=16"  shape="poly" coords="495,276,638,247,675,279,683,309,696,336,688,373,580,380,529,373" style="outline:none;" target="_self"     />
		
	</map>

		<!-- Submit Button-->
		<div class="profile_row extended_row">
		  <div class="search_submit_button">
			<input type="submit" name="submit" value="Submit Locations" href="#"/>
		  </div>
		</div>

</form>

<script language="javascript">
function myclick(selection)
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


function cityToggleAll()
{
	var isChecked = document.getElementById("city_toggle").checked;
	var city_checkboxes = document.getElementsByName("city[]");
	for (var i in city_checkboxes)
	{
		city_checkboxes[i].checked = isChecked;
	}		
}
</script>

<!-- End of File -->
<?php
	include "footer.php";
?>