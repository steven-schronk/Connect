<table border=1>
<?php

include 'dbconnector.php';

$sql = 'show tables';

if (!mysql_query($sql)) {
	ie('Could not find any tables in database: ' . mysql_error());
}

if ($result = mysql_query($sql)) {
	while ($row = mysql_fetch_array($result)) {
		if(strpos($row[0],'$') === false){
			echo "<tr><td><a href=display.php?group=".$row[0].">".$row[0]."</a></td>";
			echo "<td><a href=edit.php?group=".$row[0]."> add ".$row[0]."</a></td></tr>";
		}

	}
}

?>

</table>
<br><br>
