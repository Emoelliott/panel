<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM news_categories WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addNewsCat">

	<div class="box">

		<div class="square title">
			<strong>Add news categories</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$name = $core->clean( $_POST['name'] );

					if( $_POST['status'] == "1" ) {

						$status = "1";

					}
					else {

						$status = "0";

					}

					if( !$name ) {

						throw new Exception( "All fields are required." );

					}
					else {

						if( $editid ) {

							$db->query( "UPDATE news_categories SET name = '{$name}', admin = '{$status}' WHERE id = '{$editid}'" );

						}
						else {

							$db->query( "INSERT INTO news_categories VALUES (NULL, '{$name}', '{$status}');" );

						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "News category added!";
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

				$options = array( "Normal", "Admin only" );

				foreach( $options as $key => $value ) {

					if( $key == $data['admin'] ) {

						$options[$key . '_active'] = $value;

						unset( $options[$key] );

					}

				}

				echo $core->buildField( "text",
										"required",
										"name",
										"Name",
										"The new category name.",
										$data['name'] );


				echo $core->buildField( "select",
										"required",
										"status",
										"Status",
										"The category's status.",
										$options );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('addNewsCat');

?>