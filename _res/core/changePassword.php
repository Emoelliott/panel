<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post" id="changePassword">

	<div class="box">
	
		<div class="square title">
			<strong>Change password</strong>
		</div>

		<?php
		
			if( $_POST['submit'] ) {
	
				try {
	
					$oldpassword     = $core->clean( $_POST['current_password'] );
					$oldpassword_enc = $core->encrypt( $oldpassword );
	
					$newpassword     = $core->clean( $_POST['new_password'] );
					$newpassword_enc = $core->encrypt( $newpassword );
	
					if( !$oldpassword or  !$newpassword) {
	
						throw new Exception( "All fields are required." );
	
					}
					elseif( $oldpassword_enc != $user->data['password'] ) {
	
						throw new Exception( "The password you entered does not match the one we have on record." );
	
					}
					else {
	
						$db->query( "UPDATE users SET password = '{$newpassword_enc}' WHERE id = '{$user->data['id']}'" );
						
						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Password successfully changed!";
						echo "</div>";
	
					}
	
				}
				catch( Exception $e ) {
	
					echo "<div class=\"square bad\">";
					echo "<strong>Error</strong>";
					echo "<br />";
					echo $e->getMessage();
					echo "</div>";
	
				}
	
			}
		
		?>

		<table width="100%" cellpadding="3" cellspacing="0">
			<?php
				echo $core->buildField( "password",
										"required",
										"current_password",
										"Current password",
										"Your current password." );


				echo $core->buildField( "password",
										"required",
										"new_password",
										"New password",
										"Your desired new password." );
			?>
		</table>
	
	</div>
	
	<div class="box" align="right">
	
		<input class="button" type="submit" name="submit" value="Submit" />
	
	</div>

</form>

<?php
	echo $core->buildFormJS('changePassword');
?>