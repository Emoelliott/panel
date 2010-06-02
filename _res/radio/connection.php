<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	$query = $db->query( "SELECT * FROM connection_info ORDER BY id DESC LIMIT 1" );
	$array = $db->assoc( $query );

?>
<div class="box">

	<div class="square title">
		<strong>Connection information</strong>
	</div>

	<div class="content">

		<strong>Connection IP:</strong>
		<br />
		<?php
			echo $array['host'];
		?>
		
		<br /><br />
		
		<strong>Connection port:</strong>
		<br />
		<?php
			echo $array['port'];
		?>
		
		<br /><br />
		
		<strong>Connection password:</strong>
		<br />
		<?php
			echo $array['password'];
		?>

	</div>

</div>