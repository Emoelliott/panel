<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {

		$id = $core->clean( $_GET['id'] );

		$query = $db->query( "SELECT * FROM timetable WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );

		$editid = $data['id'];

	}

?>
<form action="" method="post" id="addPermShow">

	<div class="box">

		<div class="square title">
			<strong>Add permanent show</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$day  = $core->clean( $_POST['day'] );
					$time = $core->clean( $_POST['time'] );
					$dj   = $core->clean( $_POST['dj'] ); 

					if( !$day or !$time or !$dj ) {

						throw new Exception( "All fields are required." );

					}
					else {

						if( $editid ) {

							$db->query( "UPDATE timetable SET day = '{$day}', time = '{$time}', dj = '{$dj}' WHERE id = '{$editid}'" );

						}
						else {

							$db->query( "INSERT INTO timetable VALUES (NULL, '{$day}', '{$time}', '{$dj}', '1');" );

						}

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Permanent show added!";
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

				for( $j = 0; $j <= 23; $j++ ) {

					if( $j < 10 ) {

						$time = "0{$j}:00";

					}
					else {

						$time = "{$j}:00";

					}

					$times[] = $time;

				}
				
				foreach( $times as $key => $value ) {
					
					if( $key == $data['time'] ) {
						
						$times[$key . '_active'] = $value;
						
						unset( $times[$key] );
						
					}
					
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

				$query = $db->query( "SELECT * FROM users" );
				
				while( $array = $db->assoc( $query ) ) {
					
					$djs[$array['id']] = $array['username'];
					
				}

				foreach( $djs as $key => $value ) {

					if( $key == $data['dj'] ) {

						$djs[$key . '_active'] = $value;

						unset( $djs[$key] );

					}

				}


				echo $core->buildField( "select",
										"required",
										"day",
										"Day",
										"The slot's day.",
										$days );

				echo $core->buildField( "select",
										"required",
										"time",
										"Time",
										"The slot's time.",
										$times );

				echo $core->buildField( "select",
										"required",
										"dj",
										"DJ",
										"The slot's DJ.",
										$djs );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	
	echo $core->buildFormJS('addPermShow');

?>