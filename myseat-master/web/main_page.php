<?php
session_start();

/*
COPYRIGHT:
This file is part of mySeat.

    mySeat is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    mySeat is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with mySeat.  If not, see <http://www.gnu.org/licenses/>.
*/

/** Login **/
// ** set configuration
	//Software version
	$sw_version = 'v0.211';
	
	include('../config/config.general.php');
	
	require_once '../PLC/plc.class.php';
	
	$dbAccess = array(
	  'dbHost' => $settings['dbHost'],
	  'dbName' => $settings['dbName'],
	  'dbUser' => $settings['dbUser'],
	  'dbPass' => $settings['dbPass'],
	  'dbPort' => $settings['dbPort']
	 );

	$user = new flexibleAccess('',$dbAccess);

	if ( $_GET['logout'] == 1 ){
		$user->logout();
	}
	if ( !$user->autologin()){
		header("Location: ../PLC/index.php");
		exit; //To ensure security
	}else{
		$cookie 				= $user->read_cookie();
		$_SESSION['u_id'] 		= $user->userData[$user->tbFields['userID']];
		$_SESSION['u_name'] 	= $user->userData[$user->tbFields['login']];
		$_SESSION['u_email'] 	= $user->userData[$user->tbFields['email']];
		$_SESSION['role'] 		= $user->userData['role'];
		$_SESSION['realname'] 	= $user->userData['realname'];
		$_SESSION['autofill'] 	= $user->userData['autofill'];
		$_SESSION['property'] 	= $user->userData['property_id'];
		$_SESSION['propertyID'] = $user->userData['property_id'];
		$_SESSION['u_time'] 	= date("Y-m-d H:i:s", time());
		$_SESSION['u_lang'] 	= $user->userData['lang_id'];
		$_SESSION["valid_user"] = TRUE;

	}

// administrative includes
// ** connect to database
	include('classes/connect.db.php');
// ** localization functions
	include('classes/local.class.php');
// ** database functions
	include('classes/database.class.php');
// ** business functions
	include('classes/business.class.php');
// ** select cuisines styles functions
	include('classes/cuisines.class.php');
// ** select country functions
	include('classes/country.class.php');
// ** all database queries
	include('classes/db_queries.db.php');
// ** set configuration
	include('../config/config.inc.php');
// ** php hooks class
	include_once "classes/phphooks.config.php";
	include_once "classes/phphooks.class.php";
	//create instance of plugin class
	$plugin_path = '../plugins/';
	include "../config/plugins.init.php";

// operative includes	
// translate to selected language
	translateSite(substr($_SESSION['language'],0,2));
// ** get superglobal variables
	include('includes/get_variables.inc.php');
// ** html header section
	include('views/header.html.php');
// ** set todays date
$today_date = date('Y-m-d');

// ** begin page content
echo "<body>";

	// ** top bar
	include('views/topbar2.part.php');
	// ** main menu
	//include('views/mainmenu.part.php');

	echo "<div id='wrapper'>";

	
	// ** content
	switch($_SESSION['page']){
		case '1':
			// dashboard
			include('content/dashboard.page.php');
		break;
		case '2':
			// outlet
			$dayoff = getDayoff();
			$_SESSION['resID'] = '';
			include('content/showday.page.php');
		break;
		case '3':
			// statistic
			if ( current_user_can( 'Page-Statistic' ) ){
				include('content/statistic.page.php');
			}else{
				redeclare_access();
			}
		break;
		case '4':
			// export
			if ( current_user_can( 'Page-Export' ) ){
				include('content/export.page.php');
			}else{
				redeclare_access();
			}
		break;
		case '5':
			// info
			redeclare_access();
			//include('content/info.page.php');
		break;
		case '6':
			// system
			if ( current_user_can( 'Page-System' ) ){
				include('content/system.page.php');
			}else{
				redeclare_access();
			}
		break;
		case '101':
			// outlet detail
			if ( current_user_can( 'Page-System' ) ){
				include('content/detail.outlet.page.php');
			}else{
				redeclare_access();
			}
		break;
		case '102':
			// reservation detail
			include('content/detail.reservation.page.php');
		break; 
	}
	
// ** modal messages
include('ajax/modal.inc.php');

// ** plugin hook
if ($hook->hook_exist( 'debug' )) {
	$hook->execute_hook( 'debug');
}

// ** end layout
include('views/footer.part.php');

// ** html footer section
include('views/footer.html.php');

// close database connection
mysql_close();
?>