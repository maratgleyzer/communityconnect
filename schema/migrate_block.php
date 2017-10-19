<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
id,
BLKGRP,
SA,
SA2,
TAPSEGNAM,
LIFECODE,
LIFENAME,
STATE_FIPS,
CNTY_FIPS,
TRACT,
SQMI,
TPAT,
HISTCKO,
TCKO_SMPLPERD,
DOMTAP,
TOTPOP_CY
FROM civic.block_groups
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$sql =

"
INSERT INTO civic_new.block (
`BLOCK_ID`,
`BLOCK_GROUP`,
`AREA_ID`,
`AREA_ID_2`,
`TAPSEGNAM`,
`LIFECODE`,
`LIFENAME`,
`STATE_FIPS`,
`CNTY_FIPS`,
`TRACT`,
`SQMI`,
`TPAT`,
`HISTCKO`,
`TCKO_SMPLPERD`,
`DOMTAP`,
`TOTPOP_CY`
) VALUES (
\"$row[id]\",
\"$row[BLKGRP]\",
\"$row[SA]\",
\"$row[SA2]\",
\"$row[TAPSEGNAM]\",
\"$row[LIFECODE]\",
\"$row[LIFENAME]\",
\"$row[STATE_FIPS]\",
\"$row[CNTY_FIPS]\",
\"$row[TRACT]\",
\"$row[SQMI]\",
\"$row[TPAT]\",
\"$row[HISTCKO]\",
\"$row[TCKO_SMPLPERD]\",
\"$row[DOMTAP]\",
\"$row[TOTPOP_CY]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>