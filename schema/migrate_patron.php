<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
id,
ADDRESS,
CITY,
STATE,
ZIP_CODE,
MAT_LAT,
MAT_LON,
EXP_DATE,
HISTCKO,
block_group_id,
SQMI,
sa
FROM civic.patrons
";

$result = mysql_query($sql);
echo mysql_error();

while ($row = mysql_fetch_assoc($result))
{
	$address = ucwords(strtolower(ltrim(rtrim($row['ADDRESS']))));
	$city = ucwords(strtolower(ltrim(rtrim($row['CITY']))));
	$state = strtoupper(ltrim(rtrim($row['STATE'])));
	
	$address = eregi_replace('[\\]','',$address);
	
	$sql =

"
INSERT IGNORE INTO civic_new.patron (
`PATRON_ID`,
`BLOCK_ID`,
`AREA_ID`,
`ADDRESS`,
`CITY`,
`STATE`,
`ZIP_CODE`,
`LATITUDE`,
`LONGITUDE`,
`EXPIRE_DATE`,
`HISTCKO`,
`SQMI`
) VALUES (
\"$row[id]\",
\"$row[block_group_id]\",
\"$row[sa]\",
\"$address\",
\"$city\",
\"$state\",
\"$row[ZIP_CODE]\",
\"$row[MAT_LAT]\",
\"$row[MAT_LON]\",
\"$row[EXP_DATE]\",
\"$row[HISTCKO]\",
\"$row[SQMI]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);
}

mysql_free_result($result);
mysql_close($link);

?>