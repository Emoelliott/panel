<?php
	require_once( "../_inc/glob.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>

		<title>radiPanel Events Timetable</title>

		<style type="text/css" media="screen">

			body {

				background: #ddeef6;
				padding: 0;
				margin: 0;

			}

			body, input, select, textarea {

				font-family: Verdana, Tahoma, Arial;
				font-size: 11px;
				color: #333;

			}

			form {

				padding: 0;
				margin: 0;

			}

			.wrapper {

				background-color: #fcfcfc;
				width: 450px;
				margin: auto;
				padding: 5px;
				margin-top: 15px;

			}

			.title {

				padding: 5px;	
				margin-bottom: 5px;
				font-size: 14px;
				font-weight: bold;
				background-color: #eee;
				color: #444;

			}

			.content {

				padding: 5px;

			}

			.good, .bad {

				padding: 5px;	
				margin-bottom: 5px;

			}

			.good strong, .bad strong {

				font-size: 14px;
				font-weight: bold;

			}

			.good {

				background-color: #d9ffcf;
				border-color: #ade5a3;
				color: #1b801b;

			}

			.bad {

				background-color: #ffcfcf;
				border-color: #e5a3a3;
				color: #801b1b;

			}

			input, select, textarea {

				border: 1px #e0e0e0 solid;
				border-bottom-width: 2px;
				padding: 3px;

			}

			input {

				width: 170px;

			}

			input.button {

				width: auto;
				cursor: pointer;
				background: #eee;

			}

			select {

				width: 176px;

			}

			textarea {

				width: 288px;

			}

			label {

				display: block;
				padding: 3px;

			}

		</style>

	</head>

	<body>

		<?php

			for( $i = 1; $i <= 7; $i++ ) {

				$query  = $db->query( "SELECT * FROM events WHERE day = '{$i}'" );
				$num    = $db->num( $query );

				$events = array();

				$day    = strtotime( "november {$i} 2010" );
				$day    = date( "l", $day );

				while( $array = $db->assoc( $query ) ) {

					$time = strtotime( "{$array['time']} november {$i} 2010" );

					$events[$time] = $array['id'];

				}

				arsort( $events );

		?>

		<div class="wrapper">

			<div class="title">

				<?php

					echo $day;

				?>

			</div>


			<?php

				if( $num != 0 ) {

			?>

			<table width="100%" cellpadding="3" cellspacing="1">

					<tr style="background: #e9e9e9; font-weight: bold;">

						<td width="40%">
							Event Name
						</td>

						<td width="25%">
							Host
						</td>

						<td width="20%">
							Hotel
						</td>

						<td width="15%">
							Time
						</td>

					</tr>

					<?php

						foreach( $events as $key => $value ) {

							$query2 = $db->query( "SELECT * FROM events WHERE id = '{$value}'" );
							$array2 = $db->assoc( $query2 );

					?>

					<tr style="background: #f3f3f3;">

						<td width="40%">
							<?php
								echo $array2['name'];
							?>
						</td>

						<td width="25%">
							<?php
								echo $array2['host'];
							?>
						</td>

						<td width="20%">
							<?php
								echo $array2['hotel'];
							?>
						</td>

						<td width="15%">
							<?php
								echo $array2['time'];
							?>
						</td>

					</tr>

				<?php

					}

				?>

				</table>

				<?php

					} else {

						echo "<center>";
						echo "There are no events for today!";
						echo "</center>";

					}

				?>

			</div>

		<?php
			}

		?>

	</body>

</html>