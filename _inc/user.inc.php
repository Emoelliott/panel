<?php

	class UserException extends Exception { }
	
	class User {
		
		private $sessionID;
		public  $sessionData;
		public  $data;
		public  $loggedIn;
		
		/**
		  * Constructor - forms session and loads session data.
		  * @global $db
		  * @global $core
		  */
		public function __construct() {
		
			global $db, $core;
			
			$this->clearUpSessions();
			
			$this->sessionID = $core->encrypt( session_id() );
			
			$this->createSession();
			
			$query = $db->query( "SELECT * FROM sessions WHERE session_id = '{$this->sessionID}'" );
			$this->sessionData = $db->assoc( $query );
			
			if( $this->sessionData['user_id'] ) {
			
				$this->loggedIn = true;
				
				$query      = $db->query( "SELECT * FROM users WHERE id = '{$this->sessionData['user_id']}'" );
				$this->data = $db->assoc( $query );
				
				$this->data['uGroupArray'] = explode( ",", $this->data['usergroups'] );
				
				$query = $db->query("SELECT * FROM usergroups WHERE id = '{$this->data['displaygroup']}'");
				$array = $db->assoc($query);
				
				$this->data['usergroup'] = $array;
				
				$this->data['fullUsername'] = "<span style=\"color: #{$array['colour']}\">" . $this->data['username'] . "</span>";
				
			}
		
		}
		
		private function createSession() {
			
			global $db, $core;
			
			$query = $db->query( "SELECT * FROM sessions WHERE session_id = '{$this->sessionID}'" );
			$num   = $db->num( $query );
			
			if( $num == 0 ) {
			
				$time = time();
				
				$db->query( "INSERT INTO sessions VALUES ( NULL, '{$this->sessionID}', '0', '{$time}' );" );
			
			}
			else {
			
				$oldID = $this->sessionID;
				
				session_regenerate_id();
				
				$newID = $core->encrypt( session_id() );
				
				$time  = time();
				
				$db->query( "UPDATE sessions SET session_id = '{$newID}', stamp = '{$time}' WHERE session_id = '{$oldID}'" );
				
				$this->sessionID = $newID;
				
			}
		
		}
		
		public function hasGroup( $id ) {
			
			if( in_array( $id, $this->data['uGroupArray'] ) ) {
				return true;
			}
			else {
				return false;
			}
			
		}
		
		private function clearUpSessions() {
			
			global $params, $db;
			
			$time = strtotime( "{$params['user']['timeout']} ago" );
						
			$db->query( "DELETE FROM sessions WHERE stamp < '{$time}'" );
			
		}
		
		public function destroySession() {
			
			global $db;
			
			$db->query( "DELETE FROM sessions WHERE session_id = '{$this->sessionID}'" );
		
		}
		
		private function assignUser( $id ) {
			
			global $db;
			
			$db->query( "UPDATE sessions SET user_id = '{$id}' WHERE session_id = '{$this->sessionID}'" );
		
		}
		
		public function login( $username, $password ) {
			
			global $core, $db;
			
			$username     = $core->clean( $username );
			$password     = $core->clean( $password );
			$password_enc = $core->encrypt( $password );
			
			$query = $db->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password_enc}'");
			$array = $db->assoc($query);
			$num   = $db->num($query);
			
			if( !$username or !$password ) {
			
				throw new UserException( 'All fields are required.' );
			
			}
			elseif( $num != 1 ) {
			
				throw new UserException( 'Invalid username/password.' );
			
			}
			else {
			
				$this->assignUser( $array['id'] );
				return true;
			
			}
		
		}
	
	}
	
	$user = new User();

?>