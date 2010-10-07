<?php

/*

This page has three modes:

1. Display data with form to update.

2. Update data after checking for valid fields.

3. Display empty form to enter new data.

*/

include 'dbconnector.php';

if(!isset($_GET['group'])) { echo "No Group Entered"; die($no_group_entered); }

$sql = 'desc '. $_GET['group']; /* description of table */

if (!mysql_query($sql)) { die('Could not get description of group: '. mysql_error()); }

$desc = mysql_query($sql);

$sql = 'select * from '.$_GET['group'].' where item_id = '.$_GET['item']; /* data for this row */

$data = mysql_query($sql);

$data = mysql_fetch_array($data);

echo '<form action="edit.php" method="get">';
echo '<input name=group type=hidden value="'.$_GET['group'].'">';

if(isset($_GET['item'])) {
	echo '<input name=item type=hidden value="'.$_GET['item'].'">';
} else {

$sql = 'insert into '.$_GET['group'];

/* Loop through $_GET and add values from form to insert into database */
while (list($column,$value) = each($_GET)){
	echo "Key: ".$column . "->Value: ".$value."<br />";
	if($column != 'group') {
		$columns .= $column.',';
		$values .=  '"'.$value.'",';
	}
}

$columns = substr($columns,0,-1); 
$values = substr($values,0,-1);

$sql .= '('.$columns.') values ('.$values.')';

echo $sql.'<br>';

$data = mysql_query($sql);

}

/*

Go through each column, identify data type and data value.

Build web form for user to modify data.

NOTE: This applies to all columns accept the item_id and update_timestamp.
These columns are required and must be available in all tables in system.

*/
$i = 0;
while ($row = mysql_fetch_array($desc))
{

	if($row[0] == 'item_id' || $row[0] == 'update_timestamp')
	{
		/* these fields must be in each table and are managed by the system */
		echo $row[0].'<input name=item value="'.$data[$i].'" disabled="disabled">';
	} elseif(strpos($row[1],'varchar') == 0){ 

		echo $row[0].'<input name="'.$row[0].'" value="'.$data[$i].'">';
	}
		
	echo '<br>';
	echo '<br>';
	$i++;
}

if(isset($_GET['item'])) { 

	echo '<INPUT type="submit" value="Update"> <INPUT type="reset">';

} else {

	echo '<INPUT type="submit" value="Save"> <INPUT type="reset">';

}



?>
