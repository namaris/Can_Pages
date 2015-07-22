<?php session_start();
// MS IE not to forget the session variables
header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

/*
* TERMS OF USE - mySeat
* 
* Open source under the GNU General Public License. 
* 
* Copyright © 2011 Bernd Orttenburger
* All rights reserved.
*
* This booking form was created with the help and work
* of the guys at http://www.reservaenrestaurantes.com/
*
* COPYRIGHT:
* This file is part of mySeat.
*
* mySeat is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* any later version.
*
* mySeat is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with mySeat.  If not, see <http://www.gnu.org/licenses/>.
*/

// ** SETTINGS **
// Select the type of time selector:
// 'radio': radio buttons; 'drop': select box 
$time_selector = "drop";

//link to terms&condition page
// Your license
//$terms_link = "http://www.mysite.com/license.html";
// mySeat license
$terms_link = "http://www.myseat.us/terms.htm";
// GNU license
//$terms_link = "http://www.gnu.org/licenses/gpl-3.0.txt";

// END settings

// initial standard settings
$_SESSION['role'] = 6;
$_SESSION['resID'] = 0;
// PHP part of page / business logic
// ** set configuration
	include('../config/config.general.php');
// ** business functions
	require('business.class.php');
// ** database functions
	include('../web/classes/database.class.php');
// ** localization functions
	include('../web/classes/local.class.php');
// ** business functions
	include('../web/classes/business.class.php');
// ** connect to database
	include('../web/classes/connect.db.php');
// ** all database queries
	include('../web/classes/db_queries.db.php');
// ** php hooks class
	include_once "../web/classes/phphooks.config.php";
	include_once "../web/classes/phphooks.class.php";
	//create instance of plugin class
	include "../config/plugins.init.php";
			
// get and define referer
	$ref = getHost($_SERVER['HTTP_REFERER']);
	$_SESSION['referer'] = ($_SESSION['referer']!='') ? $_SESSION['referer'] : $ref;

// Check if outlet or property booking
	if (isset($_SESSION['single_outlet']) && (isset($_GET['outletID']) && empty($_GET['propertyID']))) {
		$_SESSION['single_outlet'] = 'ON';
	}else{
		$_SESSION['single_outlet'] = 'OFF';
	}

// outlet ID
	if (isset($_GET['outletID'])) {
		$_SESSION['outletID'] = (int)$_GET['outletID'];
		$_SESSION['property'] = querySQL('property_id_outlet');
	}

	// prevent injection with false outlet id's
	$check_web_outlet = querySQL('check_web_outlet');

// property ID
   if ($_GET['propertyID']) {
       $_SESSION['property'] = (int)$_GET['propertyID'];
	   $_SESSION['outletID'] = querySQL('web_standard_outlet');
	   $_SESSION['propertyID'] = $_SESSION['property'];
	
	   // prevent injection with false outlet id's
	   $check_web_outlet = 1;
   }
	

// selected time	
	if (isset($_GET['times'])) {
		// set selected time
		$time = $_GET['times'].":00";	
	}

// selected pax	
	if ($_GET['pax']) {
		// set selected time
		$_SESSION['pax'] = $_GET['pax'];	
	}elseif($_SESSION['selected_pax']<1){
		$_SESSION['pax'] = 2;
	}

	// ** set configuration
	include('../config/config.inc.php');

if($check_web_outlet==1){		
	// get property info for logo path
	$prp_info = querySQL('property_info');
	
	if (strtolower(substr($prp_info['website'],0,4)) =="http") {
		$website = $prp_info['website'];
	}else{
		$website = "http://".$prp_info['website'];
	}

	// selected date
    if ($_GET['selectedDate']) {
        $_SESSION['selectedDate'] = $_GET['selectedDate'];
    }
	
	// +++ memorize selected outlet details; maybe moved reservation +++
	$rows = querySQL('db_outlet_info');
	if($rows){
		foreach ($rows as $key => $value) {
			$_SESSION['selOutlet'][$key] = $value;
		}
	}
	
	// ** get superglobal variables
		include('../web/includes/get_variables.inc.php');
		
	// CSRF - Secure forms with token
		$barrier = md5(uniqid(rand(), true)); 
		$_SESSION['barrier'] = $barrier;		
	
  	//prepare selected Date
    list($sy,$sm,$sd) = explode("-",$_SESSION['selectedDate']);
  
	// get outlet maximum capacity
	$maxC = maxCapacity();
	 
	// get Pax by timeslot
    $resbyTime = reservationsByTime('pax');
    $tblbyTime = reservationsByTime('tbl');
	$_SESSION['passbyTime'] = reservationsByTime('pass');
	// print_r($_SESSION['passbyTime']);
	// echo $_SESSION['outletID'].", ".$_SESSION['selectedDate'].", ".$_SESSION['resID'];
    // get availability by timeslot
    $availability = getAvailability($resbyTime,$general['timeintervall']);
    $tbl_availability = getAvailability($tblbyTime,$general['timeintervall']);
	
	// some constants
    $outlet_name = querySQL('db_outlet');
	$max_pax = ($_SESSION['selOutlet']['passerby_max_pax'] <= 0) ? $_SESSION['selOutlet']['outlet_max_capacity'] : $_SESSION['selOutlet']['passerby_max_pax'];
	$max_passerby = ($_SESSION['passerby_max_pax'] <= 0) ? $max_pax : $_SESSION['passerby_max_pax'];
}
  // translate to selected language
	$language = $general['language'];
	$set_lang = substr($language,0,2);
	$browser_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

	if( isset($_GET['lang']) ){
		$language = $_GET['lang'];
		$_SESSION['lang'] = $language;
	}else if ( isset($browser_lang) && $_SESSION['lang'] == '' && ($browser_lang=="en" || $browser_lang == $set_lang) ){
		$language = $browser_lang;
	}
	if( $_SESSION['lang'] == ''){
		$_SESSION['lang'] = $language;
	}
	//$_SESSION['lang'] = 'en';
	$lang = substr($_SESSION['lang'],0,2);
	translateSite($lang,'../web/');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="<?php echo $language; ?>">
