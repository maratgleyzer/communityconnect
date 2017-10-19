<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
item_types,
description,
apnf,
apf,
ap,
aavg,
aavs,
aav,
jpnf,
jpf,
jp,
javg,
javs,
jav,
yap,
yaav,
jyap,
jyaav,
tnf,
tf,
tavg,
tavs,
tp,
tav,
ta,
tj,
tya,
tjya,
tno,
oav,
op,
oi,
totother
FROM civic.item_types
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$id = $row['item_types'];
	
	if ($id < 10) $id = "00$id";
	else if ($id < 100) $id = "0$id";
	
	$sql =

"
INSERT INTO civic_new.item (
`ITEM_ID`,
`ITEM`,
`APNF`,
`APF`,
`AP`,
`AAVG`,
`AAVS`,
`AAV`,
`JPNF`,
`JPF`,
`JP`,
`JAVG`,
`JAVS`,
`JAV`,
`YAP`,
`YAAV`,
`JYAP`,
`JYAAV`,
`TNF`,
`TF`,
`TAVG`,
`TAVS`,
`TP`,
`TAV`,
`TA`,
`TJ`,
`TYA`,
`TJYA`,
`TNO`,
`OAV`,
`OP`,
`OI`,
`TOT_OTHER`
) VALUES (
\"$id\",
\"$row[description]\",
\"$row[apnf]\",
\"$row[apf]\",
\"$row[ap]\",
\"$row[aavg]\",
\"$row[aavs]\",
\"$row[aav]\",
\"$row[jpnf]\",
\"$row[jpf]\",
\"$row[jp]\",
\"$row[javg]\",
\"$row[javs]\",
\"$row[jav]\",
\"$row[yap]\",
\"$row[yaav]\",
\"$row[jyap]\",
\"$row[jyaav]\",
\"$row[tnf]\",
\"$row[tf]\",
\"$row[tavg]\",
\"$row[tavs]\",
\"$row[tp]\",
\"$row[tav]\",
\"$row[ta]\",
\"$row[tj]\",
\"$row[tya]\",
\"$row[tjya]\",
\"$row[tno]\",
\"$row[oav]\",
\"$row[op]\",
\"$row[oi]\",
\"$row[totother]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>