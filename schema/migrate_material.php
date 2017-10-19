<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
material_types,
description
FROM civic.material_types
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$id = strtoupper($row['material_types']);
	
	$sql =

"
INSERT INTO civic_new.material (
`MATERIAL_ID`,
`MATERIAL`
) VALUES (
\"$id\",
\"$row[description]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);
}

mysql_free_result($result);
mysql_close($link);

?>