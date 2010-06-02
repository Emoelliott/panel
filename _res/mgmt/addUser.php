<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM users WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );
		
		$data['ugroups'] = explode( ",", $data['usergroups'] );

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addUser">

	<div class="box">

		<div class="square title">
			<strong>Add user</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$username = $core->clean( $_POST['username'] );
					$password = $core->clean( $_POST['password'] );
					$email    = $core->clean( $_POST['email'] );
					$habbo    = $core->clean( $_POST['habbo'] );
					$dgroup   = $core->clean( $_POST['dgroup'] );
					
					$query    = $db->query( "SELECT * FROM usergroups" );
					
					while( $array = $db->assoc( $query ) ) {
					
						if( $_POST['ugroup-' . $array['id']] ) {
							
							$ugroups .= $array['id'] . ",";
							
						}
					
					}
					
					$password_enc = $core->encrypt( $password );

					if( !$username or ( !$password and !$editid ) or !$dgroup or !$ugroups ) {

						throw new Exception( "All fields are required." );

					}
					else {

						if( $editid ) {

							if( $password ) {
								
								$password = ", password = '{$password_enc}'";
								
							}
							else {
								
								unset( $password );
								
							}

							$db->query( "UPDATE users SET username = '{$username}'{$password}, email = '{$email}', habbo = '{$habbo}', displaygroup = '{$dgroup}', usergroups = '{$ugroups}' WHERE id = '{$editid}'" );

						}
						else {
						
							$db->query( "INSERT INTO users VALUES (NULL, '{$username}', '{$password_enc}', '{$email}', '{$habbo}', '{$dgroup}', '{$ugroups}');" );
						
						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "User added!";
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

				$query = $db->query( "SELECT * FROM usergroups" );
				
				while( $array = $db->assoc( $query ) ) {
					
					if( in_array( $array['id'], $data['ugroups'] ) ) {
						
						$groups[$array['id'] . '_active'] = $array['name'];
					
					}
					else {
					
						$groups[$array['id']] = $array['name'];
					
					}
					
					if( $array['id'] == $data['displaygroup'] ) {
					
						$dgroups[$array['id'] . '_active']  = $array['name'];
					
					}
					else {
					
						$dgroups[$array['id']]  = $array['name'];
					
					}
					
				}

				echo $core->buildField( "text",
										"required",
										"username",
										"Username",
										"The new username.",
										$data['username'] );

				echo $core->buildField( "password",
										"<?php if( !$editid ) { ?>required<?php } ?>",
										"password",
										"Password",
										"The new password." );

				echo $core->buildField( "text",
										"",
										"email",
										"Email",
										"The new email (optional).",
										$data['email'] );
										
				echo $core->buildField( "text",
										"",
										"habbo",
										"Habbo name",
										"The new Habbo name (optional).",
										$data['habbo'] );

				echo $core->buildField( "select",
										"required",
										"dgroup",
										"Display group",
										"The user's display group.",
										$dgroups );

				echo $core->buildField( "checkbox",
										"required",
										"ugroup",
										"Active usergroups",
										"The user's active groups.",
										$groups );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('addUser');

?>