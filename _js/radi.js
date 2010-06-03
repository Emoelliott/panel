var RadiClass = Class.create( {
	
	menuToggle: function( id ) {

		$$( '.menuitems' ).each( function( ele ) {

				if( ele.style.display != "none" ) {
					Effect.toggle( ele, 'blind', {duration: 0.5} );
				}

		});

		$$( '.menutoggle' ).each( function( ele ) {

			ele.src = "_img/plus_white.png";

		});

		if( $( 'mitems_' + id ).style.display == "none" ) {

			$( 'menutoggle_' + id ).src = "_img/minus_white.png";

		}

		Effect.toggle( 'mitems_' + id, 'blind', {duration: 0.5} );

	},


	timetableToggle: function( id ) {

		$$( '.day' ).each( function( ele ) {

				if( ele.style.display != "none" ) {
					Effect.toggle( ele, 'blind', {duration: 0.5} );
				}

		});
		
		$$( '.toggle' ).each( function( ele ) {
			
			ele.src = "_img/plus.png";
		
		});
		
		if( $( 'day_' + id ).style.display == "none" ) {
		
			$( 'toggle_' + id ).src = "_img/minus.png";
		
		}
		
		Effect.toggle( 'day_' + id, 'blind', {duration: 0.5} );

	},

	

	requestsByType: function( id ) {
		
		$( 'requestlist' ).innerHTML = "<div align=\"right\"><img src=\"_img/loader_blue.gif\" alt=\"Loading\" /></div>";
		
		new Ajax.Request( 'ajax', {
		
							method: 'post',
							parameters: {mode: 'requestsByType', id: id},
							onComplete: function( transport  ) {
								
								var reply = transport.responseText;
								$( 'requestlist' ).innerHTML = reply;
							
							}
		
		} );
		
	},

	bookSlot: function ( day, time ) {
		
		ele  = $( 'slot_' + day + '_' + time );
		
		ele.innerHTML = "...";
		
		new Ajax.Request( 'ajax', {
		
							method: 'post',
							parameters: {mode: 'bookSlot', day: day, time: time},
							onComplete: function( transport ) {
								
								reply = transport.responseText;
								split = reply.split('@-');
								
								if( split[1] ) {
								
									ele.innerHTML = split[0];
									ele.style.color = split[1];
								
								}
							
							}
		} );
		
	},

	deleteNews: function( id ) {
	
		elm = $( 'news_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteNews', id: id}

		} );
		
	},

	deleteEvent: function( id ) {

		elm = $( 'event_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteEvent', id: id}

		} );

	},

	deleteRequestType: function( id ) {

		elm = $( 'requesttype_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteRequestType', id: id}

		} );

	},

	deletePermShow: function( id ) {

		elm = $( 'permshow_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deletePermShow', id: id}

		} );

	},

	deleteNewsCat: function( id ) {

		elm = $( 'news_cat_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteNewsCat', id: id}

		} );

	},

	deleteUser: function( id ) {

		elm = $( 'user_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteUser', id: id}

		} );

	},

	deleteUsergroup: function( id ) {

		elm = $( 'usergroup_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteUsergroup', id: id}

		} );

	},

	deleteMenuItem: function( id ) {

		elm = $( 'menu_' + id );

		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'deleteMenuItem', id: id}

		} );

	},

	deleteRequest: function( id ) {
	
		elm = $( 'request_' + id );
		
		Effect.Pulsate( elm, {duration: 1, pulses: 2} );
		Effect.Fade( elm, {delay: 1, duration: 0.5} );
		
		new Ajax.Request( 'ajax', {
		
							method: 'post',
							parameters: {mode: 'deleteRequest', id: id}
		
		} );
	
	},

	requestToggle: function(id) {
		for( i = 0; i < deleteRequests.length; i++ ) {
		
			if( deleteRequests[i] == id ) {
			
				deleteRequests[i] = "n";
				$( 'header_' + id ).className = "square title";
				$( 'delcheck_' + id ).src = "_img/request_check.png";
				done = true;
			
			} else {
			
				done = false;
			
			}
			
		}

		if( deleteRequests.length == 0 ) {
			
			done = false;
		
		}

		if( done != true ) {
		
			deleteRequests.push( id );
			
			$( 'header_' + id ).className = "square bad";
			$( 'delcheck_' + id ).src = "_img/request_uncheck.png";
		
		}
	},

	deleteCheckedRequests: function() {
	
		sendstr = "";
	
		for( i = 0; i < deleteRequests.length; i++ ) {
		
			if( deleteRequests[i] != "n" ) {
			
				sendstr += deleteRequests[i] + ",";
				
				elm = $( 'request_' + deleteRequests[i] );
				
				Effect.Pulsate( elm, {duration: 1, pulses: 2} );
				Effect.Fade( elm, {delay: 1, duration: 0.5} );
				
			}
			
		}

		new Ajax.Request( 'ajax', {
		
							method: 'post',
							parameters: {mode: 'deleteCheckedRequests', list: sendstr}
							
		} );

	},

	shoutboxStart: function() {

		shoutbox = new Ajax.PeriodicalUpdater( 'shoutbox', 'ajax', {

							method: 'post',
							parameters: {mode: 'getShouts'},
							frequency: 7,
							decay: 0

		} );

	},

	shoutboxSend: function() {

		shout = $('shout').value;
		$('shout').value = "";

		new Ajax.Request( 'ajax', {

							method: 'post',
							parameters: {mode: 'sendShout', shout: shout},
							onComplete: function() { shoutbox.stop(); shoutbox.start(); }

		} );

	}
	
} );

deleteRequests = Array();

var Radi = new RadiClass();