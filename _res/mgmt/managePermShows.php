<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage permanent shows</strong>
	</div>

	<?php

		$query = $db->query( "SELECT * FROM timetable WHERE perm = '1'" );
		$num   = $db->num( $query );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			if( $array['time'] < 10 ) {

				$time = "0{$array['time']}:00";

			}
			else {

				$time = "{$array['time']}:00";

			}

			$day = strtotime( "{$array['day']} november 2010" );
			$day = date( "l", $day );

			$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['dj']}'" );
			$array2 = $db->assoc( $query2 );

			echo "<div class=\"row {$j}\" id=\"permshow_{$array['id']}\">";

			echo "<a href=\"#\" onclick=\"Radi.deletePermShow('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" align=\"right\" />";
			echo "</a>";

			echo "<a href=\"mgmt.addPermShow?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" align=\"right\" />";
			echo "</a>";
			
			echo "<strong>{$time}</strong> on <strong>{$day}</strong> hosted by <strong>{$array2['username']}</strong>";

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
			echo "There are no permanent shows to manage.";
			echo "</div>";

		}

	?>

</div>