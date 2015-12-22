<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "availabilities";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(mysqli_connect_errno())	{
	die("Database connection failed: " . mysqli_connect_error() . " ( " . mysqli_connect_errno() . " ) " );
}

$query = "SELECT * FROM responder_info";
$result = mysqli_query($conn, $query);
$doublequery = "SELECT * FROM `responder_info` WHERE id = {$_POST[id_to_be_deleted]} LIMIT 1";
$doubleresult = mysqli_query($conn, $doublequery);
if(!$doubleresult)	{
	die("That responder has already been deleted " . mysqli_error($conn));
}
$month = array("September", "October", "November", "December", "January", "February", "March", "April");
$num_rows = mysqli_num_rows($result);

if(!$result || $num_rows == 0)	{
	echo "There are no responders to delete.";
}
elseif($num_rows == 1)	{
	$i = 0;
	while($i<8)	{
		$deletetable = "DROP TABLE `$month[$i]`";
		$result2 = mysqli_query($conn, $deletetable);
		if(!$result2)	{
			die("Query deleting table $month[$i] failed " . mysqli_error($conn));
		}
		$i++;
	}
	$deletetable = "DROP TABLE `responder_info`";
	$result3 = mysqli_query($conn, $deletetable);
	if(!$result3)	{
		die("Query deleting table responder_info failed " . mysqli_error($conn));
	}
}
else{
	$i = 0;
	while($i<8)	{
		$deleterow = "DELETE FROM `$month[$i]` WHERE id = {$_POST[id_to_be_deleted]} LIMIT 1";
		$result2 = mysqli_query($conn, $deleterow);
		if(!$result2)	{
			die("Query deleting row from table $month[$i] failed " . mysqli_error($conn));
		}
		$i++;
	}
}

if($num_rows > 1)	{
	$query2  = "DELETE FROM responder_info WHERE id = {$_POST[id_to_be_deleted]} LIMIT 1";

	$result = mysqli_query($conn, $query2);
	if(!$result)	{
			die("Responder with id = $_POST[id_to_be_deleted] has already been deleted. " . mysqli_error($conn));
		}
}

if($result) 	{
	//Success
	echo "Responder with id = " . $_POST[id_to_be_deleted] . " has been deleted";
	echo "<br> <br>";
	echo "<form action=Website%20-%20Backend.php method=\"post\">";
    echo "<input type=\"hidden\" name=\"month\" value=$_POST[month]> ";
    echo "<input type=\"submit\" value=\"Main Page\">";
    echo "</form>";
}
else  {
	//Failure
	die("Mysqli query2 failed. " . mysqli_error($conn));
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
<title>Backend</title>
</head>
<body>
</body>
</html>
