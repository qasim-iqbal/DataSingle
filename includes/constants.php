<!--         
    Author: Group 09
    Filename: header.php			
    Date: 2017 - 09 -18			
    Description: Header page for the website, contains css, globals, required files and links			
-->

<?php

	define("ADMIN", "a");
	define("CLIENT", "c");
	define("OPEN","O");
	define("CLOSED","C");
	define("INCOMPLETE", "i");
	define("DISABLED", "d");
	define("HOSTNAME", "127.0.0.1");
	define("DB_NAME", "group09_db");
	define("DB_USER", "group09_admin");
	define("DB_PASSWORD", "datasingle");
	define("HASH_TYPE", "md5");
	define("COOKIE_USER_ID_EXPIRY_TIME", 2592000);
	define("COOKIE_SEARCH_EXPIRY_TIME", 2592000);
	define("YEAR_IN_SECONDS", 31536000);
	//constants for validations of user-registrations
	define("MAXIMUM_ID_LENGTH",20);
	define("MINIMUM_ID_LENGTH",6);
	define("MAXIMUM_PASSWORD_LENGTH",8);
	define("MINIMUM_PASSWORD_LENGTH", 6);
	define("INCHES_IN_FOOT", 12);
	define("MINIMUM_AGE", 18);
	define("MAX_NAME_LENGTH",128);
	define("MAXIMUM_HEADLINE_LENGTH", 1000);
	define("MAXIMUM_DESCRIPTION_LENGTH", 1000);
	
	//for use in profile-search-results
	define('MATCHES_PER_PAGE', 10);
	define('PAGINATION_RANGE_FROM_CURRENT', 5);
	
	/*For use in generated elements via php,
	related function is called generateElementsInRows
	and is located in functions.php*/
	define('GENERATE_ELEMENT_ROW_SIZE', 2);

	// constants for height values 
	define("MAX_FT",7); // max feet for height
	define("MAX_IN",12); // max inches per feet

	// constant for logout Messge
	define("LOGOUT_MESSAGE","You have been successfully logged out.");
	define("LOGIN_UPLOAD_MESSAGE","Hi there, please login to upload images!");
	define("DISABLED_USER_AUP","Your account has been DISABLED, please read our AUP policy!");

	// constant for registration 
	define("REGISTER_MESSAGE","Thank you for registering! Please log into your account.");
	define("PROFILE_CREATE_MESSAGE","Your profile has been created successfully.");
	define("UPDATE_USER_MESSAGE","Your account information has been successfully updated");
	
	// constants for Input Type Range Function 
	define("MIN_INPUT_RANGE",0);
	define("MAX_INPUT_RANGE",100);
	define("MIN_INPUT_VALUE",0);

	// Cosntants for Legal Age
	define("MIN_USER_AGE",18);
	define("MAX_USER_AGE",100);

	// First Index Option for dropdown
	define("DEFAULT_OPTION_TEXT","Choose Below");
	define("DEFAULT_OPTION_VALUE",-1);
	
	// constants for file uploads
	define("MAXIMUM_PROFILE_IMAGES", 10);
	define('IMAGE_ROW_WIDTH', 5);
	
	// 100k = correct - but too small to test usually
	// define("MAX_UPLOAD", 100000);
	define("MAX_UPLOAD", 5000000);
	define("USER_IMAGES_DIRECTORY", "./user_images/");
	define('IMAGE_DIRECTORY_PERMISSIONS', 0777);


	// constants for search results
	define("NO_VALUE_FOUND",0);

	// constants for mail 
	define("PASSWORD_CHANGE_SUBJECT","Password Change");
	define("DATA_SINGLE_LOGIN_URL","http://opentech2.durhamcollege.org/webd3201/group09/user-login.php");
	define("WEBSITE_NAME","Data Single");
	define("WEBSITE_EMAIL","data-single@mail.com");

	// constant for maximum paragraph length
	define("MAX_DESCRIPTION_LENGTH",90);
	define("MIN_DESCRIPTION_LENGTH",0);
	define("MAX_RECORDS",200);
	define("ONE_PAGE",1);
?>