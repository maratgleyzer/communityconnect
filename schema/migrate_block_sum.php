<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
block_group_id,
fout_date,
mat_item,
cnt
FROM civic.block_group_sum
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$material = strtoupper(substr($row['mat_item'],0,1));
	$item = substr($row['mat_item'],1);
	
	if ($item < 10) $item = "00$item";
	else if ($item < 100) $item = "0$item";
	
	$sql = "select AREA_ID from civic_new.block where BLOCK_ID = \"$row[block_group_id]\"";
	
	$result2 = mysql_query($sql);
	$row2 = mysql_fetch_assoc($result2);
	
	$area = $row2['AREA_ID'];
	
	mysql_free_result($result2);
	
	$sql =

"
INSERT INTO civic_new.block_sum (
`BLOCK_ID`,
`AREA_ID`,
`MATERIAL_ID`,
`ITEM_ID`,
`CHECKOUT_DATE`,
`CHECKOUTS`
) VALUES (
\"$row[block_group_id]\",
\"$area\",
\"$material\",
\"$item\",
\"$row[fout_date]\",
\"$row[cnt]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>