<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Staff emails</strong>
	</div>

	<?php
		
		$query = $db->query( "SELECT * FROM users ORDER BY displaygroup DESC" );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {
			
			$array2 = $user->getInfo( $array['id'] );

			echo "<div class=\"row {$j}\">";

			echo "<span style=\"float: right;\">";
			echo $array2['email'] ? $array2['email'] : 'N/A';
			echo "</span>";

			echo $array2['fullUsernameURL'];

			echo "</div>";

			$j++;

			if( $j == "c" ) {

				$j = "a";

			}

		}

	?>

</div>