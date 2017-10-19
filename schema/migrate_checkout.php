<?php

ini_set("max_execution_time", "30000");

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
patron_id,
block_group_id,
material_type_id,
item_type_id,
OUT_DATE
FROM civic.checkouts
ORDER BY OUT_DATE
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	if (($row['block_group_id'] > 0) && ($row['patron_id'] > 0)) {
		
	$material = strtoupper($row['material_type_id']);
	$item = $row['item_type_id'];
	
	if ($item < 10) $item = "00$item";
	else if ($item < 100) $item = "0$item";
	
	$sql =

"
INSERT INTO civic_new.checkout (
`PATRON_ID`,
`BLOCK_ID`,
`MATERIAL_ID`,
`ITEM_ID`,
`CHECKOUT_TIME`
) VALUES (
\"$row[patron_id]\",
\"$row[block_group_id]\",
\"$material\",
\"$item\",
\"$row[OUT_DATE]\"
)
";

	if (!mysql_query($sql)) {
		
		$error = mysql_error($link);
		if (eregi("PATRON_ID",$error) || eregi("ui_checkout",$error)) {
			continue;
		}
		else {
			echo $error."<br /><br />".$sql;
			exit;
		}
	}

	}
}

mysql_free_result($result);
mysql_close($link);

?>