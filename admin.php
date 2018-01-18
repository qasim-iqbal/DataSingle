<!--         
    Author: Group 09
    Filename: user-admin.php            
    Date: 2017 - 09 - 18            
    Description: User admin page for the website, contains css and links            
-->

<?php 
$title = "Datasingle - Admin";
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
        <div class="welcomezone">
          <div class="blueboldheading centered_text">
          <h1>Admin Panel</h1>
          </div>
         <div class="profile_container">
         
        
            <div class="right_side">
                <hr/>
                <h2 class="profile_subtitle">Offenders</h2>
                <hr/>
                     <?php

        // pulls all the records of the offender that in the offensives tables that are Open, anything that is closed will not be included
           $sql="SELECT  users.user_id, users.birth_date,profiles.city, users.first_name, users.last_name,profiles.self_description, profiles.images FROM profiles join offensives on profiles.user_id = offensives.offender join users on users.user_id = offensives.offender where offensives.status = '".OPEN."' ORDER BY offensives.last_reported DESC ";
           $results = pg_query($conn,$sql);
            $row = pg_fetch_all($results);
            $records = count($row);

                
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
                
                while($row = pg_fetch_assoc($results))
                    {
                        //print_r($row);
                        createResultProfile($row['user_id'], $row['first_name'], $row['last_name'], $row['city'], $row['birth_date'], $row['self_description'], $row['images'], true);
            
                    }
                createPagination($records, $current_page);
            
            ?>
            </div>


            <div class="left_side">
                <hr/>
                <h2 class="profile_subtitle">Reporter</h2>
                <hr/>
                     <?php 

            //pull the record of the reporter same as the offender but alter the sql statement


           $sql="SELECT users.user_id, users.birth_date,profiles.city, users.first_name, users.last_name,profiles.self_description, profiles.images FROM profiles join offensives on profiles.user_id = offensives.reporter join users on users.user_id = offensives.reporter where offensives.status = '".OPEN."' ORDER BY offensives.last_reported DESC";
            $results2 = pg_query($conn,$sql);
            $row2 = pg_fetch_all($results2);
            $records = count($row2);
            
                
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
                
                while($row = pg_fetch_assoc($results2))
                    {
                        //print_r($row);
                        createResultProfile($row['user_id'], $row['first_name'], $row['last_name'], $row['city'], $row['birth_date'], $row['self_description'], $row['images'], true);
            
                    }
                    
            
            

            ?>
            </div>
            </div>
          

         </div>
       </div>



<?php include 'footer.php' ?>