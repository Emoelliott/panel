<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post" id="djSays">

	<div class="box">

		<div class="square title">
			<strong>Update DJ says</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$message = $core->clean( $_POST['djsays'] );

					if( !$message ) {

						throw new Exception( "All fields are required." );

					}
					else {
						
						$ip = $_SERVER['REMOTE_ADDR'];
						
						$db->query( "INSERT INTO dj_says VALUES (NULL, '{$message}', '{$user->data['id']}', '{$ip}');" );

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "DJ says successfully updated!";
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

				$query = $db->query( "SELECT * FROM dj_says ORDER BY id DESC" );
				$array = $db->assoc( $query );
	
				$djSays = $array['message'];

				echo $core->buildField( "text",
										"required",
										"djsays",
										"New DJ says",
										"The new DJ says to display.",
										$djSays );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('djSays');
?>