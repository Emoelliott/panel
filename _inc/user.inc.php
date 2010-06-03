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
				
				$this->data = $this->getInfo( $this->sessionData['user_id'] );
								
			}
		
		}
		
		public function getInfo( $id ) {
		
			global $db;
		
			$query = $db->query( "SELECT t1.*, t2.stamp FROM users AS t1 INNER JOIN sessions AS t2 WHERE t1.id = '{$id}' AND t2.user_id = t1.id" );
			$data  = $db->assoc( $query );

			$query2 = $db->query( "SELECT t1.*, t2.name FROM fields_data AS t1 INNER JOIN fields AS t2 WHERE t1.uid = '{$id}' AND t2.id = t1.fid" );
			while( $array2 = $db->assoc( $query2 ) ) {
			
				$array2['name'] = explode( " ", $array2['name'] );
				foreach( $array2['name'] as $key => $value ) {
				
					$value = strtolower( $value );
					
					if( $key != 0 ) {
					
						$value = ucwords( $value );
					
					}
					
					$name .= $value;
				
				}
				
				$array2['name'] = $name;
				
				$data[$array2['name']] = $array2['value'];
			
			}

			$data['uGroupArray'] = explode( ",", $data['usergroups'] );

			$query = $db->query("SELECT * FROM usergroups WHERE id = '{$data['displaygroup']}'");
			$array = $db->assoc($query);

			$data['usergroup'] = $array;

			$data['fullUsername'] = "<span style=\"color: #{$array['colour']}\">{$data['username']}</span>";
		
			return $data;
		
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