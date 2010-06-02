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
			
			$query2 = $db->query( "SELECT * FROM usergroups WHERE id = '{$array['displaygroup']}'" );
			$array2 = $db->assoc( $query2 );

			echo "<div class=\"row {$j}\">";

			echo "<span style=\"float: right;\">";
			echo $array['email'] ? $array['email'] : 'N/A';
			echo "</span>";

			echo "<span style=\"font-weight: bold; color: #{$array2['colour']};\">";
			echo $array['username'];
			echo "</span> ";
			
			echo "(" . ( $array['habbo'] ? $array['habbo'] : 'N/A' ) . ")";

			echo "</div>";

			$j++;

			if( $j == "c" ) {

				$j = "a";

			}

		}

	?>

</div>