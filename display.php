<?php

include 'dbconnector.php';

include 'menu.php';

if(!isset($_GET['group'])) { echo "No Group Entered"; die($no_group_entered); }

$sql = 'select * from '. $_GET['group'];

if (!mysql_query($sql)) {
	die('Could not find any tables in database: ' . mysql_error());
}

$result = mysql_query($sql);


$table_head .= '<h2>'.$_GET['group'].'</h2>';
$table_head .= "<table border=1>";

/* print names of columns in this table */
$fields = mysql_num_fields($result);
$table_head .= "<tr>";
$field_count = 0;
while ($field_count < mysql_num_fields($result))
{
	$meta = mysql_fetch_field($result, $field_count);
	$table_head .= "<td>".$meta->name."</td>"; /* get name of column */
	$field_info[$field_count]['name'] = $meta->name;
	$field_count++;
}
$table_head .= "</tr>";

/* get connections list for this table */
$connect = 'select * from $connect where child_table ="'.$_GET['group'].'"';
$connect = mysql_query($connect);
while ($row = mysql_fetch_array($connect))
{
	for($i = 0; $i < $field_count; $i++)
	{	
		if($row['child_column'] == $field_info[$i]['name'])
		{
			$field_info[$i]['child_column'] = $row['child_column'];
			$field_info[$i]['parent_table'] = $row['parent_table'];
			$field_info[$i]['parent_display_1'] = $row['parent_display_1'];
			$field_info[$i]['parent_display_2'] = $row['parent_display_2'];
			$field_info[$i]['parent_display_3'] = $row['parent_display_3'];
		}
	}
}

/* print data from table */

while ($row = mysql_fetch_array($result)) {
	$table_body .= "<tr>";
	for($i = 0; $i < $fields; $i++) /* print out each field in row */
	{

		if($field_info[$i]['child_column'] != '') { /* connected field - get data to and link */
			if($row[$i] == '')
			{
				$table_body .= "<td></td>"; /* field empty - nothing to display */
			} else {

				/* get columns that should be listed for this data item */
				$sql = 'select '.$field_info[$i]['parent_display_1'].' from '.$field_info[$i]['parent_table'].' where item_id='.$row[$i];

				$parent_row = mysql_query($sql);
				$parent_row = mysql_fetch_array($parent_row); /* should be only one row */

				$table_body .= "<td><a href=edit.php?group=".$field_info[$i]['parent_table']."&item=".$row[$i].'>'.$parent_row[0].'</a>';
			}

		} elseif($i == 0) { /* first column has a link to an edit page */
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
