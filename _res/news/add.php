<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

	if( $_GET['id'] ) {
		
		$id = $core->clean( $_GET['id'] );
		
		$query = $db->query( "SELECT * FROM news WHERE id = '{$id}'" );
		$data  = $db->assoc( $query );
		
		$editid = $data['id'];
		
	}

?>
<form action="" method="post" id="addNews">

	<div class="box">

		<div class="square title">
			<strong>Add news</strong>
		</div>

		<?php

			if( $_POST['submit'] ) {

				try {
					
					$title   = $core->clean( $_POST['title'] );
					$desc    = $core->clean( $_POST['desc'] );
					$cat     = $core->clean( $_POST['cat'] );
					$article = $core->clean( $_POST['article'] );
					$time    = time();

					if( !$title or !$desc or !$cat or !$article ) {

						throw new Exception( "All fields are required." );

					}
					else {
						
						if( $editid ) {
							
							$db->query( "UPDATE news SET title = '{$title}', `desc` = '{$desc}', category = '{$cat}', article = '{$article}' WHERE id = '{$editid}'");
							
						}
						else {
						
							$db->query( "INSERT INTO news VALUES (NULL, '{$cat}', '{$title}', '{$desc}', '{$article}', '{$user->data['id']}', '{$time}');" );
						
						}
						
						echo "<div class=\"square good\">";
						echo "<strong>Success</strong>";
						echo "<br />";
						echo "Article added!";
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

				$query = $db->query( "SELECT * FROM news_categories" );
				
				while( $array = $db->assoc( $query ) ) {
					
					if( $array['admin'] != '1' or ( $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) ) {
					
						if( $array['id'] == $data['category'] ) {
						
							$cats[$array['id'] . "_active"] = $array['name'];
							
						}
						else {
						
							$cats[$array['id']] = $array['name'];
						
						}
					
					}
					
				}

				echo $core->buildField( "text",
										"required",
										"title",
										"Title",
										"Your article's name.",
										$data['title'] );

				echo $core->buildField( "text",
										"required",
										"desc",
										"Description",
										"A short description of your article.",
										$data['desc'] );

				echo $core->buildField( "select",
										"required",
										"cat",
										"Category",
										"Your article's category.",
										$cats );

				echo $core->buildField( "big_textarea",
										"required",
										"article",
										"Article",
										"Your article for the site.",
										$data['article'] );

			?>
		</table>

	</div>

	<div class="box" align="right">

		<input class="button" type="submit" name="submit" value="Submit" />

	</div>

</form>

<?php
	echo $core->buildFormJS('addNews');
?>