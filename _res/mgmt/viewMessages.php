<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	$query = $db->query( "SELECT * FROM mgmt_messages ORDER BY id DESC LIMIT 5" );
	
	while( $array = $db->assoc( $query ) ) {
	
		$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['user']}'" );
		$array2 = $db->assoc( $query2 );
	
?>
<div class="box">

	<div class="square title">
		<strong>Message from <?php echo $array2['username']; ?></strong>
	</div>

	<div class="content">

		&quot;<?php echo $array['message']; ?>&quot;

	</div>

</div>
<?php
	}
?>