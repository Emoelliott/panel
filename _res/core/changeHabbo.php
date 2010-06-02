<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post" id="changeHabbo">

	<div class="box">

		<div class="square title">
			<strong>Change Habbo name</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$habbo = $core->clean( $_POST['habbo'] );

					if( !$habbo ) {

						throw new Exception( "All fields are required." );

					}
					else {

						$db->query( "UPDATE users SET habbo = '{$habbo}' WHERE id = '{$user->data['id']}'" );

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Habbo name successfully changed!";
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
										"required",
										"habbo",
										"Habbo name",
										"Your new Habbo name.",
										$user->data['habbo'] );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('changeHabbo');
?>