<!-- Begin reservation table data -->
<table class="global resv-table" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
			<th><?php echo _date; ?></th>    	
			<th><?php echo _time; ?></th>
			<th><?php echo _status; ?></th>
			<th><?php echo _guest_name; ?></th>
			<th><?php echo _pax; ?></th>
			<th><?php echo _phone_room; ?></th>
			<th><?php echo _type; ?></th>
			<th><?php echo _outlets; ?></th>
			<th><?php echo _author; ?></th>
			<th></th>
	    </tr>
	</thead>
	<tbody>
		<?php

		$reservations =	querySQL('search');
		
		if ($reservations) {
			foreach($reservations as $row) {
				// reservation ID
				$id = $row->reservation_id;
				$_SESSION['reservation_guest_name'] = $row->reservation_guest_name;
				// check if reservation is tautologous
				$tautologous = querySQL('tautologous');
				
			echo "<tr id='res-".$id."'>";
			echo"<td>".humanize($row->reservation_date)."</td>
			<td>".formatTime($row->reservation_time,$general['timeformat'])."</td>
			<td>".showReservation_status($row->reservation_hidden)."</td>
			<td>".printTitle($row->reservation_title)."
			<span class='bold'><a href='?p=102&resID=".$id."' >".utf8_encode($row->reservation_guest_name)."</a></strong>";
			if ($row->repeat_id !=0)
	            {
	            //print out recurring symbol
	            echo "<img src='images/icons/arrow-repeat.png' alt='"._recurring.
					 "' title='"._recurring."' border='0' >";
	            }
			echo"</td>
			<td><span class='bold'>".$row->reservation_pax."</strong></td>
			<td>".$row->reservation_guest_phone."</td>
			<td>".$row->reservation_hotelguest_yn."</td>
			<td>".$row->outlet_name."</td>
			<td>".$row->reservation_booker_name."</td>";
			
			echo "<td class='noprint'>";
			// DELETE BUTTON
			if ( current_user_can( 'Reservation-Delete' ) && $q!=3 ){
		    	echo"<a href='#modalsecurity' name='".$row->repeat_id."' id='".$id."' class='delbtn'>
					<img src='images/icons/delete_cross.png' alt='"._cancelled."' class='help' title='"._delete."'/></a>";
			}
			echo"</td></tr>";

			}
		}
		?>
	</tbody>
</table>
<!-- End example table data -->