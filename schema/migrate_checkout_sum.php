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
fout_date,
mat_item,
cnt
FROM civic.checkoutsum
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$material = strtoupper(substr($row['mat_item'],0,1));
	$item = substr($row['mat_item'],1);
	
	$date1 = explode(" ",$row['fout_date']);
	$date2 = $date1[2]."-".$date1[1]."-".$date1[0];
	
	if ($item < 10) $item = "00$item";
	else if ($item < 100) $item = "0$item";
	
	$sql = "select BLOCK_ID from civic_new.patron where PATRON_ID = \"$row[patron_id]\"";
	
	$result2 = mysql_query($sql);
	$row2 = mysql_fetch_assoc($result2);
	
	$block = $row2['BLOCK_ID'];
	
	mysql_free_result($result2);
	
	$sql =

"
INSERT IGNORE INTO civic_new.checkout_sum (
`PATRON_ID`,
`BLOCK_ID`,
`MATERIAL_ID`,
`ITEM_ID`,
`CHECKOUT_DATE`,
`CHECKOUTS`
) VALUES (
\"$row[patron_id]\",
\"$block\",
\"$material\",
\"$item\",
\"$date2\",
\"$row[cnt]\"
)
";

	if (!mysql_query($sql)) {
		
		$error = mysql_error($link);
		if (eregi("PATRON_ID",$error) || eregi("ui_checkout_sum",$error)) {
			continue;
		}
		else {
			echo $error."<br /><br />".$sql;
			exit;
		}
	}
}

mysql_free_result($result);
mysql_close($link);

?>