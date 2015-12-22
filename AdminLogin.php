<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "availabilities";
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>

<!DOCTYPE html>
<html>
<head>
<title>Front End</title>
</head>
<body>

Welcome to the scheduling application, Admin! <br><br>

Password?
<form action=Website%20-%20Backend.php method="post">
		<input name="password" type="text">
			<br><br>
What month would you like to edit? <br>
			<select name="month">
				<option value="September">September</option>
				<option value="October">October</option>
				<option value="November">November</option>
				<option value="December">December</option>
				<option value="January">January</option>
				<option value="February">February</option>
				<option value="March">March</option>
				<option value="April">April</option>
			</select>
			<br> <br>
			<input type="submit" value="Submit">
</form>
<br>
<br>
<a href="Login.php">General Login</a>
</body>
</html>
