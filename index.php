<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Connect.</title>

<link rel="stylesheet" type="text/css" media="all" href="include/style.css" />

</head>

<body>

<center><h2>Connect.</h2></center>

<?php

include 'dbconnector.php';

$sql = 'show tables';

if (!mysql_query($sql)) {
	ie('Could not find any tables in database: ' . mysql_error());
}

if ($result = mysql_query($sql)) {
	while ($row = mysql_fetch_array($result)) {
		echo "<a href=display.php?group=".$row[0].">".$row[0]."</a>&nbsp;";
		echo "<a href=new.php?group=".$row[0]."> New ".$row[0]."</a>";

	}
}

?>


</body>

</html>
