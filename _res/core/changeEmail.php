<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post" id="changeEmail">

	<div class="box">

		<div class="square title">
			<strong>Change email</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$email = $core->clean( $_POST['email'] );

					if( !$email ) {

						throw new Exception( "All fields are required." );

					}
					elseif( !preg_match("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$^", $email) ) {

						throw new Exception( "That's an invalid email address." );

					}
					else {

						$db->query( "UPDATE users SET email = '{$email}' WHERE id = '{$user->data['id']}'" );

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Email successfully changed!";
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
			
				echo $core->buildField( "text",
										"required validate-email",
										"email",
										"Email",
										"Your new email.",
										$user->data['email'] );
										
			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('changeEmail');
?>