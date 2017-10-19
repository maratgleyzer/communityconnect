<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
sa,
pop
FROM civic.rank_population
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$sql =

"
INSERT INTO civic_new.rank_population (
`AREA_ID`,
`POPULATION`
) VALUES (
\"$row[sa]\",
\"$row[pop]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>