<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage news</strong>
	</div>

	<div class="content">
		
		Category:
		
		<select style="width: 150px;" onchange="window.location = '?cat=' + this.value">
			
			<option>Please select...</option>
			
			<?php
				
				$clause = ( $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) ? '' : "WHERE admin != '1'";
				
				$query = $db->query( "SELECT * FROM news_categories {$clause}" );
				
				while( $array = $db->assoc( $query ) ) {
			
					echo "<option value=\"{$array['id']}\">{$array['name']}</option>";
			
				}
			
			?>
			
		</select>
		
	</div>

	<?php

		if( $_GET['cat'] ) {
			
			$id = $core->clean( $_GET['cat'] );
			
			$clause = "WHERE category = '{$id}'";
			
		}

		$query = $db->query( "SELECT * FROM news {$clause}" );
		$num   = $db->num( $query );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			echo "<div class=\"row {$j}\" id=\"news_{$array['id']}\">";
			
			$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['author']}'" );
			$array2 = $db->assoc( $query2 );

			$query3 = $db->query( "SELECT * FROM news_categories WHERE id = '{$array['category']}'" );
			$array3 = $db->assoc( $query3 );

			echo "<a href=\"#\" onclick=\"Radi.deleteNews('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" align=\"right\" />";
			echo "</a>";

			echo "<a href=\"news.add?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" align=\"right\" />";
			echo "</a>";

			echo $array['title'];
			echo "<br />";
			echo "<span style=\"font-size: 10px;\">";
			echo "<em>Posted by ";
			echo "<strong>" . $array2['username'] . "</strong> on ";
			echo "<strong>" . date("d.m.Y", $array['stamp']) . "</strong> in ";
			echo "<strong>" . $array3['name'] . "</strong></em>";
			echo "</span>";
			
			echo "</div>";
			
			$j++;
			
			if( $j == "c" ) {
			
				$j = "a";
			
			}

		}

		if( $num == 0 ) {
		
			echo "<div class=\"square bad\" style=\"margin-bottom: 0px;\">";
			echo "<strong>Sorry</strong>";
			echo "<br />";
			echo "There aren't any news articles in this category.";
			echo "</div>";
		
		}

	?>

</div>