<head>
	<!-- Meta data for SEO -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta name="robots" content="follow,index,no-cache" />
	<meta name="author" lang="en" content="Bernd Orttenburger [www.myseat.us]" />
	<meta name="copyright" lang="en" content="mySeat [www.myseat.us]" />
	<meta name="keywords" content="mySeat, table reservation system, Bookings Diary, Reservation Diary, Restaurant Reservations, restaurant reservation system, open source, software, reservation management software, restaurant table management, table planner, restaurant table planner, table management, hotel" />
	<meta id="htmlTagMetaDescription" name="Description" content="Make online reservationsfor lunch and dinners. mySeat is a OpenSource online reservation system for restaurants." />
	<meta id="htmlTagMetaKeyword" name="Keyword" content="restaurant reservations, online restaurant reservations, restaurant management software, mySeat, free tables" />

	<!-- Meta data for all iDevices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="shortcut icon" href="http://www.myseat.us/favicon.ico">

	<!-- CSS - Setup -->
	<link href="style/datepicker.css" rel="stylesheet" type="text/css" />
	<?php
	// Mobile Browser detection
		$mobile_browser = checkMobile();
		//$mobile_browser = 1;
		if ($mobile_browser > 0) {
			$time_selector = "drop"; // mobile has always dropdown menu
			echo '<link href="style/mobile.css" rel="stylesheet" type="text/css" />';
		}else{
			echo '<link href="style/style.css" rel="stylesheet" type="text/css" />';
		}
	?>

    <!-- jQuery Library-->
    <script src="js/jQuery.min.js" type="text/javascript"></script>
    <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script> 
    <script src="js/functions.js" type="text/javascript"></script>
	<script src="../web/lang/jquery.ui.datepicker-<?php echo substr($_SESSION['language'],0,2);?>.js" type="text/javascript"></script>	

<!-- Uncomment to define your own color scheme for the booking form -->
<!-- The example here is from the Monmarthe DEMO page at myseat.us -->

<!--
	<style type="text/css">
		html {
			background:url(images/html-bg.jpg) left top repeat !important;
		}
		.data1, .data2, .data3, .register{
			background-color: #F6E6CC;			
		}
		h1, .data1 .number, .data2 .number, .data3 .number, .register .number{
			color: #AB245E;			
		}
		a, a:active, a:visited {
		color: #42032C;
		}
		a:hover {
			color:#7e4e7f;
			background-color: #F6E6CC;
		}
		.button:hover {
			color:#7e4e7f;
			background-color: #F6E6CC;
		}
			button, .button, .btn_pax {
			background-color: #561C40;
			color: #F6E6CC;
			border: 1px solid #B89394;
			text-shadow: none;
		}
	</style>
-->
<!-- color scheme for the booking form END -->

    <title><?php echo _reservations;?></title>
</head>
<body>
	    
<div id="page-content">
<?php
	if( $check_web_outlet<1 ){
		echo "<div class='tc'><div class='alert_error'><p><img src='../web/images/icon_error.png' alt='error' class='middle'/>&nbsp;&nbsp;";
		echo _sorry."<br></p></div><br/></div>";
		exit; //stop script
	}
