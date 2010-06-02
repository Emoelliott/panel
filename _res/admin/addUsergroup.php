<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM usergroups WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addUsergroup">

	<div class="box">

		<div class="square title">
			<strong>Add usergroup</strong>
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

							$db->query( "UPDATE usergroups SET name = '{$name}', colour = '{$colour}' WHERE id = '{$editid}'" );

						}
						else {

							$query = $db->query( "SELECT * FROM usergroups ORDER BY weight DESC LIMIT 1" );
							$array = $db->assoc( $query );

							$weight = $array['weight'] + 1;

							$db->query( "INSERT INTO usergroups VALUES (NULL, '{$name}', '{$colour}', '{$weight}');" );

						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Usergroup added!";
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

	echo $core->buildFormJS('addUsergroup');

?>