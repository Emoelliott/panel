<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	$user  = $_GET['id'] ? $core->clean( $_GET['id'] ) : $core->clean( $_GET['user'] );
	$query = $db->query( "SELECT * FROM users WHERE id = '{$user}' OR username = '{$user}'" );
	$array = $db->assoc( $query );
	
	$user  = $db->num( $query ) == 0 ? 'Sorry' : $array['username'];
	
?>
<div class="box">

	<div class="square title">
		<strong><?php echo $user; ?></strong>
	</div>

	<div class="content">

		<?php
		
			if( $db->num( $query ) != 0 ) {
		?>
		
		<strong>Email address:</strong>
		<br />
		<?php echo $array['email']; ?>
		
		<?php
		
				$query2 = $db->query( "SELECT t1.*, t2.name FROM fields_data AS t1 INNER JOIN fields AS t2 WHERE t1.uid = '{$array['id']}' AND t2.id = t1.fid" );
				while( $array2 = $db->assoc( $query2 ) ) {
				
		?>
		
		<br /><br />
		<strong><?php echo $array2['name']; ?>:</strong>
		<br />
		<?php echo $array2['value']; ?>
		
		<?php
				
				}
		
			}
			else {
		
		?>
		
		Unfortunately we're unable to find that user.
		
		<?php
		
			}
		
		?>

	</div>

</div>