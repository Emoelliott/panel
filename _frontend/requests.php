<?php
	require_once( "../_inc/glob.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>

		<title>radiPanel Request Line</title>

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
				width: 300px;
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

			.good, .bad {
			
				padding: 5px;	
				margin-bottom: 5px;
			
			}
			
			.good strong, .bad strong {
			
				font-size: 12px;
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

		<div class="wrapper">

			<div class="title">
				Request line
			</div>

			<?php
				
				if( $_POST['submit'] ) {
					
					try {
					
						$habbo   = $core->clean( $_POST['habbo'] );
						$type    = $core->clean( $_POST['type'] );
						$dj      = $core->clean( $_POST['dj'] );
						$request = $core->clean( $_POST['request'] );
						$ip      = $_SERVER['REMOTE_ADDR'];
						$time    = time();
	
						if( !$habbo or !$type or !$dj or !$request or !is_numeric( $dj ) or !is_numeric( $type ) ) {
	
							throw new Exception( "All fields are required" );
	
						}
						else {
						
							$db->query( "INSERT INTO requests VALUES (NULL, '{$type}', '{$dj}', '{$habbo}', '{$request}', '{$time}', '{$ip}');" );

							echo "<div class=\"good\">";
							echo "<strong>Success</strong>";
							echo "<br />";
							echo "Request sent!";
							echo "</div>";

						}
					
					}
					catch( Exception $e ) {
					
						echo "<div class=\"bad\">";
						echo "<strong>Error</strong>";
						echo "<br />";
						echo $e->getMessage();
						echo "</div>";
					
					}
					
				}
				
			?>

			<form action="" method="post">
			
				<label for="habbo">Habbo name:</label>
				<input type="text" name="habbo" id="habbo" maxlength="255" />
				
				<br /><br />
				
				<label for="type">Message type:</label>
				<select name="type" id="type">
				
					<?php
						
						$query = $db->query( "SELECT * FROM request_types" );
						
						while( $array = $db->assoc( $query ) ) {
						
					?>
					
					<option value="<?php echo $array['id']; ?>">
						<?php echo $array['name']; ?>
					</option>
					
					
					<?php
						
						}
						
					?>
				
				</select>
			
				<br /><br />
				
				<label for="dj">DJ:</label>
				<select name="dj" id="dj">

					<?php

						$query  = $db->query( "SELECT * FROM connection_info ORDER BY id DESC LIMIT 1" );
						$array  = $db->assoc( $query );
						
						$info   = $core->radioInfo( "http://{$array['host']}:{$array['port']}" );

						$query2 = $db->query( "SELECT * FROM users" );

						while( $array2 = $db->assoc( $query2 ) ) {

					?>

					<option<?php if( preg_match( "/{$array2['username']}/", $info['streamtitle'] ) ) { ?> selected="selected"<?php } ?> value="<?php echo $array2['id']; ?>">
						DJ <?php echo $array2['username']; ?>
					</option>


					<?php

						}

					?>

				</select>
				
				<br /><br />
				
				<label for="request">Request:</label>
				<textarea name="request" id="request" rows="5"></textarea>
				
				<br /><br />
				
				<input class="button" type="submit" name="submit" value="Submit" />
				
			</form>

		</div>

	</body>

</html>