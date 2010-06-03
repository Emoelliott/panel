<?php

	require_once( "_inc/glob.php" );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	
	<head>
	
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		
		<title>radiPanel</title>
		
		<script type="text/javascript" src="_js/prototype.js"></script>
		<script type="text/javascript" src="_js/scriptaculous.js"></script>
		<script type="text/javascript" src="_js/validation.js"></script>
		<script type="text/javascript" src="_js/radi.js"></script>
		
		<style type="text/css" media="screen">@import url('_img/style.css');</style>
		
	</head>
	
	<body>
		
			<?php
				
				if( $user->loggedIn ) {
				
			?>
			
		<div style="width: 800px; margin: auto;">
			
			<div>
				
				<div style="float: right; width: 400px; text-align: right; padding-top: 12px;">
				
					Welcome, <strong><?php echo $user->data['fullUsername']; ?></strong>!
				
				</div>
				
				<big>radiPanel</big>
			
			</div>
			
			<div style="float: left; width: 200px;">
			
				<?php

					$url = $_GET['url'] ? $core->clean( $_GET['url'] ) : 'core.home';

					$query3 = $db->query( "SELECT * FROM menu WHERE url = '{$url}'" );
					$array3 = $db->assoc( $query3 );

					if( !$array3['usergroup'] ) {
					
						$array3['usergroup'] = "invalid";
					
					}

					$query = $db->query( "SELECT * FROM usergroups ORDER BY weight ASC" );

					while( $array = $db->assoc( $query ) ) {

						if( in_array( $array['id'], $user->data['uGroupArray'] ) ) {

				?>

				<div class="box">

					<div class="square menu" style="background: #<?php echo $array['colour']; ?>;" onclick="Radi.menuToggle('<?php echo $array['id']; ?>');">
						
						<img id="menutoggle_<?php echo $array['id']; ?>" class="menutoggle" src="_img/<?php echo ( $array['id'] != $array3['usergroup'] ) ? 'plus' : 'minus'; ?>_white.png" alt="Toggle" align="right" />

						<strong><?php echo $array['name']; ?></strong>
					
					</div>

					<div class="menuitems"<?php if( $array['id'] != $array3['usergroup'] ) { ?> style="display: none;"<?php } ?> id="mitems_<?php echo $array['id']; ?>">

					<?php
						
						$query2 = $db->query( "SELECT * FROM menu WHERE usergroup = '{$array['id']}' ORDER BY weight ASC" );
						
						$i      = "a";
						
						while( $array2 = $db->assoc( $query2 ) ) {
						
					?>

						<a href="<?php echo $array2['url']; ?>" class="<?php echo $i; ?>">
							<?php echo $array2['text']; ?>
						</a>

					<?php
							$i++;
							
							if( $i == "c" ) {
							
								$i = "a";
							
							}
						
						}
					?>
					
					</div>

				</div>

				<?php

						}

					}
					
					$query = $db->query( "SELECT DISTINCT user_id FROM sessions WHERE user_id != '0'" );

				?>
				
				<div class="box">

					<div class="square title">
						<strong>Users online (<?php echo $db->num( $query ); ?>)</strong>
					</div>

					<div class="content">

						<?php

							$i = 1;

							while( $array = $db->assoc( $query ) ) {

								$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['user_id']}'" );
								$array2 = $db->assoc( $query2 );

								$query4 = $db->query( "SELECT * FROM usergroups WHERE id = '{$array2['displaygroup']}'" );
								$array4 = $db->assoc( $query4 );

								echo "<span style=\"color: #{$array4['colour']}; font-weight: bold;\">";
								echo $array2['username'];
								echo "</span>";
								echo ( $i == $db->num( $query ) ) ? '' : ', ';

								$i++;

							}

						?>

					</div>

				</div>

			</div>


			<div style="float: left; width: 590px; padding-left: 10px;">
			
				<?php
					
					if( $url == "profiles" ) {
					
						@include_once( "_res/core/profiles.php" );
					
					}
					elseif( !in_array( $array3['usergroup'], $user->data['uGroupArray'] ) ) {
						
						echo "Permission denied.";
					
					}
					elseif( !@include_once( $array3['resource'] ) ) {
					
						echo "Error has occurred looking for " . $array3['resource'];
					
					}

				?>
			
			</div>
			
			<br clear="all" />
			
		</div>
			
			<?php
				
				}
				else {
				
			?>

		<div style="width: 500px; margin: auto;">

			<big>
				Log in
			</big>
			
			
			<form method="post" action="" id="login">
				
				<div class="box">

				<?php
					if( $_POST['submit'] ) {

						try {

							$username = $_POST['username'];
							$password = $_POST['password'];
							$user->login( $username, $password );
							echo $core->redirect( "?" );

						}
						catch( UserException $e ) {

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
													"username",
													"Username",
													"Your username." );
							
							echo $core->buildField( "password",
													"required",
													"password",
													"Password",
													"Your password." );
						
						?>
	
					</table>	
				
				</div>
	
				<div class="box" align="right">
	
					<input class="button" type="submit" name="submit" value="Log in" />
	
				</div>
			
			</form>
			
			</div>

		</div>
			<?php

					echo $core->buildFormJS("login");
	
				}
	
			?>
	
	</body>
	
</html>