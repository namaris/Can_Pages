

</div>
<!-- End content -->

<br class="clear"/>
	
	<div id="footer">
		<div class="detail">
			<?php
			if (!$_SESSION['prp_name']) {
				$_SESSION['prp_name'] = querySQL('db_property');
			}
			
			$filename = substr(dirname(__FILE__),0,-9)."xt-admin";
			
			if($this_page != "property"){
				echo "<img src='images/icon_user.png' alt='User:' class='middle'/><a href='";
				if ($_SESSION['role']=='1' && file_exists($filename)) {
					echo"../xt-admin/index.php";				
				}
				$name = ($_SESSION['realname']=='') ? $_SESSION['u_name'] : $_SESSION['realname'];
				echo "'><span class='bold'> ".$name."</span></a>";
			}
			?>
			&nbsp;|&nbsp;
			&copy; 2011 by mySeat <?php echo $sw_version;?> distributed under the terms of the GNU General Public License&nbsp;
		</div>
	</div>

<!-- End control panel wrapper -->