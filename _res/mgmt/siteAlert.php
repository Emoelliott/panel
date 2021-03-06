<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post">

	<div class="box">

		<div class="square title">
			<strong>Alert website</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$message = $core->clean( $_POST['message'] );

					if( !$message ) {

						throw new Exception( "All fields are required." );

					}
					else {

						$time = time();

						$db->query( "INSERT INTO site_alerts VALUES (NULL, '{$message}', '{$user->data['id']}', '{$time}'); " );

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Alert sent!";
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
										"Message",
										"Your message for the site." );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>