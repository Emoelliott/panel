<?php
	require_once("../_inc/glob.php");
	
	if( !$user->loggedIn ) { die(); }
	
	if( $_POST['mode'] == "requestsByType" and $_POST['id'] ) {
		
		$id = $core->clean( $_POST['id'] );
		
		if( $id == "*" ) {
		
			$query2 = $db->query( "SELECT * FROM requests WHERE `for` = '{$user->data['id']}'" );
		
		}
		elseif( $id == "all" and ( $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) ) {
		
			$query2 = $db->query( "SELECT * FROM requests" );
		
		}
		else {
		
			$query2 = $db->query( "SELECT * FROM requests WHERE type = '{$id}' AND `for` = '{$user->data['id']}'" );
		
		}
		
		$num2 = $db->num( $query2 );
		
		while( $array2 = $db->assoc( $query2 ) ) {
		
			$query = $db->query( "SELECT * FROM request_types WHERE id = '{$array2['type']}'" );
			$array = $db->assoc( $query );
			
			$query3 = $db->query( "SELECT * FROM users WHERE id = '{$array2['for']}'" );
			$array3 = $db->assoc( $query3 );
			
			$array2['for'] = $array3['username'];
			
			$array2['type'] = "<span style=\"color: #{$array['colour']}; font-size: 14px;\">" . $array['name'] . "</span>";
		
?>

<div class="box" id="request_<?php echo $array2['id']; ?>">
	
	<div class="square title noverlay" id="header_<?php echo $array2['id']; ?>" style="margin-bottom: 0px;">
	
		<div style="float: left; width: 70%;">
	
			<strong>Entry from <?php echo $array2['author']; ?> for <?php echo $array2['for']; ?></strong>
	
		</div>

		<div style="float: right; width: 30%; text-align: right;">
			
			<?php echo $array2['type']; ?>

			&nbsp;

			<a href="#" onclick="Radi.requestToggle('<?php echo $array2['id']; ?>'); return false;">
	
				<img src="_img/request_check.png" alt="Toggle delete" align="right" id="delcheck_<?php echo $array2['id']; ?>" />
	
			</a>
	
		</div>

		<br clear="all" />

	</div>

	<div style="padding: 5px;">
	
		<div>
	
			<?php echo $array2['message']; ?>
	
		</div>

		<div style="font-size: 11px; margin-top: 3px; border-top: 1px #eee solid;">

			<a href="#" onclick="Radi.deleteRequest(<?php echo $array2['id']; ?>); return false;"><img src="_img/minus.png" alt="Delete" align="right" style="position: relative; top: 2px;" /></a>

			<?php echo date( "d/m/Y H:i", $array2['stamp'] ); ?>
			(<?php echo $array2['ip']; ?>)

		</div>
	
	</div>

</div>

<?php
			
		}

		if( $num2 == 0 ) {
			
			echo "<div class=\"box\">";
			
			echo "<div class=\"square bad\" style=\"margin-bottom: 0px;\">";
			echo "<strong>Sorry</strong>";
			echo "<br />";
			echo "There are no requests in this category.";
			echo "</div>";
			
			echo "</div>";
			
		}

	}
	elseif( $_POST['mode'] == "deleteRequest" and $_POST['id'] ) {
		
		$id = $core->clean( $_POST['id'] );
		
		$query = $db->query( "SELECT * FROM requests WHERE `for` = '{$user->data['id']}' AND id = '{$id}'" );
		$num   = $db->num( $query );
		
		if( $num != 0 ) {
			
			$db->query( "DELETE FROM requests WHERE id = '{$id}'" );
			
		}
		
	}
	elseif( $_POST['mode'] == "deleteNews" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		$query = $db->query( "SELECT * FROM news WHERE id = '{$id}'" );
		$array = $db->assoc( $query );

		if( $array['author'] == $user->data['id'] or ( $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) ) {

			$db->query( "DELETE FROM news WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deleteNewsCat" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '4' ) ) {

			$db->query( "DELETE FROM news_categories WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deleteUser" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '4' ) ) {

			$db->query( "DELETE FROM users WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deleteMenuItem" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '5' ) ) {

			$db->query( "DELETE FROM menu WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deleteUsergroup" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '5' ) ) {

			$db->query( "DELETE FROM usergroups WHERE id = '{$id}'" );

		}
	}
	elseif( $_POST['mode'] == "deleteRequestType" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '4' ) ) {

			$db->query( "DELETE FROM request_types WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deletePermShow" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '4' ) ) {

			$db->query( "DELETE FROM timetable WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deleteEvent" and $_POST['id'] ) {

		$id = $core->clean( $_POST['id'] );

		if( $user->hasGroup( '4' ) ) {

			$db->query( "DELETE FROM events WHERE id = '{$id}'" );

		}

	}
	elseif( $_POST['mode'] == "deleteCheckedRequests" and $_POST['list'] ) {
		
		$list = explode( ",", $core->clean( $_POST['list'] ) );
		
		foreach( $list as $key => $value ) {
		
			$id = $core->clean( $value );
	
			$query = $db->query( "SELECT * FROM requests WHERE `for` = '{$user->data['id']}' AND id = '{$id}'" );
			$num   = $db->num( $query );
	
			if( $num != 0 ) {
	
				$db->query( "DELETE FROM requests WHERE id = '{$id}'");
	
			}
			
		}
		
	}
	elseif( $_POST['mode'] == "bookSlot" and $_POST['day'] != "" and $_POST['time'] != "" ) {
		
		$day  = $core->clean( $_POST['day'] );
		$time = $core->clean( $_POST['time'] );
		
		$query = $db->query( "SELECT * FROM timetable WHERE day = '{$day}' AND time = '{$time}' ");
		$array = $db->assoc( $query );
		$num   = $db->num( $query );
		
		if( $num == 1 and ($array['dj'] == $user->data['id'] or $user->hasGroup( '4' ) or $user->hasGroup( '5' ) ) ) {
			
			$db->query( "DELETE FROM timetable WHERE day = '{$day}' AND time = '{$time}'");
			
			echo "Book";
			echo "@-";
			echo "inherit";
			
		}
		elseif( $num == 0 ) {
			
			$db->query( "INSERT INTO timetable VALUES (NULL, '{$day}', '{$time}', '{$user->data['id']}', '0');" );
			
			echo $user->data['username'];
			echo "@-";
			echo "#" . $user->data['usergroup']['colour'];
		
		}
		
	}
	elseif( $_POST['mode'] == "getShouts" ) {

		$i = 1;

		$query = $db->query( "SELECT * FROM shouts ORDER BY time DESC LIMIT 10" );
		while( $array = $db->assoc( $query ) ) {

			$array2 = $user->getInfo( $array['user'] );

			echo "<div class=\"shout\"" . ( $i == 1 ? ' style="border-top: none;"' : '' ) . ">";

			if( preg_match( "/\/me/", $array['message'] ) ) {

				$array['message'] = str_ireplace( "/me", "", $array['message'] );

				echo "*{$array2['fullUsernameURL']} {$array['message']}*";

			}
			else {

				echo date( "[H:i]", $array['time'] ) . " ";
				echo "{$array2['fullUsernameURL']}: {$array['message']}";

			}

			echo "</div>";

			$i++;

		}

		if( $db->num( $query ) == 0 ) {

			echo "<div class=\"shout\">There are currently no shouts!</div>";

		}

	}
	elseif( $_POST['mode'] == "sendShout" and $_POST['shout'] ) {

		$shout = $core->clean( $_POST['shout'] );
		$time  = time();

		if( $shout == "/prune" and $user->hasGroup( '4' ) ) {

			$db->query( "DELETE FROM shouts" );
			$db->query( "INSERT INTO shouts VALUES (NULL, '{$user->data['id']}', '/me just pruned the shoutbox', '{$time}');" );

		}
		elseif( preg_match( "/\/prune (.*?)/", $shout ) and $user->hasGroup( '4' ) ) {

			$user = end( explode( "/prune ", $shout ) );

			$query = $db->query( "SELECT * FROM users WHERE username = '{$user}'" );
			if( $db->num( $query ) != 0 ) {

				$array = $db->assoc( $query );

				$db->query( "DELETE FROM shouts WHERE user = '{$array['id']}'" );

			}

		}
		else {

			$db->query( "INSERT INTO shouts VALUES (NULL, '{$user->data['id']}', '{$shout}', '{$time}');" );

		}

	}
?>