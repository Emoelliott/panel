<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }
	
	if( $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) {
	
?>

<div class="box" align="right">
	
	<?php
		
		if( isset( $_GET['reset'] ) ) {
			
			$db->query( "DELETE FROM timetable WHERE perm != '1'" );
			
			echo "<div class=\"square good\" align=\"left\">";
			echo "<strong>Success</strong>";
			echo "<br />";
			echo "Timetable cleared.";
			echo "</div>";
			
		}
		
	?>

	<form action="?reset" method="post">
	
		<input type="submit" class="button red" value="Clear timetable" />
	
	</form>

</div>

<?php
	
	}

	for( $i = 1; $i <= 7; $i++ ) {
		
		$day = strtotime( "{$i} november 2010" );
		$day = date( "l", $day );
		
?>

<div class="box">

	<div class="square title noverlay" style="margin-bottom: 0px; cursor: pointer;" onclick="Radi.timetableToggle('<?php echo $i; ?>'); return false;">
		
		<img id="toggle_<?php echo $i; ?>" class="toggle" src="_img/<?php echo $i == 1 ? "minus" : "plus"; ?>.png" alt="Toggle" align="right" />

		<strong><?php echo $day; ?></strong>
		
	</div>

	<div id="day_<?php echo $i; ?>" class="day"<?php if($i != 1 ) { ?> style="display: none;"<?php } ?>>
		
		<table width="100%" cellpadding="3" cellspacing="0">
		
			<tr>
			
				<td width="20%" valign="top">
				<?php
					
					$k = 1;
					
					for( $j = 0; $j <= 23; $j++ ) {
						
						if( $j < 10 ) {
						
							$time = "0{$j}:00";
						
						}
						else {
						
							$time = "{$j}:00";
						
						}
						
						$query = $db->query( "SELECT * FROM timetable WHERE day = '{$i}' AND time = '{$j}'" );
						$array = $db->assoc( $query );
						$num   = $db->num( $query );

						$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['dj']}'" );
						$array2 = $db->assoc( $query2 );

						$query3 = $db->query( "SELECT * FROM usergroups WHERE id = '{$array2['displaygroup']}'" );
						$array3 = $db->assoc( $query3 );

						echo "<div style=\"padding: 3px;\">";
						
						echo $time;
						echo " - ";
						
						if( $num == 0 ) {

							echo "<a id=\"slot_{$i}_{$j}\" href=\"#\" onclick=\"Radi.bookSlot('{$i}','{$j}'); return false;\">";
							echo "Book";
							echo "</a>";
						
						}
						elseif( $array['dj'] == $user->data['id'] or $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) {
							
							echo "<a id=\"slot_{$i}_{$j}\" href=\"#\" onclick=\"Radi.bookSlot('{$i}','{$j}'); return false;\" style=\"color: #{$array3['colour']}\">";
							echo $array2['username'];
							echo "</a>";
						
						} else {
							
							echo "<span style=\"color: #{$array3['colour']}; font-weight: bold;\">";
							echo $array2['username'];
							echo "</span>";
							
						}
						
						echo "</div>";
						
						$k++;
						
						if($k == 6) {
							
							echo "</td><td width=\"20%\" valign=\"top\">";
							
							$k = 1;
							
						}
						
					}
					
				?>
				</td>
				
			</tr>
			
		</table>
		
	</div>

</div>

<?php
		
	}
?>