<!--         
    Author: Group 09
    Filename: profile-search.php      
    Date: 2017 - 09 - 18      
    Description: Profile-search page for the website, contains css and links      
-->

<?php
  
    $title="Data Single - Discover";
    include("header.php");

  if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
  {
    header('Location: aup.php');
  }


    $error="";
    $profile_arguments="";
    $search_arguments=""; 
    $checkbox_fields = array("looking_for","eye_color","hair_color",
                    "body_type","marital_status","ethnicity","religion",
                    "education","smoke","excercise_frequency","salary");

    $dropDown_fields = array("gender","gender_sought","height_from","height_to",);
    $inputtype_fields = array("age_from","age_to");
  
  //boolean made here so I don't need to check for user_id repeatedly within the loops, or everytime when setting the values
  $can_save_search = isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && 
  $_SESSION['user_type'] == CLIENT || $_SESSION['user_type'] == ADMIN ? true : false;

  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
  if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "" && $_SESSION['user_type'] == DISABLED)
  {
    header('Location: aup.php');
  }

    foreach($checkbox_fields as $field)
    { 
      $profile_arguments[$field] = isset($_COOKIE[$field]) && $can_save_search ? $_COOKIE[$field] : "";
    }
    foreach($dropDown_fields as $field)
    { 
      $profile_arguments[$field] = isset($_COOKIE[$field]) && $can_save_search ? $_COOKIE[$field] : "";
    }
    foreach($inputtype_fields as $field)
    { 
      $profile_arguments[$field] = isset($_COOKIE[$field]) && $can_save_search ? $_COOKIE[$field] : "";
    }
     if (count($_GET) > NO_VALUE_FOUND ){
       if($_GET['city'] !=""){
        $profile_arguments['city'] = $_GET['city'];
        setcookie('city', $_GET['city'], time()+COOKIE_SEARCH_EXPIRY_TIME);
        $_COOKIE['city'] = $_GET['city']; // for immediate access of cookie
       }

     }

    }
  else if($_SERVER["REQUEST_METHOD"] == "POST")
  {

  $city_array = array();
    
  $sql = "SELECT * FROM city";

  $result = pg_query($conn, $sql);
  while ($row = pg_fetch_assoc($result)) {
    if($_COOKIE['city'] & intval($row['value']))
    {
      array_push($city_array, $row['value']);
    }
  }  
  
  $profile_arguments['city'] = $city_array;
  $_POST['city']=$city_array; 
  
    foreach($checkbox_fields as $field)
    {

      $profile_arguments[$field] = isset($_POST[$field])?sumCheckBox($_POST[$field]): 0;
      
      if($can_save_search)
      {
        setcookie($field, $profile_arguments[$field], time()+COOKIE_SEARCH_EXPIRY_TIME);
      }
      
    }
    
    foreach($dropDown_fields as $field)
    {
      $profile_arguments[$field] = isset($_POST[$field])?trim($_POST[$field]) : "";
      
      if($can_save_search)
      {
        setcookie($field, $profile_arguments[$field], time()+COOKIE_SEARCH_EXPIRY_TIME);
      }
      
    }
    foreach($inputtype_fields as $field)
    {
      $profile_arguments[$field] = isset($_POST[$field])?trim($_POST[$field]) : "";
      
      if($can_save_search)
      {
        setcookie($field, $profile_arguments[$field], time()+COOKIE_SEARCH_EXPIRY_TIME);
      }
      
    }
      if ($profile_arguments['height_from']!=DEFAULT_OPTION_VALUE && $profile_arguments['height_to']==DEFAULT_OPTION_VALUE) {
        $error .= "Error! Height range must be selected From and To";
      } elseif ($profile_arguments['height_from']==DEFAULT_OPTION_VALUE && $profile_arguments['height_to']!=DEFAULT_OPTION_VALUE) {
        $error .= "Error! Height To must be selected </br>";
      } else {
        $profile_arguments['height_from'] = convertFormattedHeightToInches($profile_arguments['height_from']);
        $profile_arguments['height_to'] = convertFormattedHeightToInches($profile_arguments['height_to']);
      }

      // Validation
      if($profile_arguments['gender'] ==""){
        $error .= "Error! Gender must be selected</br>";
      }
      if( $profile_arguments['gender_sought'] ==""){
        $error .= "Error! Gender seeking must be selected</br>";
      }

      if($profile_arguments['age_from'] > $profile_arguments['age_to']) {
        //means the user did not enter anything
        switchValues($profile_arguments['age_from'],$profile_arguments['age_to']);
      }
      if($profile_arguments['height_from'] > $profile_arguments['height_to']) {
        //means the user did not enter anything
        switchValues($profile_arguments['height_from'] ,$profile_arguments['height_to']);
      }

      if($error == ""){
        $sql = 'SELECT * FROM profiles,users where 1=1 AND (gender = '.$_POST['gender_sought'].') AND (gender_sought = '.$_POST['gender'].') ';

        if($profile_arguments['height_from']!=0 && $profile_arguments['height_to']!=0)
        {
          $sql.= "AND (height_inches >= ".$profile_arguments['height_from']." AND height_inches <= ".$profile_arguments['height_to'].")";
        }


        $to = convertAgeToDate($profile_arguments['age_from']);
        $from   = convertAgeToDate($profile_arguments['age_to']);

        if($profile_arguments['age_from']>= MIN_USER_AGE && $profile_arguments['age_to']<= MAX_USER_AGE){
          $sql .= "AND (users.birth_date >= DATE '$from' AND users.birth_date <= DATE '$to')";
        }
        
        $SkipPostsKeys = array("height_from","height_to","age_from","age_to","gender","gender_sought");
        $city_array = array();
   
        $sqle = "SELECT * FROM city";
       
        $result = pg_query($conn, $sqle);
        while ($row = pg_fetch_assoc($result)) {
         if($_COOKIE['city'] & intval($row['value']))
         {
          array_push($city_array, $row['value']);
         }
        }  
        
        foreach($_POST as $key => $val){
          if(!in_array($key,$SkipPostsKeys)){
            if(is_array($val)){
              if($val != 0){
              $sql.=" AND ($key = $val[0]";
              for($v=1; $v<count($val); $v++){
                $sql .= ' OR '.$key.' = '.$val[$v].'';
              }
              $sql.=")";
              }
              
            }
            elseif($val != "" && $val != -1)
            {
              $sql .= ' AND('.$key.' = '.$val.')';
            }
          }
        }

        $users_own_id = $_SESSION['user_id'];
        $sql.=" AND users.user_id = profiles.user_id AND users.user_type <> 'dc' AND profiles.user_id <> '$users_own_id' ORDER BY users.last_access DESC LIMIT ".MAX_RECORDS."";
        $results = pg_query($conn,$sql);
        $row = pg_fetch_all($results);
        $count=pg_num_rows($results);
        $val =pg_last_error($conn);
        $_SESSION['countresults']=$count;
        $_SESSION['resultsarray']=$row;
        header("Location:profile-search-result.php");

        ob_flush();
        
          
      }
      
    }
  

