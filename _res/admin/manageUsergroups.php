<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage usergroups</strong>
	</div>

	<?php

		if( isset($_GET['moveUp']) or isset($_GET['moveDown']) ) {

			$id = $core->clean( $_GET['id'] );

			$query = $db->query( "SELECT * FROM usergroups WHERE id = '{$id}'");
			$array = $db->assoc( $query );

			if( isset($_GET['moveUp']) ) {

				$weight = $array['weight'] - 1;

			}
			else {

				$weight = $array['weight'] + 1;

			}

			$db->query( "UPDATE usergroups SET weight = '{$array['weight']}' WHERE weight = '{$weight}'" );

			$db->query( "UPDATE usergroups SET weight = '{$weight}' WHERE id = '{$id}'");

		}

		$query = $db->query( "SELECT * FROM usergroups ORDER BY weight ASC" );
		$num   = $db->num( $query );

		$query2 = $db->query( "SELECT * FROM usergroups ORDER BY weight DESC LIMIT 1" );
		$array2 = $db->assoc( $query2 );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			echo "<div class=\"row {$j}\" id=\"usergroup_{$array['id']}\">";

			echo "<div style=\"float: right; width: 32px; text-align: right;\">";

			if( $array['weight'] < $array2['weight'] ) {

				echo "<a href=\"?moveDown&id={$array['id']}\">";
				echo "<img src=\"_img/down.png\" alt=\"Down\" />";
				echo "</a>";

			}

			if( $array['weight'] > 1 ) {

				echo "<a href=\"?moveUp&id={$array['id']}\">";
				echo "<img src=\"_img/up.png\" alt=\"Up\" />";
				echo "</a>";

			}

			echo "</div>";
			echo "<div style=\"float: right; width: 32px; text-align: right;\">";

			echo "<a href=\"admin.addUsergroup?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" />";
			echo "</a>";

			echo "<a href=\"#\" onclick=\"Radi.deleteUsergroup('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" />";
			echo "</a>";

			echo "</div>";

			echo $array['name'];

			echo "</div>";

			$j++;

			if( $j == "c" ) {

				$j = "a";

			}

		}

	?>

</div>