<!--         
    Author: Group 09
    Filename: index.php			
    Date: 2017 - 09 - 18			
    Description: Index page for the website, contains css and links			
-->

<?php 
    $title="Data Single - Home Page";
    include("header.php");

	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
	{
		header('Location: aup.php');
	}
?>

        <div class="banner"> <a href="#"><img src="images/banner.gif" alt="Page banner" /></a> </div>
        <div class="find_more">
        <p>Find New Partners, Experience Romance &amp; Find Love!<br />
          <span><a href="#">Register Now</a> and this is a fake dating website used for a school project.</span></p>
      </div>
        <div class="container_row">
        <div class="column_partner">
          <h2>Search New Partner</h2>
          <div class="form_container">
            <form action="#" method="get">
              <fieldset>
              <div class="search_row">
                <div class="search_column_1">
                  <label>I am </label>
                </div>
                <div class="search_column_2">

                    <?php buildDropdown("gender", "I am","gender",true,-1,true);?>
                    <label> Seeking </label>
                    <?php buildDropdown("gender_sought", "I am","gender",true,-1,true);?>
                </div>
              </div>
                
              <div class="search_row">
                <div class="search_column_1">
                    <label>Looking for </label>
                </div>
                <div class="search_column_2">
                  <?php buildDropdown("looking_for","Looking For","date",true,-1,true);?>
                </div>
              </div>
              <div class="search_row">
                <div class="search_column_1">
                  <label>Desired Age</label>
                </div>
                <div class="search_column_2">
                  <label> From </label>

                  <?php buildInputType("number","From","age_from",true,MIN_USER_AGE,MAX_USER_AGE,MIN_USER_AGE); ?>
                  <label> To </label>
                  <?php buildInputType("number","To","age_to",true,MIN_USER_AGE,MAX_USER_AGE,MIN_USER_AGE); ?>
                </div>
              </div>
              <div class="search_row">
                <div class="search_column_1">
                  <label>Desired City</label>
                </div>
                <div class="search_column_2">
                <?php buildDropdown("city","Desired City","date",true,-1,true);?>
                </div>
              </div>
              <div class="search_row">
                <div class="search_column_1">
                  <label>By Profile ID</label>
                </div>
                <div class="search_column_2">
                  <input type="text" name="" value="" />
                  <label class="check">With Photo</label>
                  <input type="checkbox" name="" value="" class="checkbox"/>
                </div>
              </div>
              </fieldset>
            </form>
          </div>
          <div class="bottom_curve">
            <p><img src="images/icon_2.gif" alt="" /><a href="#">search now</a></p>
          </div>
        </div>
        <div class="column_profile">
          <h2>New Posted Profile</h2>
          <div class="detail">
            <div class="row">
              <p class="left">Name :</p>
              <p class="right">Jenifer</p>
            </div>
            <div class="row_1">
              <p class="left">Age :</p>
              <p class="right">21 Years</p>
            </div>
            <div class="row">
              <p class="left">City :</p>
              <p class="right">London, UK</p>
            </div>
            <div class="row_1">
              <p class="left">humor :</p>
              <p class="right">clever/ quick witted</p>
            </div>
            <div class="row">
              <p class="left">living :</p>
              <p class="right">with parents</p>
            </div>
            <div class="row_1">
              <p class="left">email :</p>
              <p class="right">jlo89pop@soulmate.com</p>
            </div>
          </div>
          <div class="bottom_curve">
            <p><img src="images/icon.gif" alt="" /><a href="#">more profiles</a></p>
          </div>
        </div>
        <div class="column_photo">
          <h2>Recently Added Photos</h2>
          <div class="gallery">
            <div class="photo_row"> <a href="#"><img src="images/pic_1.gif" alt="" /></a> <a href="#"><img src="images/pic_2.gif" alt="" /></a> <a href="#"><img src="images/pic_3.gif" alt="" /></a> </div>
            <div class="photo_row"> <a href="#"><img src="images/pic_4.gif" alt="" /></a> <a href="#"><img src="images/pic_5.gif" alt="" /></a> <a href="#"><img src="images/pic_6.gif" alt="" /></a> </div>
          </div>
          <div class="bottom_curve">
            <p><img src="images/icon_3.gif" alt="" /><a href="#">more photo</a></p>
          </div>
        </div>
      </div>

?>
    <?php include 'footer.php'?>