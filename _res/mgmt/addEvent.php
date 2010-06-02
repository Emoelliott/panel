<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM events WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addEvent">

	<div class="box">

		<div class="square title">
			<strong>Add event</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$name  = $core->clean( $_POST['name'] );
					$day   = $core->clean( $_POST['day'] );
					$time  = $core->clean( $_POST['time'] );
					$hotel = $core->clean( $_POST['hotel'] ); 
					$host  = $core->clean( $_POST['host'] );

					if( !$name or !$day or !$time or !$hotel or !$host ) {

						throw new Exception( "All fields are required." );

					}
					else {

						if( $editid ) {

							$db->query( "UPDATE events SET name = '{$name}', day = '{$day}', time = '{$time}', hotel = '{$hotel}', host = '{$host}' WHERE id = '{$editid}'" );

						}
						else {

							$db->query( "INSERT INTO events VALUES (NULL, '{$name}', '{$day}', '{$time}', '{$hotel}', '{$host}');" );

						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Event added!";
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

				$hotels = array( "Habbo UK", "Habbo US", "Habbo CA", "Habbo AU", "Habbo SG" );

				foreach( $hotels as $key => $value ) {

					if( $value == $data['hotel'] ) {

						$hotels[$value . '_active'] = $value;

					}
					else {
					
						$hotels[$value] = $value;
					
					}

					unset( $hotels[$key] );

				}

				$days = array( 1 => "Monday",
							   2 => "Tuesday",
							   3 => "Wednesday",
							   4 => "Thursday",
							   5 => "Friday",
							   6 => "Saturday",
							   7 => "Sunday" );

				foreach( $days as $key => $value ) {

					if( $key == $data['day'] ) {

						$days[$key . '_active'] = $value;
						
						unset( $days[$key] );

					}

				}

				echo $core->buildField( "text",
										"required",
										"name",
										"Name",
										"The event's name.",
										$data['name'] );


				echo $core->buildField( "select",
										"required",
										"day",
										"Day",
										"The event's day.",
										$days );

				echo $core->buildField( "text",
										"required",
										"time",
										"Time",
										"The event's time.",
										$data['time'] );

				echo $core->buildField( "select",
										"required",
										"hotel",
										"Hotel",
										"The event's hotel.",
										$hotels );

				echo $core->buildField( "text",
										"required",
										"host",
										"Host",
										"The event's host.",
										$data['host'] );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('addEvent');

?>