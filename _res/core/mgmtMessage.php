<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post">

	<div class="box">

		<div class="square title">
			<strong>Send a message to the management</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$message = $core->clean( $_POST['message'] );

					if( !$message ) {

						throw new Exception( "All fields are required." );

					}
					else {

						$db->query( "INSERT INTO mgmt_messages VALUES (NULL, '{$message}', '{$user->data['id']}'); " );

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Message sent to the management members!";
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

				echo $core->buildField( "textarea",
										"required",
										"message",
										"Message to management",
										"Your message to the management." );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>