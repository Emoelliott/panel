<?php
	require_once("../_inc/glob.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>

		<title>radiPanel Timetable</title>

		<style type="text/css" media="screen">
			
			body {
			
				background: #ddeef6;
				padding: 0;
				margin: 0;
			
			}
	
			body, td {
			
				font-family: Verdana, Tahoma, Arial;
				font-size: 11px;
				color: #333;
				text-align: center;
			
			}
	
			td, table {
			
				border: 1px #ddd solid;
				background: #eee;
			
			}
	
			td.bg {
			
				background: #ddd;
				font-weight: bold;
			
			}
	
			.wrapper {
			
				background-color: #fcfcfc;
				width: 800px;
				margin: auto;
				padding: 5px;
				margin-top: 15px;
			
			}
			
		</style>

	</head>

	<body>
	
		<div class="wrapper">
	
			<table width="100%" cellpadding="3" cellspacing="0">
				
				<tr>
				
					<td width="12.5%" class="bg"></td>
					
					<td width="12.5%" class="bg">
						Monday
					</td>
				
					<td width="12.5%" class="bg">
						Tuesday
					</td>

					<td width="12.5%" class="bg">
						Wednesday
					</td>

					<td width="12.5%" class="bg">
						Thursday
					</td>

					<td width="12.5%" class="bg">
						Friday
					</td>

					<td width="12.5%" class="bg">
						Saturday
					</td>

					<td width="12.5%" class="bg">
						Sunday
					</td>

				</tr>
				
				<?php
	
					for( $i = 0; $i <= 23; $i++ ) {
						
						$k = $i + 1;
						
						if( $i < 10 ) {
	
							$time = "0{$i}:00";
	
						}
						else {
	
							$time = "{$i}:00";
	
						}

						if( $k < 10 ) {

							$time2 = "0{$k}:00";

						}
						elseif( $k == 24 ) {
							
							$time2 = "00:00";
							
						}
						else {

							$time2 = "{$k}:00";

						}

						echo "<tr>";
	
						echo "<td width=\"12.5%\" class=\"bg\">";
						echo $time . " - " . $time2;
						echo "</td>";
	
						for( $j = 1; $j <= 7; $j++ ) {
	
							$query = $db->query( "SELECT * FROM timetable WHERE day = '{$j}' AND time = '{$i}'" );
							$array = $db->assoc( $query );
	
							$query2 = $db->query( "SELECT * FROM users WHERE id = '{$array['dj']}'" );
							$array2 = $db->assoc( $query2 );
	
							echo "<td width=\"12.5%\" align=\"center\">";
	
							echo $array2['username'] ? $array2['username'] : '-';
	
							echo "</td>";
	
						}
	
						echo "</tr>";
	
					}
	
				?>
	
			</table>
	
		</div>
	
	</body>

</html>