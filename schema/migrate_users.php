<?php

$DB_HOST = "184.106.220.22";
$DB_USER = "civic_user";
$DB_PASS = "ClvlC";

$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

$sql =

"
SELECT
id,
email,
password,
validation,
temppass,
valid
FROM civic.users
";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$email = strtolower(ltrim(rtrim($row['email'])));
	
	$sql =

"
INSERT INTO civic_new.users (
`USER_ID`,
`EMAIL`,
`PASSWORD`,
`TEMPPASS`,
`VALIDATION`,
`VALID`
) VALUES (
\"$row[id]\",
\"$email\",
\"$row[password]\",
\"$row[temppass]\",
\"$row[validation]\",
\"$row[valid]\"
)
";

	if (!mysql_query($sql)) die(mysql_error()."<br /><br />".$sql);	
}

mysql_free_result($result);
mysql_close($link);

?>