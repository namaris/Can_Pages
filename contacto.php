<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
<!--<script type="text/javascript" src="js/forms.js"></script>-->
<title>Contacts</title>
<meta charset="utf-8">
    <!--css-->
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/grid.css" type="text/css" media="screen">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption:400,400italic' rel='stylesheet' type='text/css'>
<!--js-->
<script type="text/javascript" src="js/jquery-1.7.1.min.js" ></script>
<script type="text/javascript" src="js/superfish.js"></script>
<!--<script type="text/javascript" src="js/forms.js"></script>-->
<script type="text/javascript">


</script>
<!--[if lt InternetExplorer 8]>
      <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
          <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
       </a>
     </div>
      <link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption:400italic' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption:400' rel='stylesheet' type='text/css'>
    <![endif]-->

<!--[if lt IE 9]>
   		<script src="js/html5.js"></script>
  		<link rel="stylesheet" href="css/ie.css"> 
      <link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption:400italic' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption:400' rel='stylesheet' type='text/css'>
	<![endif]-->

</head>

<body>

<!--==============================header=================================-->
<header>
  <div class="line-top"></div>
	
	<?php
	
	if (isset($_POST ['name']) && ($_POST['phone']) && ($_POST['email']) ) {
		
	$email_from = $_POST['name'];
	$email_to = 'dulani.mir@gmail.com';
	$email_subject = 'Contacto Web Restaurant Can Pages';
	$email_message = $_POST['coments'];
	$email_email = $_POST['email'];

	$headers = 'From: '.$email_from."\r\n". 'Reply-To: '.$email_email."\r\n" . 'X-Mailer: PHP/' . phpversion();
					
	mail($email_to, $email_subject, $email_message, $headers);
	echo 'Mensaje enviado correctamente'; 
	}
else{
	
}
	
?>
	
  <div class="main">
    <div class="row-top">
      <h1><a href="index.html"><img alt="" src="images/logo.png"></a></h1>
      <nav>
        <ul class="sf-menu">
          <li><a href="index.html">INICIO</a></li>
          <li><a href="menu.html">CARTA</a> <ul>
              <li><a href="#">MENU 1</a></li>
              <li><a href="#">MENU 2</a>
              <li><a href="#">MENU 3</a></li>
            </ul></li>
          <li><a href="reservas.html">RESERVAS</a>
            
          </li>
          <li><a href="galeria.html">GALERIA</a> </li>
          <li></li>
          <li class="active"><a href="contacto.php">ContactO</a> </li>
        </ul>
      </nav>
      <div class="clear"></div>
    </div>
  </div>
</header>

<!--==============================content=================================-->
<section id="content"><div class="ic">More Website Templates @ TemplateMonster.com. December03, 2012!</div>
  <div class="border-horiz"></div>
  <div class="main">
    <h3>informacion de contacto</h3>
    <div class="box-address">
      <h4>restaurante can pages</h4>
      <dl class="address">
        <dt>08201 sabadell,<br>
          crta. prat, km3.</dt>
        <dd>telefono: +93 716 7494</dd>
        <dd>movil:     +1 959 603 6035</dd>
        <dd> E-mail: <a class="mail-1" href="#">info@restaurantcanpages.com</a> </dd>
      </dl>
    </div>
    <div class="map box-img">
     <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2984.6484287709063!2d2.095304!3d41.57685299999999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a494e15e3b5231%3A0x1c55f10965b0408d!2sRestaurante+Can+Pag%C3%A9s!5e0!3m2!1ses!2ses!4v1429714052987" width="800" height="600" frameborder="0" style="border:0"></iframe>
    </div>
    <div class="clear"></div>
  </div>
  <div class="box-contact">
    <h3> consultas:</h3>
    <form id="contact-form" method="post" action="">
      <fieldset>
        <div class="coll-1">

            <!-- CAMPO NOMBRE DEL FORMULARIO -->
          <div>
            <div class="form-txt">su nombre:</div>
              <input type="text" name="name">
          </div>
            <!------------------------------>

          <div>
            <div class="form-txt">telefono:</div>
              <input type="tel" name="phone">
          </div>

          <div>
            <div class="form-txt">Email:</div>
            <label class="email">
              <input type="email" name="email">

          </div>
        </div>

        <div class="coll-2">
          <div>
            <div class="form-txt2">mensaje:</div>
              <textarea name="coments"> </textarea>
				<div class="padd-1">
			<input type="submit" value="Enviar" name="submit" style="color:#fff;display: inline-block; padding: 8px 16px;background: #063; width:50%;
-webkit-transition: all 0.3s ease;-moz-transition: all 0.3s ease;-o-transition: all 0.3s ease;
transition: all 0.3s ease;box-shadow: 0 1px 2px #c5c2a9;
-moz-box-shadow: 0 1px 2px #c5c2a9;-webkit-box-shadow: 0 1px 2px #c5c2a9;"></input>
			  
			  <input type="reset" value="Limpiar" style="color:#fff;display: inline-block; padding: 8px 16px;background: #063; width:50%;
-webkit-transition: all 0.3s ease;-moz-transition: all 0.3s ease;-o-transition: all 0.3s ease;
transition: all 0.3s ease;box-shadow: 0 1px 2px #c5c2a9;
-moz-box-shadow: 0 1px 2px #c5c2a9;-webkit-box-shadow: 0 1px 2px #c5c2a9;"></input>
				</div>
				</div>
			 </div>
      </fieldset>
    </form>
  </div>		
</section>

<!--==============================footer=================================-->
<footer>
  <div class="main">
    <ul class="soc-list">
      <li><a href="https://www.facebook.com/pages/Can-Pages/125408177631609?fref=tshttps://www.facebook.com/pages/Can-Pages/125408177631609?fref=ts"><img alt="" src="images/icon-1.png"></a></li>
      <li><a href="#"><img alt="" src="images/icon-2.png"></a></li>
      <li><a href="#"><img alt="" src="images/icon-3.png"></a></li>
      <li><a href="#"><img alt="" src="images/icon-4.png"></a></li>
    </ul>
    <div class="policy">TODOS LOS DERECHOS RESERVADOS DE <a href="http://www.templatemonster.com" rel="nofollow">www.restaurantCANPAGES.com</a></div>
    <div class="clear"></div>
  </div>
</footer>
</body>
</html>
