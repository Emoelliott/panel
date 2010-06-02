<?php
	require_once( "../../_inc/glob.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>

		<title>radiPanel News</title>

		<style type="text/css" media="screen">

			body {

				background: #ddeef6;
				padding: 0;
				margin: 0;

			}

			body, a, input, select, textarea {

				font-family: Verdana, Tahoma, Arial;
				font-size: 11px;
				color: #333;
				text-decoration: none;

			}

			a:hover {

				text-decoration: underline;

			}

			form {

				padding: 0;
				margin: 0;

			}

			.wrapper {

				background-color: #fcfcfc;
				width: 400px;
				margin: auto;
				padding: 5px;
				margin-top: 15px;

			}

			.title {

				padding: 5px;	
				margin-bottom: 5px;
				font-size: 14px;
				font-weight: bold;
				background-color: #eee;
				color: #444;

			}

			.content {

				padding: 5px;

			}

			.good, .bad {

				padding: 5px;	
				margin-bottom: 5px;

			}

			.good strong, .bad strong {

				font-size: 14px;
				font-weight: bold;

			}

			.good {

				background-color: #d9ffcf;
				border-color: #ade5a3;
				color: #1b801b;

			}

			.bad {

				background-color: #ffcfcf;
				border-color: #e5a3a3;
				color: #801b1b;

			}

			input, select, textarea {

				border: 1px #e0e0e0 solid;
				border-bottom-width: 2px;
				padding: 3px;

			}

			input {

				width: 170px;

			}

			input.button {

				width: auto;
				cursor: pointer;
				background: #eee;

			}

			select {

				width: 176px;

			}

			textarea {

				width: 288px;

			}

			label {

				display: block;
				padding: 3px;

			}

		</style>

	</head>

	<body>

		<div class="wrapper">

			<?php
			
				$id    = $core->clean( $_GET['id'] );
			
				$query = $db->query( "SELECT * FROM news WHERE id = '{$id}'" );
				$array = $db->assoc( $query );
				$num   = $db->num( $query );
			
			?>

			<div class="<?php echo $num == 1 ? 'title' : 'bad" style="font-size: 14px; font-weight: bold;'; ?>">

				<?php
					
					echo $num == 1 ? $array['title'] : 'Oops!';
					
				?>

			</div>


			<?php

				if( $num == 1 ) {

			?>

			<div style="padding: 5px; border-bottom: 1px #eee solid;">
				<em>&quot;<?php echo $array['desc']; ?>&quot;</em>
			</div>

			<div style="padding: 5px; border-bottom: 1px #eee solid;">
				<?php echo html_entity_decode( nl2br( $array['article'] ) ); ?>
			</div>

			<div style="padding: 5px; font-size: 10px;">
				Posted at <strong><?php echo date( "H:i", $array['stamp'] ); ?></strong> on <strong><?php echo date( "d/m/Y", $array['stamp'] ); ?></strong>.
			</div>

			<?php

				}
				else {

			?>

			That doesn't appear to be a valid news article.

			<?php

				}

			?>


		</div>

	</body>

</html>