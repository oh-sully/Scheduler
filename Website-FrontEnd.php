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
<title>Front End</title>
</head>
<body>

<?php
	$query = "SELECT * FROM responder_info WHERE id=$_POST[id_selected]";
	$result = mysqli_query($conn, $query);
	if (!$result)	{
		die("Database query failed");
	}
	$row = mysqli_fetch_assoc($result);
?>
<div align="right">
<a href="Login.php">Log out</a>
</div>
<h1><?php echo $row["fname"] . " " . $row["lname"] . "'s"?> Availability</h1>
<table>
	<tr>
		<th>Name:</th>
		<th>
			<select>
				<?php
					$query = "SELECT * FROM responder_info";
					$result = mysqli_query($conn, $query);
					if (!$result)	{
						die("Database query failed");
					}
					$row = mysqli_fetch_assoc($result);
				?>
				<?php
					while($row = mysqli_fetch_assoc($result)){
				?>
					<option> <?php echo $row["fname"] . " " . $row["lname"]?></option>
				<?php
					}
				?>
			</select>
		</th>
	</tr>
</table>

<form action=addavailability.php method="post">

	<table border="1" style="width:100%">
	  <tr>
	    <th style="width:14.28%">Sunday</th>
	    <th style="width:14.28%">Monday</th>		
	    <th style="width:14.28%">Tuesday</th>
	    <th style="width:14.28%">Wednesday</th>
	    <th style="width:14.28%">Thursday</th>
	    <th style="width:14.28%">Friday</th>
	    <th style="width:14.28%">Saturday</th>
	  </tr>

	<?php 

	$selected_month = "$_POST[month]";

	$query2 = "SELECT * FROM $selected_month WHERE id = $_POST[id_selected]";
	$month_being_edited = mysqli_query($conn, $query2);
			if (!$month_being_edited)	{
				die("Database query2 failed");
			}
	$row2 = mysqli_fetch_assoc($month_being_edited);

	$days_in_month = mysqli_num_fields($month_being_edited);
	$days_in_month = ($days_in_month-1)/2;	//figures out how many days are in the month; -1 takes out id field, /2 b/c of AM and PM fields

	if($_POST[$selected_month] == "September")	{
		$month_num = 09;
		if(date("m") > 5){
		$year_num = date("y");
		}
		else{
			$year_num = date("y", strtotime("last year"));
		}
	}
	elseif($_POST[$selected_month] == "October")	{
		$month_num = 10;
		if(date("m") > 5){
		$year_num = date("y");
		}
		else{
			$year_num = date("y", strtotime("last year"));
		}
	}
	elseif($_POST[$selected_month] == "November")	{
		$month_num = 11;
		if(date("m") > 5){
		$year_num = date("y");
		}
		else{
			$year_num = date("y", strtotime("last year"));
		}
	}
	elseif($_POST[$selected_month] == "December")	{
		$month_num = 12;
		if(date("m") > 5){
		$year_num = date("y");
		}
		else{
			$year_num = date("y", strtotime("last year"));
		}
	}
	elseif($_POST[$selected_month] == "January")	{
		$month_num = 01;
		if(date("m") > 5){
		$year_num = date("y", strtotime("next year"));
		}
		else{
			$year_num = date("y");
		}
	}
	elseif($_POST[$selected_month] == "February")	{
		$month_num = 02;
		if(date("m") > 5){
		$year_num = date("y", strtotime("next year"));
		}
		else{
			$year_num = date("y");
		}
	}
	elseif($_POST[$selected_month] == "March")	{
		$month_num = 03;
		if(date("m") > 5){
		$year_num = date("y", strtotime("next year"));
		}
		else{
			$year_num = date("y");
		}
	}
	elseif($_POST[$selected_month] == "April")	{
		$month_num = 04;
		if(date("m") > 5){
		$year_num = date("y", strtotime("next year"));
		}
		else{
			$year_num = date("y");
		}
	}

	$dow_num = date("w", strtotime("$selected_month 1 $year_num"));

	$k = 0;
	$i = 1;
	$m = 1;
	while($m <= $days_in_month)	{	//Loops through the weeks in the month
		echo "<tr>";
		$j=1;
		while($j<=7)	{	//Loops through the days in a single week
			$day_num_AM = "day_" . $i. "_AM";
			$day_num_PM = "day_" . $i . "_PM";
			
			echo "<td>";
			if(($k >= $dow_num) && (($k-$dow_num) < $days_in_month)){		
				echo "<table>";
					echo "<tr>";
						if($i<10){	//This if-statment keeps the dates in line
						echo "<td valign=\"top\">0" . $i . "</td>";
						}
						else{
							echo "<td valign=\"top\">" . $i . "</td>";
						}
						?>
						<td>
							<table border=\"1\">
								<tr>
									<td>AM</td>
									<td>
										<select name="day_<?php echo $i ?>_AM_availability">
											<?php if($row2[$day_num_AM] == 1)	//These if-statements defaults the choices as to what is already in the database
											{	?>
												<div style = "background-color:red" ><option value=1 selected>Available</option></div>
												<div style = "background-color:red" ><option value=2>Prefered</option></div>
												<div style = "background-color:red" ><option value=3>Unavailable</option></div>
												<div style = "background-color:red" ><option value=4>Exam</option></div>
											<?php 
											}
											elseif($row2[$day_num_AM] == 2)
											{	?>
												<option value=1>Available</option>
												<option value=2 selected>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}
											elseif($row2[$day_num_AM] == 3)
											{	?>
												<option value=1>Available</option>
												<option value=2>Prefered</option>
												<option value=3 selected>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}
											elseif($row2[$day_num_AM] == 4)
											{	?>
												<option value=1>Available</option>
												<option value=2>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4 selected>Exam</option>
											<?php
											}	
											else
											{	?>
												<option value=1>Available</option>
												<option value=2>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}	?>	
										</select>
									</td>
								</tr>

								<tr>
									<td>PM</td>
									<td>
										<select name="day_<?php echo $i ?>_PM_availability">
											<?php
											if($row2[$day_num_PM] == 1)
											{	?>
												<option value=1 selected>Available</option>
												<option value=2>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}
											elseif($row2[$day_num_PM] == 2)
											{	?>
												<option value=1>Available</option>
												<option value=2 selected>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}
											elseif($row2[$day_num_PM] == 3)
											{	?>
												<option value=1>Available</option>
												<option value=2>Prefered</option>
												<option value=3 selected>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}
											elseif($row2[$day_num_PM] == 4)
											{	?>
												<option value=1>Available</option>
												<option value=2>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4 selected>Exam</option>
											<?php
											}	
											else
											{	?>
												<option value=1>Available</option>
												<option value=2>Prefered</option>
												<option value=3>Unavailable</option>
												<option value=4>Exam</option>
											<?php
											}	?>
										</select>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php
				$i++;
			}
			echo "</td>";

			$k++;
			$j++;
			$m++;
		}
	}

	?>

	  </tr>
	</table>
	<br>
	<input type="hidden" name="selected_month" value=<?php echo $selected_month ?>>
	<input type="hidden" name="selected_id" value=<?php echo $_POST[id_selected]?>>
	<div align="center"><input type="submit" value="Submit"></div>
</form>

<?php
mysqli_close($conn);
?>
</body>
</html>
