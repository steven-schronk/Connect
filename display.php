<?php

include 'dbconnector.php';

include 'menu.php';

if(!isset($_GET['group'])) { echo "No Group Entered"; die($no_group_entered); }

$sql = 'select * from '. $_GET['group'];

if (!mysql_query($sql)) {
	die('Could not find any tables in database: ' . mysql_error());
}

$result = mysql_query($sql);

$table_head .= "<table border=1>";

/* print names of columns in this table */
$i = 0;
$fields = mysql_num_fields($result);
$table_head .= "<tr>";
while ($i < mysql_num_fields($result)) {
	
    $meta = mysql_fetch_field($result, $i);
	$table_head .= "<td>".$meta->name."</td>";
	$i++;
}
$table_head .= "</tr>";

/* print data from table */

while ($row = mysql_fetch_array($result)) {
	$table_body .= "<tr>";
	for($i = 0; $i < $fields; $i++)
	{
		if($i == 0)
		{
			$table_body .= "<td><a href=edit.php?group=".$_GET['group']."&item=".$row[$i].">".$row[$i]."</a></td>";
		} else {
			$table_body .= "<td>".$row[$i]."</td>";
		}
	}
	$table_body .= "</tr>\n";
}

?>

<html>
<?php echo "<a href=edit.php?group=".$_GET['group'].">New Record</a>"; ?>

<table>
<?php echo $table_head; ?>
<?php echo $table_body; ?>
</table>
</html>
