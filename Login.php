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

Welcome to the scheduling application! <br><br>

Who are you?
<form action=Website-FrontEnd.php method="post">
		<?php
		$query = "SELECT * FROM responder_info";
		$result = mysqli_query($conn, $query);
		if (!$result)	{
			die("Database query failed");
		}
		?>
			<select name="id_selected">
				<?php
					while($row = mysqli_fetch_assoc($result)){
				?>
					<option value=<?php echo $row["id"]?>> <?php echo $row["fname"] . " " . $row["lname"]?><option>
				<?php
					}
				?>
			</select>
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

    <br> <br>

</form>
<a href="AdminLogin.php">Admin Login</a>
</body>
</html>
