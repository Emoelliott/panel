<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Manage news categories</strong>
	</div>

	<?php

		$query = $db->query( "SELECT * FROM news_categories" );
		$num   = $db->num( $query );

		$j = "a";

		while( $array = $db->assoc( $query ) ) {

			echo "<div class=\"row {$j}\" id=\"news_cat_{$array['id']}\">";

			echo "<a href=\"#\" onclick=\"Radi.deleteNewsCat('{$array['id']}');\">";
			echo "<img src=\"_img/minus.png\" alt=\"Delete\" align=\"right\" />";
			echo "</a>";

			echo "<a href=\"mgmt.addNewsCat?id={$array['id']}\">";
			echo "<img src=\"_img/pencil.png\" alt=\"Edit\" align=\"right\" />";
			echo "</a>";

			echo $array['name'];

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
			echo "There are no news categories to manage.";
			echo "</div>";
			
		}
		
	?>

</div>