<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
sa,
v
FROM civic.rank_patrons
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$sql =

"
INSERT INTO civic_new.rank_patron (
`AREA_ID`,
`PATRONS`
) VALUES (
\"$row[sa]\",
\"$row[v]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>