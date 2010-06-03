<?php
	##############
	## glob.php ##
	##############

	$params['db']['hostname']  = "localhost";
	$params['db']['username']  = "root";
	$params['db']['password']  = "";
	$params['db']['database']  = "panel";

	$params['core']['salt1']   = "5cd4835313";
	$params['core']['salt2']   = "a162ce1fdd";

	$params['user']['timeout'] = "20 minutes";

	session_start();
	putenv( "TZ=Europe/London" );

	require_once( "db.inc.php" );
	require_once( "core.inc.php" );
	require_once( "user.inc.php" );
	
	if( file_exists( "_installer/" ) ) {
	
		die( "Please delete the /_installer directory." );
	
	}
?>