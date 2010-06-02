<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box" align="right">

	<?php
	
		if( isset( $_GET['clear'] ) ) {
		
			$db->query( "DELETE FROM events" );
		
			echo "<div class=\"square good\" align=\"left\">";
			echo "<strong>Success</strong>";
			echo "<br />";
			echo "Events timetable cleared.";
			echo "</div>";
		
		}
	
	?>

	<form action="?clear" method="post" onsubmit="return confirm('Are you sure?');">
		
		<input type="submit" class="button red" value="Clear events timetable" />
		
	</form>

</div>

<div class="box">

	<div class="square title">
		<strong>Manage events</strong>
	</div>

	<?php

		$query = $db->query( "SELECT * FROM events" );
		$num   = $db->num( $query );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			$array['day'] = strtotime( "{$array['day']} november 2010" );
			$array['day'] = date( "l", $array['day'] );

			echo "<div class=\"row {$j}\" id=\"event_{$array['id']}\">";

			echo "<a href=\"#\" onclick=\"Radi.deleteEvent('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" align=\"right\" />";
			echo "</a>";

			echo "<a href=\"mgmt.addEvent?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" align=\"right\" />";
			echo "</a>";

			echo "<strong>" . $array['name'] . "</strong> on ";
			echo "<strong>" . $array['day'] . "</strong> at ";
			echo "<strong>" . $array['time'] . "</strong> hosted by ";
			echo "<strong>" . $array['host'] . "</strong> on ";
			echo "<strong>" . $array['hotel'] . "</strong>"; 

			echo "</div>";

			$j++;

			if( $j == "c" ) {

				$j = "a";

			}

		}

		if( $num == 0 ) {

			echo "<div class=\"square bad\" style=\"margin-bottom: 0px;\">";
			echo "<strong>Sorry</strong>";
			echo "<br />";
			echo "There are no events to manage.";
			echo "</div>";

		}

	?>

</div>