?>
<?php language_navigation($set_lang);?>
<form action="process_booking.php" method="post" name="contactForm" id="contactForm">
	<?php	
				// outlets dropdown
				$num_outlets = 0;
				$order = 0;
				if ($_SESSION['single_outlet'] == 'OFF') {
					$num_outlets = querySQL('num_outlets');
				}

					if ($num_outlets>1) {
						$order++;
						echo "<h1>"._webform." "._for_." <span>".$prp_info['name']."</span></h1><div class='trenner'></div>";
						echo"<div class='data3'>	
							<div class='number'>".$order."</div>";
						echo "<input type='hidden' name='reservation_outlet_id' id='single_outlet' value='".$_SESSION['outletID']."'>";
						$outlet_result = outletListweb($_SESSION['outletID'],'enabled','reservation_outlet_id');
						echo"</div>";
					} else{
						echo "<h1>"._webform." "._for_." <span>".$outlet_name."</span></h1><div class='trenner'></div>";
						echo "<input type='hidden' name='reservation_outlet_id' id='single_outlet' value='".$_SESSION['outletID']."'>";
					}
?>
<div class="data1">	
	<div class="number"><?php echo $order+1;?></div>
	<h3><?php echo _date;?></h3>		
			 <!-- Datepicker -->
			    <input type="hidden" name="dbdate" id="dbdate" value="<?php echo $_SESSION['selectedDate']; ?>"/>
			    <input id="reservation_date" name="reservation_date" value="<?php echo $_SESSION['selectedDate'];?>">
			    <input type="hidden" name="recurring_dbdate" value="<?php echo $_SESSION['selectedDate']; ?>"/>
</div>
<div class="data2">	
	<div class="number"><?php echo $order+2;?></div>
	<h3><?php echo ucfirst(_people_);?></h3>
	<div>
        <?php //personsList($general['max_menu'],2); ?>
		<input type="text" name="reservation_pax" id="reservation_pax" readonly="true" value="<?php echo $_SESSION['pax'];?>"/>
		<a href="javascript:void(0);" class="inc btn_pax">+</a>
		<a href="javascript:void(0);" class="dec btn_pax">-</a>
	</div>
</div>
<div class="data3">	
	<div class="number"><?php echo $order+3;?></div>
	<h3><?php echo _time;?></h3>
		<?php
		if ($time_selector == "radio") {
		timeFields($general['timeformat'], $general['timeintervall'],'reservation_time',$time,$_SESSION['selOutlet']['outlet_open_time'],$_SESSION['selOutlet']['outlet_close_time'],0);
		}else{
		    timeList($general['timeformat'], $general['timeintervall'],'reservation_time',$time,$_SESSION['selOutlet']['outlet_open_time'],$_SESSION['selOutlet']['outlet_close_time'],0);
		} 
		?>
		<?php
		// Special event of the day and outlet
		$special_events = '';
		$special_events = querySQL('event_data_day');

			if ( $special_events ) {
				echo "<br/><div class='alert_ads'>";
				// special events today at outlet
							foreach($special_events as $row) {
								echo "<span class='bold'>
								<a href='".$_SERVER['SCRIPT_NAME']."?outletID=".$row->outlet_id."&selectedDate=".$row->event_date."'>".
								_today.": ".$row->subject."</a></span>
								<p>".$row->description."<br/><cite><span class='bold'>
								".date($general['dateformat'],strtotime($row->event_date)).
								"</span> ".formatTime($row->start_time,$general['timeformat']).
								" - ".formatTime($row->end_time,$general['timeformat'])." | ".
								_ticket_price.": ".number_format($row->price,2).
								"</cite></p>";
								if( key($row) != count($events_advertise)-1 && key($row) > 1) {
									// BR between special events
									echo"<br/>";
								}
							}
						echo "</div>";
			}
			//end special events
		?>
