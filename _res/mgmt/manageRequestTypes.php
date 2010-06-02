<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage request types</strong>
	</div>

	<?php

		$query = $db->query( "SELECT * FROM request_types" );
		$num   = $db->num( $query );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			echo "<div class=\"row {$j}\" id=\"requesttype_{$array['id']}\">";

			echo "<a href=\"#\" onclick=\"Radi.deleteRequestType('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" align=\"right\" />";
			echo "</a>";

			echo "<a href=\"mgmt.addRequestType?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" align=\"right\" />";
			echo "</a>";

			echo $array['name'];

			echo "</div>";

			$j++;

			if( $j == "c" ) {

				$j = "a";

			}

		}

	?>

</div>