<?php
session_start();

// ** set configuration
	include('../config/config.general.php');
// ** login class
	require_once '../PLC/plc.class.php';
	
$this_page = "property";

// ** LOGIN CLASS **/
	
	$dbAccess = array(
	  'dbHost' => $settings['dbHost'],
	  'dbName' => $settings['dbName'],
	  'dbUser' => $settings['dbUser'],
	  'dbPass' => $settings['dbPass'],
	  'dbPort' => $settings['dbPort']
	 );

	$user = new flexibleAccess('',$dbAccess);


		$cookie 				= $user->read_cookie();
		$_SESSION['u_id'] 		= (isset($user->userData[$user->tbFields['userID']])) ? $user->userData[$user->tbFields['userID']] : '';
		$_SESSION['u_name'] 	= (isset($user->userData[$user->tbFields['login']])) ? $user->userData[$user->tbFields['login']] : '';
		$_SESSION['u_email'] 	= (isset($user->userData[$user->tbFields['email']])) ? $user->userData[$user->tbFields['email']] : '';
		$_SESSION['role'] 		= (isset($user->userData['role'])) ? $user->userData['role'] : '';
		$_SESSION['role'] 		= (isset($_SESSION['role'])) ? $_SESSION['role'] : 6;
		$_SESSION['property'] 	= (isset($user->userData['property_id'])) ? $user->userData['property_id'] : '';
		$_SESSION['u_time'] 	= date("Y-m-d H:i:s", time());
		$_SESSION['u_lang'] 	= (isset($user->userData['lang_id'])) ? $user->userData['lang_id'] : '';
		$_SESSION["valid_user"] = TRUE;

// ** database functions
	include('classes/database.class.php');
// ** localization functions
	include('classes/local.class.php');
// ** business functions
	include('classes/business.class.php');
// ** select cuisines styles functions
	include('classes/cuisines.class.php');
// ** select country functions
	include('classes/country.class.php');
// ** connect to database
	include('classes/connect.db.php');
// ** all database queries
	include('classes/db_queries.db.php');
// ** set configuration
	include('../config/config.inc.php');

	// ONLY LET SUPERUSER IN AFTER INSTALLATION !
	$num_admin = querySQL('num_admin');

	if ( $num_admin >= 1 && $_SESSION['role'] > 2 ){
		$user->logout();
		header("Location: ../PLC/index.php");
		exit; //To ensure security
	}

// translate to selected language
	$_SESSION['language'] = ($_SESSION['language']) ? $_SESSION['language'] : 'en_EN';
	translateSite(substr($_SESSION['language'],0,2));
// ** get superglobal variables
	// special setup for properties
	if ( current_user_can( 'Property-Overview' )){
		$_SESSION['page'] = 1;
	}else{
		$_SESSION['page'] = 2;
	}

	include('includes/get_variables.inc.php');
// ** check booking
	include('classes/bookingrules.class.php');
// ** html header section
	include('views/header.html.php');

// ** begin page content
echo "<body>";

	// ** top bar
	include('views/topbar.part.php');
	
	// ** main menu
?>
	<br class="clear"/>

	<!-- Begin content -->
	<div id="content_wrapper">
	
<?php
	// ** content

		// property page wrapper
		include('register/property.page.php');
		
echo"</div>";

// ** modal messages
include('ajax/modal.inc.php');
	
// ** end layout
include('views/footer.part.php');

// ** html footer section
include('views/footer.html.php');

// close database connection
mysql_close();
?>