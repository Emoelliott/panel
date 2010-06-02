<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage menu items</strong>
	</div>

	<?php

		if( isset($_GET['moveUp']) or isset($_GET['moveDown']) ) {
			
			$id = $core->clean( $_GET['id'] );
			
			$query = $db->query( "SELECT * FROM menu WHERE id = '{$id}'");
			$array = $db->assoc( $query );
			
			if( isset($_GET['moveUp']) ) {
			
				$weight = $array['weight'] - 1;
			
			}
			else {
				
				$weight = $array['weight'] + 1;
				
			}
			
			$db->query( "UPDATE menu SET weight = '{$array['weight']}' WHERE weight = '{$weight}' AND usergroup = '{$array['usergroup']}'" );
			
			$db->query( "UPDATE menu SET weight = '{$weight}' WHERE id = '{$id}'");
			
		}

		$query = $db->query( "SELECT * FROM usergroups ORDER BY weight ASC" );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			$query2 = $db->query( "SELECT * FROM menu WHERE usergroup = '{$array['id']}' ORDER BY weight ASC" );
			
			$query3 = $db->query( "SELECT * FROM menu WHERE usergroup = '{$array['id']}' ORDER BY weight DESC" );
			$array3 = $db->assoc( $query3 );
			
			echo "<div class=\"row\" style=\"background: #e6e6e6;\">";
			echo "<strong>{$array['name']}</strong>";
			echo "</div>";
			
			while( $array2 = $db->assoc( $query2 ) ) {
	
				echo "<div class=\"row {$j}\" id=\"menu_{$array2['id']}\">";

				echo "<div style=\"float: right; width: 32px; text-align: right;\">";

				if( $array2['weight'] < $array3['weight'] ) {

					echo "<a href=\"?moveDown&id={$array2['id']}\">";
					echo "<img src=\"_img/down.png\" alt=\"Down\" />";
					echo "</a>";
					
				}
				
				if( $array2['weight'] > 1 ) {
				
					echo "<a href=\"?moveUp&id={$array2['id']}\">";
					echo "<img src=\"_img/up.png\" alt=\"Up\" />";
					echo "</a>";
					
				}
				
				echo "</div>";
				echo "<div style=\"float: right; width: 32px; text-align: right;\">";

				if( $array2['protected'] != 1) {

					echo "<a href=\"admin.addMenuItem?id={$array2['id']}\">";
					echo "<img src=\"_img/pencil.png\" alt=\"Edit\" />";
					echo "</a>";

					echo "<a href=\"#\" onclick=\"Radi.deleteMenuItem('{$array2['id']}');\">";
					echo "<img src=\"_img/minus.png\" alt=\"Delete\" />";
					echo "</a>";

				}
				
				echo "</div>";

				echo $array2['text'];
	
				echo "</div>";
	
				$j++;
	
				if( $j == "c" ) {
	
					$j = "a";
	
				}
	
			}

		}

	?>

</div>