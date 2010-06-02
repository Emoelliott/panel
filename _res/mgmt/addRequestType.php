<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM request_types WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addRequestType">

	<div class="box">

		<div class="square title">
			<strong>Add request type</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$name   = $core->clean( $_POST['name'] );
					$colour = $core->clean( $_POST['colour'] );

					$colour = str_replace( "#", "", $colour );

					if( !$name or !$colour ) {

						throw new Exception( "All fields are required." );

					}
					else {

						if( $editid ) {

							$db->query( "UPDATE request_types SET name = '{$name}', colour = '{$colour}' WHERE id = '{$editid}'" );

						}
						else {

							$db->query( "INSERT INTO request_types VALUES (NULL, '{$name}', '{$colour}');" );

						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Request type added!";
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
										"name",
										"Name",
										"The request type's name.",
										$data['name'] );

				echo $core->buildField( "text",
										"required",
										"colour",
										"Colour",
										"The colour associated with the type.",
										$data['colour'] );


			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php

	echo $core->buildFormJS('addRequestType');

?>