<?php

/*

This page has three modes:

1. Display data with form to update.

2. Update data after checking for valid fields.

3. Display empty form to enter new data.

*/

include 'dbconnector.php';

include 'menu.php';

if(!isset($_GET['group'])) { echo "No Group Entered"; die($no_group_entered); }

/* get description of table */
$sql = 'desc '. $_GET['group'];

if (!mysql_query($sql)) { die('Could not get description of group: '. mysql_error()); }

$desc = mysql_query($sql);


/* get data for this row */
$sql = 'select * from '.$_GET['group'].' where item_id = '.$_GET['item'];

$data = mysql_query($sql);

$data = mysql_fetch_array($data);


/* get connections list for this table */
$connect = 'select * from $connect where child_table ="'.$_GET['group'].'"';

$connect = mysql_query($connect);

$con_count = 0;
while ($row = mysql_fetch_array($connect))
{
	$con_count++;
	$conn[$con_count]['child_column'] = $row['child_column'];
	$conn[$con_count]['parent_table'] = $row['parent_table'];
	$conn[$con_count]['parent_display_1'] = $row['parent_display_1'];
	$conn[$con_count]['parent_display_2'] = $row['parent_display_2'];
	$conn[$con_count]['parent_display_3'] = $row['parent_display_3'];
	/* echo "Connection Found:".$row['child_column']."<br>"; */
}

echo '<form action="edit.php" method="get">';
echo '<input name=group type=hidden value="'.$_GET['group'].'">';
echo '<input name=action type=hidden value="update">';

if(isset($_GET['item'])) {
	echo '<input name=item type=hidden value="'.$_GET['item'].'">';
} else {

	$sql = 'insert into '.$_GET['group'];

	/* Loop through $_GET and add values from form to insert into database */
	while (list($column,$value) = each($_GET)){
		/* echo "Key: ".$column . "->Value: ".$value."<br />"; */
		if($column != 'group' && $column != 'action') {
			$columns .= $column.',';
			$values .=  '"'.$value.'",';
		}
	}

	$columns = substr($columns,0,-1); 
	$values = substr($values,0,-1);

	$sql .= '('.$columns.') values ('.$values.')';

	/* echo $sql.'<br>'; */

	if($_GET['action'] == 'update'){

		/* insert data from form */
		$data = mysql_query($sql);

		/* update history */
	}
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

		/* check to see if this is a connection column */
		$found = 0;
		for($j = 1; $j <= $con_count; $j++)
		{
			if($conn[$j]['child_column'] == $row[0]) {

				$found++;
				/* get connection list from db and create a dropdown */

				$sql = 'select item_id, '. $conn[$i]['parent_display_1'].' from '. $conn[$con_count]['parent_table'];

				$option = mysql_query($sql);

				echo $row[0];
				echo '<select name='.$row[0].'><option></option>';
				
				while ($row = mysql_fetch_array($option))
				{
					echo '<option value='.$row[0].'>'.$row[1].'</option>';
				}
				echo '</select>';
			}
		}

		if(!$found) { echo $row[0].'<input name="'.$row[0].'" value="'.$data[$i].'">'; }
		if($row[2] == 'NO') { echo '&nbsp; NOT NULL'; }
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
