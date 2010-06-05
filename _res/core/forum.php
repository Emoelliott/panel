<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>

<div class="box">

	<div class="square title">
		<strong>Forum</strong>
	</div>

	<table width="100%" cellpadding="3" cellspacing="0">

		<tr style="font-weight: bold;">
		
			<td width="98%">Thread / Thread Starter</td>
			
			<td width="1%" style="white-space: nowrap;" align="center">Last Post</td>
			
			<td width="1%" style="white-space: nowrap;" align="center">Replies</td>
		
		</tr>

		<?php
	
			$query = $db->query( "SELECT * FROM posts WHERE replyto = '0' ORDER BY sticky DESC, stamp DESC" );
	
			$i = "a";
	
			while( $array = $db->assoc( $query ) ) {
	
				$udata = $user->getInfo( $array['user'] );
	
		?>
	
		<tr class="row <?php echo $i; ?>" style="display: table-row;">
	
			<td width="50%">
	
				<?php echo $array['sticky'] == 1 ? 'Sticky:' : ''; ?>
				<strong><?php echo $array['title']; ?></strong>
				<br />
				<span style="font-size: 10px;">Posted by <strong><?php echo $udata['fullUsernameURL']; ?></strong></span>
			
			</td>
			
			<td width="1%" style="white-space: nowrap;" align="right">
			
				<?php
				
					$query2 = $db->query( "SELECT * FROM posts WHERE replyto = '{$array['id']}' ORDER BY stamp DESC" );
					$array2 = $db->assoc( $query );
					
					if( $db->num( $query2 ) == 0 ) {
					
						$array2 = $array;
					
					}
					
					$udata2 = $user->getInfo( $array2['user'] );
					
					echo $core->niceDate( $array2['stamp'] );
					echo "<br />";
					echo "<span style=\"font-size: 10px;\">by {$udata2['fullUsernameURL']}</span>";
				
				?>
			
			</td>
			
			<td width="1%" style="padding: 0px 10px; white-space: nowrap;" align="center">
			
				<?php
				
					echo $db->num( $query2 );
				
				?>
			
			</td>
	
		</tr>
	
		<?php
	
				$i++;
	
				if( $i == "c" ) {
	
					$i = "a";
	
				}
	
			}
	
		?>

	</table>


</div>