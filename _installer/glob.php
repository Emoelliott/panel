<?php
	##############
	## glob.php ##
	##############

	$params['db']['hostname']  = "conf_hostname";
	$params['db']['username']  = "conf_username";
	$params['db']['password']  = "conf_password";
	$params['db']['database']  = "conf_database";

	$params['core']['salt1']   = "conf_salt1";
	$params['core']['salt2']   = "conf_salt2";

	$params['user']['timeout'] = "conf_timeout";

	session_start();
	putenv( "TZ=Europe/London" );

	require_once( "db.inc.php" );
	require_once( "core.inc.php" );
	require_once( "user.inc.php" );
	
	if( file_exists( "_installer/" ) ) {
	
		die( "Please delete the /_installer directory." );
	
	}
?>