</div>
<div class="register">	
	<div class="number"><?php echo $order+4;?></div>
	<h3><?php echo _detail;?></h3>
	<label><?php echo _title; ?></label><br/>
	<br/>
			<?php
				$title = '';
				 if (isset($me)) {
				 	if ( $me['gender']=='male' ) {
						$title = 'M';
				 	}else if ( $me['gender']=='female' ) {
						$title = 'F';
				 	}
				 }
			    titleList($title);
			?>
		    <br/>
		    <div>
			<label><?php echo _name; ?></label><br/>
               <input type="text" name="reservation_guest_name" class="required" id="reservation_guest_name" value="<?php if(isset($me['last_name'])){echo $me['last_name'].", ".$me['first_name'];} ?>" />
                    </div>
		    <br/>
            <div>
			   <label><?php echo _email; ?></label><br/>
               <input type="text" name="reservation_guest_email" class="required email" id="reservation_guest_email" value="<?php if(isset($me['last_name'])){echo $me['email'];} ?>" />
            </div>
		    <br/>
		    <div>
			   <label><?php echo _phone; ?></label><br/>
               <input type="text" name="reservation_guest_phone" class="required" id="reservation_guest_phone" value="" />
            </div>
			<br/>
			<div>
				<label><?php echo _form_notes; ?></label><br/>
				<textarea cols="50" rows="5" name="reservation_notes" id="reservation_notes" ></textarea>
			</div>
		    <br/>

				<input type="hidden" name="action" id="action" value="submit"/>
				<input type="hidden" name="barrier" value="<?php echo $barrier; ?>" />
				<input type="hidden" name="reservation_referer" value="<?php echo $_SESSION['referer']; ?>" />
				<input type="hidden" name="reservation_hotelguest_yn" id="reservation_hotelguest_yn" value="PASS"/>
				<input type="hidden" name="reservation_booker_name" id="reservation_booker_name" value="Contact Form"/>
				<input type="hidden" name="reservation_author" id="reservation_author" value="<?php echo querySQL('db_property');?> Team"/>
				<input type="hidden" name="email_type" id="email_type" value="<?php echo $language; ?>"/>
				<br/>
				<div class="tl">
					<input type="checkbox" name="reservation_advertise" id="reservation_advertise" value="YES"/>
					&nbsp;<strong><?php echo _reservation_advertise; ?></strong>
					<br/>
					<!-- <div style="visibility:hidden;"> -->
					<input type="checkbox" name="terms" class="required checkbox" id="terms" value="YES" checked="checked"/>
					<a href="<?php echo $terms_link;?>" target="_blank" onclick="window.open(this.href, this.target, 'width=700,height=700'); return false;" class="checktext">
						&nbsp;<?php echo _reservation_terms; ?>
					</a>
					<!-- </div> -->
				</div> 
				<br/>
	</div> 
	
				<br/>
				<div class="tc">
					<input class='button' type='submit' value='<?php echo _create; ?>' /></div>
                </div>
		</form>
		<br/>		
		</div></div><!-- page content end -->
			
</div><!-- page container end -->
</div><!-- main close -->
<?php
// ** plugin hook
if ($hook->hook_exist( 'debug_online' )) {
	$hook->execute_hook( 'debug_online' );
}
?>
  <!-- Javascript at the bottom for fast page loading --> 
<script>
	/* utility functions */
	var unavailableDates = [<?php defineOffDays(); ?>];

	function unavailable(date) {
		var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		m = m+1;
		/* add leading zero */
		if (d < 10) d = "0" + d;
		if (m < 10) m = "0" + m;
	  ymd = y + "-" + m + "-" + d;
	  if ($.inArray(ymd, unavailableDates) == -1) {
	    return [true];
	  } else {
	    return [false];
	  }
	}

 jQuery(document).ready(function($) {
      // Setup datepicker input at customer reservation form
      $("#reservation_date").datepicker({
		  minDate: '0',
		  maxDate: '+6M',      
		  nextText: '&raquo;',
	      prevText: '&laquo;',
		  showOn: "button",
		  buttonImage: "images/button_cal.png",
		  buttonImageOnly: true,
	      firstDay: 1,
	      numberOfMonths: 1,
	      gotoCurrent: true,
	      altField: '#dbdate',
	      altFormat: 'yy-mm-dd',
	      defaultDate: 0,
		  beforeShowDay: unavailable,
	      dateFormat: '<?php echo $general['datepickerformat'];?>',
	      regional: '<?php echo substr($_SESSION['lang'],0,2);?>',
	      onSelect: function(dateText, inst) { window.location.href="?selectedDate=" + $("#dbdate").val() }
      });
      // month is 0 based, hence for Feb. we use 1
	     $("#reservation_date").datepicker('setDate', new Date(<?php echo $sy.", ".($sm-1).", ".$sd; ?>));
	     	$("#ui-datepicker-div").hide();
	     	$("#reservation_outlet_id").change(function(){
	    		window.location.href='?propertyID=<?php echo $_SESSION['property'];?>&outletID=' + this.value;
	  	 	});
	
	 // +/- button for pax field  
		$(".btn_pax").click(function() {
		    var $button = $(this);
		    var oldValue = $button.parent().find("input").val();
  
		if ($button.text() == "+") {
				  if(oldValue < <?php echo $general['max_menu']?>){
		          	  var newVal = parseFloat(oldValue) + 1;
		          	  // AJAX save would go here
				  }else{
					  var newVal = parseFloat(oldValue);
				  }
		        } else {
		          // Don't allow decrementing below zero
		          if (oldValue >= 1) {
		              var newVal = parseFloat(oldValue) - 1;
		              // AJAX save would go here
		          }else{
					  var newVal = parseFloat(oldValue);
				  }
		        }
		        $button.parent().find("input").val(newVal);
				window.location.href='?pax=' + newVal;
		});
	
    });
</script>

</body>
</html>