?>
        <div class="banner"> <a href="#"><img src="images/banner.gif" alt="Page banner"/></a></div>
          <div class="container_row">
            <div class="welcomezone">
              <div class="blueboldheading">
                <h1 class="centered_text">Search For Partner</h1>
              </div>
               <b>Searching in </b>
               <b> <a href="./profile-city-select.php"><?php echo getPropertyByValue('city',$_COOKIE['city']); ?> </a></b>
              <hr/>
              <form class="profile_container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- About You Section -->
               <b> <?php echo $error; ?></b>
                <div><h3 class="profile_subtitle left_align"> About You </h3></div>
                <hr/>
                <!-- Gender Looking for -->
                <div class="profile_row extended_row">
                    <?php buildRadio("gender","I am",false,"",$profile_arguments['gender']);?>
                </div>
                <!-- Gender Looking for -->
                <div class="profile_row extended_row">
                  <?php buildRadio("gender_sought","Seeking","",false, $profile_arguments['gender_sought']);?>
                </div>
                <!-- Relationship type  -->
                <div class="profile_row extended_row">

                  <?php buildCheckbox("looking_for","","",true,$profile_arguments['looking_for'],false);?>
                </div>

                <!-- Desired Age Range -->
                <div class="profile_row extended_row">
                  <div><h2> Age Range </h2></div>


                  <?php buildInputType("number","From","age_from",false,MIN_USER_AGE,MAX_USER_AGE,$profile_arguments['age_from']); ?>
                  <?php buildInputType("number","To","age_to",false,MIN_USER_AGE,MAX_USER_AGE,$profile_arguments['age_to']); ?>
                </div>

                <!-- Apperance Section -->
                <hr/>
                  <div><h3 class="profile_subtitle left_align"> Appearance </h3></div>
                <hr/>
                <!-- Height Dropdown -->
                <div class="profile_row extended_row">
                  <div><h2> Height</h2></div>
                  <?php generateSelectInputRow("profile_row","From", "height_from", getHeightInFeetInches(), $profile_arguments['height_from'],true,true);?>
                  <?php generateSelectInputRow("profile_row","To", "height_to", getHeightInFeetInches(), $profile_arguments['height_to'],true,true);?>
                  
                </div>
                <!-- Eye color checkboxes -->
                <!--function buildDropdown($table,$title="",$class="",$includeFirstIndex = true,$post_val=-1,$simple=false)-->
                
                <div class="profile_row extended_row">
                  <?php buildCheckbox("eye_color","","",true,$profile_arguments['eye_color']);?>
                </div>
                <!-- Hair color checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("hair_color","","",true,$profile_arguments['hair_color']);?>
                </div>
                <!-- Body Type checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("body_type","","",true,$profile_arguments['body_type']);?>
                </div>      

                <!-- Background/Values Section -->
                <hr/>
                  <div><h3 class="profile_subtitle left_align"> Background/Values </h3></div>
                <hr/>
                <!-- Marital Status checkboxes-->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("marital_status","","",true,$profile_arguments['marital_status']);?>
                </div>
                <!-- Ethnicity checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("ethnicity","","",true,$profile_arguments['ethnicity']);?>
                </div>
                <!-- Religion checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("religion","","",true,$profile_arguments['religion']);?>
                </div> 
                <!-- Education checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("education","","",true,$profile_arguments['education']);?>
                </div> 

                <!-- Life Style Section-->
                <hr/>
                  <div><h3 class="profile_subtitle left_align"> Life Style </h3></div>
                <hr/>
                <!-- Smoke checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("smoke","Smoke ?","",true,$profile_arguments['smoke']);?>
                </div>
                <!-- Exercise Frequency checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("excercise_frequency","","",true,$profile_arguments['excercise_frequency']);?>
                </div> 
                <!-- Salary checkboxes -->
                <div class="profile_row extended_row">
                  <?php buildCheckbox("salary","Salary/Year","",true,$profile_arguments['salary']);?>
                </div> 
                <!-- Submit Button-->
                <div class="profile_row extended_row">
                  <div class="search_submit_button">
                    <input type="submit" value="Search" href="#"/>
                  </div>
                </div>

              </form>
            </div>
          </div>
 
      <?php include 'footer.php' ?>