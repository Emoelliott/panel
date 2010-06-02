<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Logging out</strong>
	</div>

	<div class="content">

		<?php
		
			$user->destroySession();
		
		?>
		
		Session destroyed. Thank you for visiting, <strong><?php echo $user->data['fullUsername']; ?></strong>.
		
		<?php
			echo $core->redirect( "./", 5 );
		?>
		
	</div>

</div>