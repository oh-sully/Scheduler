<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "availabilities";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(mysqli_connect_errno())	{
	die("Database connection failed: " . mysqli_connect_error() . " ( " . mysqli_connect_errno() . " ) " );
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Backend</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<?php

      if(!is_null($_POST[sex]))     {
            echo !is_null($_POST[sex]);
            $query = "UPDATE responder_info SET fname = '" . mysql_real_escape_string($_POST['fname']) . "', lname = '" . mysql_real_escape_string($_POST['lname']) . "', sex = '$_POST[sex]', year = '$_POST[year]', driver = '$_POST[driver]' WHERE id = '$_POST[id_edit]'";
            $result = mysqli_query($conn, $query);
            if(!$result)      {
                  die("Update failed");
            }
      }
      
?>

<h1>Scheduling Application</h1>

      <h3>Edit a Responder</h3>
      <form action=editresponder.php method="post">
      Who would you like to edit?<br>
	  <?php
		$query = "SELECT * FROM responder_info";
		$result = mysqli_query($conn, $query);
		if (!$result)	{
			die("Database query 1 failed");
		}
		?>
			<select name="id_edit" onchange="this.form.submit()">
					<option disabled selected></option>
				<?php
					while($row = mysqli_fetch_assoc($result)){
				?>
					<option value=<?php echo $row["id"]?>> <?php echo $row["fname"] . " " . $row["lname"]?></option>
				<?php
					}
				?>
			</select>
      </form>
      <form action=editresponder.php method="post">
      <br>
      <br>
      <?php
      $query  = "SELECT * FROM responder_info WHERE id = $_POST[id_edit]";
      $result2 = mysqli_query($conn, $query);
      if(!$result)      {
            die("Database Query 2 Failed");
      }
      $row = mysqli_fetch_assoc($result2);
      ?>

      <input type="hidden" name="id_edit" value=<?php $row['id']?>>
      First Name: <input type="text" name="fname" value=<?php echo $row['fname']?>>
      <br>
      Last Name: <input type="text" name="lname" value=<?php echo $row['lname']?>>
      <br>
      <br>
      <p>Sex:</p>
      <?php
            if($row["sex"] == 1)      {
                  echo "<input type=\"radio\" name=\"sex\" value=1 checked> Male";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"sex\" value=0> Female";
            }
            elseif ($row["sex"] == 0) {
                  echo "<input type=\"radio\" name=\"sex\" value=1> Male";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"sex\" value=0 checked> Female";
            }
            else{
                  echo "<input type=\"radio\" name=\"sex\" value=1 checked> Male";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"sex\" value=0> Female";
            }
            echo "<br>";
            echo "<br>";
            echo "Year:";
            echo "<br>";
            if($row["year"] == 1)      {
                  echo "<input type=\"radio\" name=\"year\" value=1 checked> 1";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=2> 2";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=3> 3";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=4> 4";
                  echo "<br>";
            }
            elseif ($row["year"] == 2) {
                  echo "<input type=\"radio\" name=\"year\" value=1> 1";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=2 checked> 2";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=3> 3";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=4> 4";
                  echo "<br>";
            }
            elseif ($row["year"] == 3) {
                  echo "<input type=\"radio\" name=\"year\" value=1> 1";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=2> 2";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=3 checked> 3";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=4> 4";
                  echo "<br>";
            }
            elseif ($row["year"] == 4) {
                  echo "<input type=\"radio\" name=\"year\" value=1> 1";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=2> 2";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=3> 3";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=4 checked> 4";
                  echo "<br>";
            }
            else{
                  echo "<input type=\"radio\" name=\"year\" value=1 checked> 1";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=2> 2";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=3> 3";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"year\" value=4> 4";
                  echo "<br>";
            }
            echo "<br>";
            echo "<br>";
            echo "Driver?";
            echo "<br>";
            if($row["driver"] == 0)      {
                  echo "<input type=\"radio\" name=\"driver\" value=0 checked> No";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"driver\" value=1> Yes";
            }
            elseif ($row["driver"] == 1) {
                  echo "<input type=\"radio\" name=\"driver\" value=0> No";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"driver\" value=1 checked> Yes";
            }
            else{
                  echo "<input type=\"radio\" name=\"driver\" value=0 checked> No";
                  echo "<br>";
                  echo "<input type=\"radio\" name=\"driver\" value=1> Yes";
            }
            echo "<br>";
            echo "<br>";
      ?>

      Are you sure you wish to change these details?
      <br>
      <input type="submit" value="Yes, edit them.">
      </form>

    <form action=Website%20-%20Backend.php method="post">
    <input type="hidden" name="month" value=<?php $_POST['month']?>>
    <br>
    <br>
    <input type="submit" value="Main Page">
    </form>

<?php mysqli_close($conn) ?>
</body>
</html>
