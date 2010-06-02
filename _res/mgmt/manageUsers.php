<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage users</strong>
	</div>

	<?php

		$query = $db->query( "SELECT * FROM users" );
		$num   = $db->num( $query );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			echo "<div class=\"row {$j}\" id=\"user_{$array['id']}\">";

			echo "<a href=\"#\" onclick=\"Radi.deleteUser('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" align=\"right\" />";
			echo "</a>";

			echo "<a href=\"mgmt.addUser?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" align=\"right\" />";
			echo "</a>";

			echo $array['username'];

			echo "</div>";

			$j++;

			if( $j == "c" ) {

				$j = "a";

			}

		}

	?>

</div>