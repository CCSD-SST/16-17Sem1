<?php
require_once 'config.php';
require_once "functions.php";

promptLogin();
$g_link = mysql_connect('localhost', $g_username, $g_password); //TODO use a persistant database connections
$devicequery = "SELECT * FROM `devices` WHERE status_id < 4";
mysql_select_db('stt', $g_link);

$categoryquery = "SELECT name, id FROM devicecategories";

$result2 = mysql_query($categoryquery);
while ($row = mysql_fetch_assoc($result2)) {
	$devicearray[$row['id']]=$row['name'];
}	
$namequery = "SELECT name, id FROM students";

$result3 = mysql_query($namequery);
while ($row = mysql_fetch_assoc($result3)) {
	$namearray[$row['id']]=$row['name'];
}


$result = mysql_query($devicequery);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
makeHeader("STT HOME","Broken Chromebooks",2,"DisplayBroken.php","<style>td{color:white;}</style>");
// prints one row at a time, the results from the database.
echo "<table border=1>";
echo "<tr><td>Owner</td><td>Assigned To</td><td>Received</td><td>Problem</td><td>Resolution</td><td>Notes</td><td>Repaired</td><td>Returned</td><td>Last Update</td><td>Received By</td><td>Serial Number</td>
<td>Point Value</td><td>Status</td></tr>";
while ($row = mysql_fetch_assoc($result)) { // TODO format to look better
//	print_r($row);die;
    echo "<tr><td>".$row['owner'].
			"</td><td>".$namearray[$row['assignedto_id']].
			"</td><td>".$row['received'].
			"</td><td>".$row['problem'].
			"</td><td>".$row['resolution'].
			"</td><td>".$row['notes'].
			"</td><td>".$row['repaired'].
			"</td><td>".$row['returned'].
			"</td><td>".$row['last_update'].
			"</td><td>".$namearray[$row['receivedby_id']].
			"</td><td>".$row['serial'].
			"</td><td>".$row['point_value'].
			"</td><td>".$devicearray[$row['status_id']]."</td></tr>";
}
echo "</table>";
mysql_close($g_link);
makefooter("&#169; Copyright Cherokee Washington Highschool <a href='index.php'> Home Page<a/><a href='' onclick='initIt()'>About us</a> <style>#footer a{color:black; margin-left:3px;}#footer p{color:black; text-decoration:underlined;}</style>",0,"true");
?>
