<?php
	require_once( "../_inc/core.inc.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>

		<title>radiPanel Installer</title>

		<script type="text/javascript" src="../_js/prototype.js"></script>
		<script type="text/javascript" src="../_js/scriptaculous.js"></script>
		<script type="text/javascript" src="../_js/validation.js"></script>
		<script type="text/javascript" src="../_js/radi.js"></script>

		<style type="text/css" media="screen">@import url('../_img/style.css');</style>		
		<style type="text/css" media="screen">
			
			#wrap {
			
				width: 600px;
				margin: auto;
			
			}
			
		</style>

	</head>

	<body>
	
	<div id="wrap">

		<form action="" method="post" id="installer">

			<big>radiPanel Installer</big>

			<?php
	
				if( $_POST['submit'] ) {
	
					try {
	
						$sql_hostname   = $core->clean( $_POST['sql_hostname'] );
						$sql_username   = $core->clean( $_POST['sql_username'] );
						$sql_password   = $core->clean( $_POST['sql_password'] );
						$sql_database   = $core->clean( $_POST['sql_database'] );
	
						$radio_ip       = $core->clean( $_POST['radio_ip'] );
						$radio_port     = $core->clean( $_POST['radio_port'] );
						$radio_password = $core->clean( $_POST['radio_password'] );
	
						$user_username  = $core->clean( $_POST['user_username'] );
						$user_password  = $core->clean( $_POST['user_password'] );
	
						$misc_timeout   = $core->clean( $_POST['misc_timeout'] );
	
						$salt1 = md5( mt_rand() );
						$salt1 = str_split( $salt1, 10 );
						$salt1 = $salt1[0];
	
						$salt2 = md5( mt_rand() );
						$salt2 = str_split( $salt2, 10 );
						$salt2 = $salt2[0];
	
						if( !$sql_hostname or !$sql_username or !$sql_database
							 or !$radio_ip or !$radio_port or !$radio_password
							 or !$user_username or !$user_password
							 or !$misc_timeout ) {
	
							throw new Exception( "All fields are required!" );
	
						}
						elseif( !$conn = @mysql_connect( $sql_hostname, $sql_username, $sql_password ) ) {
	
							throw new Exception( "Your MySQL server information seems to be invalid." );
	
						}
						elseif( !@mysql_select_db( $sql_database, $conn ) ) {
							
							throw new Exception( "Your MySQL database doesn't exist." );
	
						}
						else {
	
							$config = file_get_contents( "glob.php" );
	
							$config = str_replace( "conf_hostname", $sql_hostname, $config );
							$config = str_replace( "conf_username", $sql_username, $config );
							$config = str_replace( "conf_password", $sql_password, $config );
							$config = str_replace( "conf_database", $sql_database, $config );
	
							$config = str_replace( "conf_salt1", $salt1, $config );
							$config = str_replace( "conf_salt2", $salt2, $config );
	
							$config = str_replace( "conf_timeout", $misc_timeout, $config );
	
							file_put_contents( "../_inc/glob.php", $config );
	
							$sql = file( "_inst.sql" );
							
							foreach( $sql as $sql_line ) {
							
								if( trim($sql_line ) != "" and strpos( $sql_line, "--" ) === false ) {
								
									//echo $sql_line . "<br />";
									mysql_query( $sql_line );
								
								}
							
							}
							
							$user_password = $core->encrypt( $user_password );
							
							mysql_query( "INSERT INTO users VALUES (NULL, '{$user_username}', '{$user_password}', '', '', '5', '1,2,3,4,5');" );
							mysql_query( "INSERT INTO connection_info VALUES (NULL, '{$radio_ip}', '{$radio_port}', '{$radio_password}', '1', '{$_SERVER['REMOTE_ADDR']}');" );

							echo "<div class=\"box\">";
							echo "<div class=\"square good\" style=\"margin-bottom: 0px;\">";
							echo "<strong>Success</strong>";
							echo "<br />";
							echo "radiPanel has been successfully installed! Please delete the /_installer directory before using your panel.";
							echo "</div>";
							echo "</div>";
							
						}
	
					}
					catch( Exception $e ) {
	
						echo "<div class=\"box\">";
						echo "<div class=\"square bad\" style=\"margin-bottom: 0px;\">";
						echo "<strong>Error</strong>";
						echo "<br />";
						echo $e->getMessage();
						echo "</div>";
						echo "</div>";
	
					}
	
				}
			?>
	
			<div class="box">
	
				<div class="square title">
	
					<strong>MySQL Configuration</strong>
	
				</div>
	
	
				<div class="content">
	
					<table width="100%" cellpadding="3" cellspacing="0">
	
						<?php
	
							echo $core->buildField( "text",
													"required",
													"sql_hostname",
													"MySQL Hostname",
													"Your hostname (probably localhost).",
													"localhost" );

							echo $core->buildField( "text",
													"required",
													"sql_username",
													"MySQL Username",
													"Your MySQL username." );

							echo $core->buildField( "text",
													"notrequired",
													"sql_password",
													"MySQL Password",
													"Your MySQL password." );

							echo $core->buildField( "text",
													"required",
													"sql_database",
													"MySQL Database",
													"Your MySQL database's name." );

						?>
	
					</table>
	
				</div>
	
			</div>

			<div class="box">

				<div class="square title">

					<strong>Radio Configuration</strong>

				</div>


				<div class="content">

					<table width="100%" cellpadding="3" cellspacing="0">

						<?php

							echo $core->buildField( "text",
													"required",
													"radio_ip",
													"Radio IP",
													"Your radio server's IP or hostname." );

							echo $core->buildField( "text",
													"required",
													"radio_port",
													"Radio Port",
													"Your radio server's port." );

							echo $core->buildField( "text",
													"required",
													"radio_password",
													"Radio Password",
													"Your radio server's password." );

						?>

					</table>

				</div>

			</div>

			<div class="box">

				<div class="square title">

					<strong>User Configuration</strong>

				</div>


				<div class="content">

					<table width="100%" cellpadding="3" cellspacing="0">

						<?php

							echo $core->buildField( "text",
													"required",
													"user_username",
													"Username",
													"Your first user's username." );

							echo $core->buildField( "password",
													"required",
													"user_password",
													"Password",
													"Your first user's password." );

						?>

					</table>

				</div>

			</div>

			<div class="box">

				<div class="square title">

					<strong>Miscellaneous Configuration</strong>

				</div>


				<div class="content">

					<table width="100%" cellpadding="3" cellspacing="0">

						<?php

							$times = array( "10 minutes" => "10 minutes",
											"15 minutes" => "15 minutes",
											"20 minutes" => "20 minutes",
											"30 minutes" => "30 minutes",
											"45 minutes" => "45 minutes",
											"60 minutes" => "60 minutes" );

							echo $core->buildField( "select",
													"required",
													"misc_timeout",
													"Login Timeout",
													"Your panel's login timeout.",
													$times );

						?>

					</table>

				</div>

			</div>

			<div class="box" align="right">
			
				<input class="button" type="submit" name="submit" value="Submit" />
			
			</div>

		</form>

		<?php
		
			echo $core->buildFormJS( "installer" );
		
		?>

	</div>

	</body>

</html>