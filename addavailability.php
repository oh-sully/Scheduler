<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "availabilities";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(mysqli_connect_errno())	{
	die("Database connection failed: " . mysqli_connect_error() . " ( " . mysqli_connect_errno() . " ) " );
}

$query = "SELECT * FROM $_POST[selected_month] WHERE id = $_POST[selected_id]";
$month_being_edited = mysqli_query($conn, $query);
if (!$month_being_edited)	{
		die("Database query failed");
}
$row = mysqli_fetch_assoc($month_being_edited);

$days_in_month = mysqli_num_fields($month_being_edited);
$days_in_month = ($days_in_month-1)/2;	//figures out how many days are in the month; -1 takes out id field, /2 b/c of AM and PM fields

$i=1;
while($i<$days_in_month)
{

	$day_num_AM = "day_" . $i . "_AM";
	$day_num_PM = "day_" . $i . "_PM";
	$day_num_AM_availability = "day_" . $i . "_AM_availability";
	$day_num_PM_availability = "day_" . $i . "_PM_availability";

	$sql = "UPDATE $_POST[selected_month] SET $day_num_AM=$_POST[$day_num_AM_availability] WHERE id=$_POST[selected_id]";
	mysqli_query($conn, $sql);

	$sql2 = "UPDATE $_POST[selected_month] SET $day_num_PM=$_POST[$day_num_PM_availability] WHERE id=$_POST[selected_id]";
	mysqli_query($conn, $sql2);

	$i++;
}

header("refresh: 0.5; url=Login.php");

mysqli_close($conn);

?>
