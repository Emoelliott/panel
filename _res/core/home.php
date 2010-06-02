<?php
	
	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }
	
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