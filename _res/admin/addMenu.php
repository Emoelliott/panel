<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM menu WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );

		if( $data['protected'] == "1" ) {
			
			echo "Protected";
			die();
			
		}

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addMenuItem">

	<div class="box">

		<div class="square title">
			<strong>Add menu item</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$text     = $core->clean( $_POST['text'] );
					$url      = $core->clean( $_POST['url'] );
					$resource = $core->clean( $_POST['resource'] );
					$ugroup   = $core->clean( $_POST['ugroup'] );

					if( !$text or !$url or !$resource or !$ugroup ) {

						throw new Exception( "All fields are required." );

					}
					else {

						if( $editid ) {

							$db->query( "UPDATE menu SET text = '{$text}', url = '{$url}', resource = '{$resource}', usergroup = '{$ugroup}' WHERE id = '{$editid}'" );

						}
						else {

							$query = $db->query( "SELECT * FROM menu WHERE usergroup = '{$ugroup}' ORDER BY weight DESC LIMIT 1" );
							$array = $db->assoc( $query );

							$weight = $array['weight'] + 1;

							$db->query( "INSERT INTO menu VALUES (NULL, '{$text}', '{$url}', '{$resource}', '{$ugroup}', '0', '{$weight}');" );

						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Menu item added!";
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

					if( $array['id'] == $data['usergroup'] ) {

						$ugroups[$array['id'] . '_active'] = $array['name'];

					}
					else {

						$ugroups[$array['id']] = $array['name'];

					}
				
				}

				echo $core->buildField( "text",
										"required",
										"text",
										"Text",
										"The name of your menu item.",
										$data['text'] );


				echo $core->buildField( "text",
										"required",
										"url",
										"URL",
										"The menu's URL (usergroup.page).",
										$data['url'] );

				echo $core->buildField( "text",
										"required",
										"resource",
										"Resource",
										"The page's URL relative to index.php.",
										$data['resource'] ? $data['resource'] : '_res/' );

				echo $core->buildField( "select",
										"required",
										"ugroup",
										"Usergroup",
										"The usergroup for the page.",
										$ugroups );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('addMenuItem');

?>