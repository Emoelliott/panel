<?php
	
	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }
	
	$query = $db->query( "SELECT * FROM announcements WHERE active = '1' ORDER BY stamp DESC" );
	
	while( $array = $db->assoc( $query ) ) {
	
?>

<div class="box">

	<div class="square title">
		<strong><?php echo $array['title']; ?></strong>
	</div>

	<div class="content">

		<?php echo nl2br( $core->parseBBCode( $array['message'] ) ); ?>

	</div>

</div>

<?php

	}

?>

<div class="box">

	<div class="square title">
		<strong>Home</strong>
	</div>

	<div class="content">
	
		Welcome, <strong><?php echo $user->data['fullUsername']; ?></strong>!
		<br /><br />
		This page can be edited in _res/core/home.php.
	
	</div>

</div>