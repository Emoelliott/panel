<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<form action="" method="post" id="changeConnection">

	<div class="box">

		<div class="square title">
			<strong>Change connection information</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {

					$host     = $core->clean( $_POST['host'] );
					$port     = $core->clean( $_POST['port'] );
					$password = $core->clean( $_POST['password'] );

					if( !$host or !$port or !$password ) {

						throw new Exception( "All fields are required." );

					}
					else {

						$ip = $_SERVER['REMOTE_ADDR'];

						$db->query( "INSERT INTO connection_info VALUES (NULL, '{$host}', '{$port}', '{$password}', '{$user->data['id']}', '{$ip}'); " );

						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Connection information updated!";
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
										"host",
										"IP Address",
										"The IP address of your radio server." );

				echo $core->buildField( "text",
										"required",
										"port",
										"Port",
										"The port of your radio server." );

				echo $core->buildField( "password",
										"required",
										"password",
										"Password",
										"The password of your radio server." );


			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>
<?php
	
	echo $core->buildFormJS( 'changeConnection' );
	
?>

<div class="box">
	
	<div class="square title">
	
		<strong>Past changes</strong>
	
	</div>
	
	<?php
	
		$query = $db->query( "SELECT * FROM connection_info ORDER BY id DESC LIMIT 1, 3" );
		
		$i = "a";
		
		while( $array = $db->assoc( $query ) ) {
			
			$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['user']}'" );
			$array2 = $db->assoc( $query2 );
			
			echo "<div class=\"row {$i}\">";
			
			echo "Change made by <strong>{$array2['username']}</strong> ({$array['ip']}):";
			echo "<br />";
			echo "<strong>IP:</strong> {$array['host']}";
			echo "<br />";
			echo "<strong>Port:</strong> {$array['port']}";
			echo "<br />";
			echo "<strong>Password:</strong> {$array['password']}";
			
			echo "</div>";
			
			$i++;
			
			if( $i == "c" ) {
			
				$i = "a";
			
			}
		
		}
	
	?>
	
</div>