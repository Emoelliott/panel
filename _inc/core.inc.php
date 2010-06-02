<?php
	class Core {

		/**
		  * Cleaner for Core class - tidies up form inputs. Defaults to cleaning for database w/ htmlentities.
		  * @global $db    - database class.
		  * @param  $input - required. input to be tidied.
		  * @param  $fordb - optional. escapes data for database usage if true. defaults to true.
		  * @return $input - 'cleaned' input.
		  */
		public function clean( $input, $fordb = true ) {

			global $db;
			
			//is it an array?
			if( is_array( $input ) ) {
			
				//yes it is! let's clean each item individually.
				foreach( $input as $key => $value ) {
				
					$input[$key] = $this->clean( $value, $fordb );
				
				}
				
				return $input;
			
			}
			else {
			
				//okay, it isn't, so let's go and tidy it up.
				$input = trim( $input );
				$input = htmlentities( $input, ENT_COMPAT );
				
				if( $fordb == true and isset( $db ) ) {
				
					$input = $db->escape( $input );
				
				}
				elseif( $fordb == true ) {
					
					$input = addslashes( $input );
					
				}
				
				return $input;
			
			}

		}

		/**
		  * Encrypter for Core class - encrypts stuff for use in database. It's a bit eccentric.
		  * @global $params - core parameters.
		  * @param  $string - required. the input string.
		  * @return $string - encrypted output.
		  */
		public function encrypt( $string ) {
			
			global $vars;

			//let's md5 that salt and the string.
			$salt1  = md5( $params['core']['salt1'] );
			$salt2  = md5( $params['core']['salt2'] );
			$string = md5( $string );

			//stick them together.
			$string = $salt1 . $salt1 . $salt2 . $string . $salt2 . $salt1;

			//sha1 then md5 them again.
			$string = sha1( $string );
			$string = md5( $string );

			return $string;
		
		}
		
		/**
		  * Redirection method
		  * @param $location
		  * @param $timer
		  */
		
		public function redirect( $location, $timer = 0 ) {
			
			return "<meta http-equiv=\"refresh\" content=\"{$timer};url={$location}\" />";
			
		}
		
		/**
		  * Field builder
		  * @param $type
		  * @param $required
		  * @param $name
		  * @param $label
		  * @param $helper
		  * @param $value
		  */
		public function buildField( $type, $required, $name, $label, $helper, $value = "" ) {
			
			$build  = "\n<tr>\n<td class=\"label\">\n";
			$build .= "<label for=\"{$name}\">{$label}</label>\n";

			if( is_array( $value ) ) {
			
				ksort( $value );
			
			}

			if( $type == "text" or $type == "password" ) {
			
				$build .= "</td>\n\n<td class=\"field\">\n";
				
				$build .= "<input style=\"width: 171px;\" type=\"{$type}\" class=\"{$required}\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" />\n";
				
				$build .= "</td>\n\n<td>\n";
				
				$build .= "<div id=\"helper_{$name}\" style=\"display: none;\" class=\"help grey\">\n";
				$build .= $helper;
				$build .= "</div>\n";
			
			}
			elseif( $type == "textarea" ) {
			
				$build .= "</td>\n\n<td colspan=\"2\" align=\"right\">\n";
				$build .= "<textarea cols=\"50\" rows=\"5\" id=\"{$name}\" name=\"{$name}\">";
				$build .= $value;
				$build .= "</textarea>";
			
			}
			elseif( $type == "big_textarea" ) {
			
				$build .= "</td>\n\n<td colspan=\"2\" align=\"right\">\n";
				$build .= "<textarea cols=\"50\" rows=\"10\" id=\"{$name}\" name=\"{$name}\">";
				$build .= $value;
				$build .= "</textarea>";
			
			}
			elseif( $type == "checkbox" ) {
				$build .= "</td>\n\n<td colspan=\"2\" style=\"padding-left: 16px;\">\n";
				
				foreach( $value as $key => $value ) {
					
					if( preg_match( "/_active/", $key ) ) {
					
						$key = str_replace( "_active", "", $key );
					
						$build .= "<input type=\"checkbox\" checked=\"checked\" name=\"{$name}-{$key}\" id=\"{$name}-{$key}\" />";
					
					}
					else {
					
						$build .= "<input type=\"checkbox\" name=\"{$name}-{$key}\" id=\"{$name}-{$key}\" />";
					
					}
				
					$build .= "<label for=\"{$name}-{$key}\">";
					$build .= $value;
					$build .= "</label>";
					
					$build .= "<br />";
				}
				
			}
			elseif( $type == "select" ) {

				$build .= "</td>\n\n<td class=\"field\">\n";
				
				$build .= "<select style=\"width: 183px;\" name=\"{$name}\" id=\"{$name}\">";
				
				foreach( $value as $key => $value ) {
					
					if( preg_match( "/_active/", $key ) ) {
						
						$key = str_replace( "_active", "", $key );
						
						$build .= "<option value=\"{$key}\" selected=\"selected\">{$value}</option>";
						
					}
					else {
						
						$build .= "<option value=\"{$key}\">{$value}</option>";
						
					}
					
				}
				
				$build .= "</select>";

				$build .= "</td>\n\n<td>\n";
				$build .= "<div id=\"helper_{$name}\" style=\"display: none;\" class=\"help grey\">\n";
				$build .= $helper;
				$build .= "</div>\n";

			}

			$build .= "</td>\n</tr>\n";
			
			return $build;
			
		}
		
		
		/**
		  * Form javascript builder - creates javascript validation info from a form's ID.
		  * @param $formid
		  */
		public function buildFormJS( $formid ) {
		
			$build  = "\n<script type=\"text/javascript\">\n";
			$build .= "//<![CDATA[\n";
			$build .= "$$('td.field input').invoke('observe', 'focus', function(event) {\n";
			$build .= "var ele = Event.element(event);\n";
			$build .= "ele = $('helper_' + ele.id);\n";
			$build .= "if(ele && validated == \"no\") {\n";
			$build .= "Effect.Appear(ele, {duration: 0.2, from: 0, to: 1});\n";
			$build .= "}\n});\n\n";
			$build .= "$$('td.field input').invoke('observe', 'blur', function(event) {\n";
			$build .= "var ele = Event.element(event);\n";
			$build .= "ele = $('helper_' + ele.id);\n";
			$build .= "if(ele && validated == \"no\") {\n";
			$build .= "Effect.Fade(ele, {duration: 0.2});\n";
			$build .= "}\n});\n\n";
			$build .= "new Validation('{$formid}');\n";
			$build .= "//]]>\n";
			$build .= "</script>\n";
			
			return $build;
			
		}

		/**
		  * Radio information grabber - gets information about a shoutcast radio server.
		  * @param $url
		  * @return $return
		  */
		public function radioInfo( $url ) {
			
			$opts = array(
			
				'http' => array(
				
					'method' => 'GET',
					'header' => 'User-Agent: SHOUTcast Song Status (Mozilla Compatible)\r\n'
				
				)
			
			);

			$context = stream_context_create( $opts );

			$data    = @file_get_contents( $url, false, $context );

			if( preg_match( "/Server is currently up and public./", $data ) ) {
			
				$return['online'] = true;

				$return['listeners'] = explode("kbps with <B>", $data);
				$return['listeners'] = explode(" of", $return['listeners'][1]);
				$return['listeners'] = $return['listeners'][0];

				$return['ulisteners'] = explode("listeners (", $data);
				$return['ulisteners'] = explode(" unique", $return['ulisteners'][1]);
				$return['ulisteners'] = $return['ulisteners'][0];

				$return['listenerpeak'] = explode("Listener Peak: </font></td><td><font class=default><b>", $data);
				$return['listenerpeak'] = explode("</b>", $return['listenerpeak'][1]);
				$return['listenerpeak'] = $return['listenerpeak'][0];

				$return['streamtitle'] = explode("Stream Title: </font></td><td><font class=default><b>", $data);
				$return['streamtitle'] = explode("</b>", $return['streamtitle'][1]);
				$return['streamtitle'] = $return['streamtitle'][0];

				$return['currentsong'] = explode("Current Song: </font></td><td><font class=default><b>", $data);
				$return['currentsong'] = explode("</b>", $return['currentsong'][1]);
				$return['currentsong'] = $return['currentsong'][0];
			
			}
			else {
			
				$return['online'] = false;
			
			}

			return $return;
		}

	}

	$core = new Core();
?>