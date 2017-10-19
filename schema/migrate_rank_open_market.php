<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
sa,
open_market
FROM civic.rank_open_market
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$sql =

"
INSERT INTO civic_new.rank_open_market (
`AREA_ID`,
`OPEN_MARKETS`
) VALUES (
\"$row[sa]\",
\"$row[open_market]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>