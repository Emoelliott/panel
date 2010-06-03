<?php

	if( !preg_match( "/index.php/i", $_SERVER['PHP_SELF'] ) ) { die(); }

?>
<div class="box">

	<div class="square title">
		<strong>Shoutbox</strong>
	</div>

	<div class="content">

		<form action="#" onsubmit="Radi.shoutboxSend(); return false;">

			<input type="text" id="shout" class="shoutbox" />
			<div id="shoutbox">

				<div class="shout">Loading...</div>

			</div>

			<script type="text/javascript">
				//<![CDATA[

					Radi.shoutboxStart();

				//]]>
			</script>

		</form>

	</div>

</div>