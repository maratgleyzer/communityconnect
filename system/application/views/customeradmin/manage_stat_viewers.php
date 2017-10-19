<div class="instructions">Check the box for library users you want to be able to view usage stats</div>
<div style="font-size:13px; margin-left:10px; margin-top:10px;" class="rrow">
<table>
	<tr>
		<th style="width:45px">View</th>
		<th style="width:200px">Email</th>
		<th style="width:30px">UserID</th>
	</tr>
<?php 
foreach ($all_users as $user) {
	echo "<tr>";
	echo "		<td><input type=\"checkbox\"></td>";
	echo "		<td>".$user->EMAIL."</td>";
	echo "		<td>".$user->USER_ID."</td>";
	echo "</tr>";
}
?>
</table>
</div>
