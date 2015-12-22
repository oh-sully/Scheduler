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

<h1>Scheduling Application</h1>

<div class="container">
  <h2>Welcome Back Admin!</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#scheduler">Scheduler</a></li>
    <li><a data-toggle="tab" href="#add">Add a Responder</a></li>
    <li><a data-toggle="tab" href="#edit">Edit a Responder</a></li>
    <li><a data-toggle="tab" href="#delete">Delete a Responder</a></li>
    <li><a data-toggle="tab" href="#availability">Responder's Availability</a></li>
    <li><a data-toggle="tab" href="#settings">Settings</a></li>
  </ul>

  <div class="tab-content">
    <div id="scheduler" class="tab-pane fade in active">
<!-- !!! -->

<h3><?php echo $_POST[month]?></h3>

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
			
			session_start();
			$_SESSION['month'] = "$_POST[month]";
			if(!$_SESSION['month'])	{
				$selected_month = "$_POST[month]";
			}
			else{
				$selected_month = $_SESSION['month'];
			}
			$query8 = "SELECT * FROM $selected_month";
			$month_table = mysqli_query($conn, $query8);
			if (!$month_table)	{
				echo "There are currently no responders in the database";
			}
			$days_in_month = mysqli_num_fields($month_table);
			$days_in_month = ($days_in_month-1)/2;	//figures out how many days are in the month; -1 takes out id field, /2 b/c of AM and PM fields

			if($selected_month == "September")	{
				$month_num = 09;
				if(date("m") > 5){
				$year_num = date("y");
				}
				else{
					$year_num = date("y", strtotime("last year"));
				}
			}
			elseif($selected_month == "October")	{
				$month_num = 10;
				if(date("m") > 5){
				$year_num = date("y");
				}
				else{
					$year_num = date("y", strtotime("last year"));
				}
			}
			elseif($selected_month == "November")	{
				$month_num = 11;
				if(date("m") > 5){
				$year_num = date("y");
				}
				else{
					$year_num = date("y", strtotime("last year"));
				}
			}
			elseif($selected_month == "December")	{
				$month_num = 12;
				if(date("m") > 5){
				$year_num = date("y");
				}
				else{
					$year_num = date("y", strtotime("last year"));
				}
			}
			elseif($selected_month == "January")	{
				$month_num = 01;
				if(date("m") > 5){
				$year_num = date("y", strtotime("next year"));
				}
				else{
					$year_num = date("y");
				}
			}
			elseif($selected_month == "February")	{
				$month_num = 02;
				if(date("m") > 5){
				$year_num = date("y", strtotime("next year"));
				}
				else{
					$year_num = date("y");
				}
			}
			elseif($selected_month == "March")	{
				$month_num = 03;
				if(date("m") > 5){
				$year_num = date("y", strtotime("next year"));
				}
				else{
					$year_num = date("y");
				}
			}
			elseif($selected_month == "April")	{
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
								echo "<td>";
									echo "<table border=\"1\">";
										echo "<tr>";
											echo "<td>AM</td>";
											echo "<td>";
												echo "<table>";
													echo "<tr>";
														echo "<select>";
															$query = "SELECT * FROM $_POST[month] WHERE $day_num_AM < 3"; // < 3 means they said they are either available or prefered
															$result = mysqli_query($conn, $query);
															if (!$result)	{
																die("Database query failed");
															}
															$num_ppl = 0;
															$one_time = 0;
															while($row = mysqli_fetch_assoc($result))	{
																$query2 = "SELECT * FROM responder_info WHERE id = $row[id]";
																$result2 = mysqli_query($conn, $query2);
																$row2 = mysqli_fetch_assoc($result2);
																if(!is_null($row2))	{
																	echo "<option>$row2[fname] $row2[lname]</option>";
																	$num_ppl++;
																	$one_time++;
																}
															}
															if($one_time == 0)	{
																echo "<option disabled>No one</option>";
															}
															echo "<option disabled selected>$num_ppl</option>";
														echo "</select>";
													echo "</tr>";
													echo "<tr>";
														echo "<select>";
															$query = "SELECT * FROM $_POST[month] WHERE $day_num_AM < 3"; // < 3 means they said they are either available or prefered
															$result = mysqli_query($conn, $query);
															if (!$result)	{
																die("Database query failed");
															}
															$num_ppl = 0;
															$one_time = 0;
															while($row = mysqli_fetch_assoc($result))	{
																$query2 = "SELECT * FROM responder_info WHERE id = $row[id] AND driver = 1";
																$result2 = mysqli_query($conn, $query2);
																$row2 = mysqli_fetch_assoc($result2);
																if(!is_null($row2))	{
																	echo "<option>$row2[fname] $row2[lname]</option>";
																	$num_ppl++;
																	$one_time++;
																}
															}
															if($one_time == 0)	{
																echo "<option disabled>No one</option>";
															}
															echo "<option disabled selected>$num_ppl</option>";
														echo "</select>";
													echo "</tr>";
													echo "<tr>";
														echo "<select>";
															$query = "SELECT * FROM $_POST[month] WHERE $day_num_AM < 3"; // < 3 means they said they are either available or prefered
															$result = mysqli_query($conn, $query);
															if (!$result)	{
																die("Database query failed");
															}
															$num_ppl = 0;
															$one_time = 0;
															while($row = mysqli_fetch_assoc($result))	{
																$query2 = "SELECT * FROM responder_info WHERE id = $row[id] AND year > 1";
																$result2 = mysqli_query($conn, $query2);
																$row2 = mysqli_fetch_assoc($result2);
																if(!is_null($row2))	{
																	echo "<option>$row2[fname] $row2[lname]</option>";
																	$num_ppl++;
																	$one_time++;
																}
															}
															if($one_time == 0)	{
																echo "<option disabled>No one</option>";
															}
															echo "<option disabled selected>$num_ppl</option>";
														echo "</select>";
													echo "</tr>";
												echo "</table>";
											echo "</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td>PM</td>";
											echo "<td>";
												echo "<table>";
													echo "<tr>";
														echo "<select>";
															$query = "SELECT * FROM $_POST[month] WHERE $day_num_PM < 3"; // < 3 means they said they are either available or prefered
															$result = mysqli_query($conn, $query);
															if (!$result)	{
																die("Database query failed");
															}
															$num_ppl = 0;
															$one_time = 0;
															while($row = mysqli_fetch_assoc($result))	{
																$query2 = "SELECT * FROM responder_info WHERE id = $row[id]";
																$result2 = mysqli_query($conn, $query2);
																$row2 = mysqli_fetch_assoc($result2);
																if(!is_null($row2))	{
																	echo "<option>$row2[fname] $row2[lname]</option>";
																	$num_ppl++;
																	$one_time++;
																}
															}
															if($one_time == 0)	{
																echo "<option disabled>No one</option>";
															}
															echo "<option disabled selected>$num_ppl</option>";
														echo "</select>";
													echo "</tr>";
													echo "<tr>";
														echo "<select>";
															$query = "SELECT * FROM $_POST[month] WHERE $day_num_PM < 3"; // < 3 means they said they are either available or prefered
															$result = mysqli_query($conn, $query);
															if (!$result)	{
																die("Database query failed");
															}
															$num_ppl = 0;
															$one_time = 0;
															while($row = mysqli_fetch_assoc($result))	{
																$query2 = "SELECT * FROM responder_info WHERE id = $row[id] AND driver = 1";
																$result2 = mysqli_query($conn, $query2);
																$row2 = mysqli_fetch_assoc($result2);
																if(!is_null($row2))	{
																	echo "<option>$row2[fname] $row2[lname]</option>";
																	$num_ppl++;
																	$one_time++;
																}
															}
															if($one_time == 0)	{
																echo "<option disabled>No one</option>";
															}
															echo "<option disabled selected>$num_ppl</option>";
														echo "</select>";
													echo "</tr>";
													echo "<tr>";
														echo "<select>";
															$query = "SELECT * FROM $_POST[month] WHERE $day_num_PM < 3"; // < 3 means they said they are either available or prefered
															$result = mysqli_query($conn, $query);
															if (!$result)	{
																die("Database query failed");
															}
															$num_ppl = 0;
															$one_time = 0;
															while($row = mysqli_fetch_assoc($result))	{
																$query2 = "SELECT * FROM responder_info WHERE id = $row[id] AND year > 1";
																$result2 = mysqli_query($conn, $query2);
																$row2 = mysqli_fetch_assoc($result2);
																if(!is_null($row2))	{
																	echo "<option>$row2[fname] $row2[lname]</option>";
																	$num_ppl++;
																	$one_time++;
																}
															}
															if($one_time == 0)	{
																echo "<option disabled>No one</option>";
															}
															echo "<option disabled selected>$num_ppl</option>";
														echo "</select>";
													echo "</tr>";
												echo "</table>";
											echo "</td>";
										echo "</tr>";
									echo "</table>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
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
		</table>
		<br>
		<br>
		<p>Don't forget to take a screenshot when you're done!</p>
    </div>
    <div id="add" class="tab-pane fade">
      <h3>Add a Responder</h3>
      <form action=addresponder.php method="post">
      
      <input type="hidden" name="month" value=<?php echo $_POST[month] ?>>
      Who would you like to add? <br> <br>
      First name: <input type="text" name="fname">
      <br> <br>
      Last name: <input type="text" name="lname">
      <br> <br>
      What is their sex?<br>
      	<input type="radio" name="sex" value=1 checked> Male <br>
  		<input type="radio" name="sex" value=0> Female
  		<br> <br>
      What year on the team are they? (1=Rookie, 2 = Completed at least one full year, 3 = Obvious, 4+ = Obvious) <br>
      <input type="radio" name="year" value=1 checked> 1 <br>
      <input type="radio" name="year" value=2> 2 <br>
      <input type="radio" name="year" value=3> 3 <br>
      <input type="radio" name="year" value=4> 4+ <br>
      <br> <br>
      Are they a driver?<br>
      	<input type="radio" name="driver" value=0 checked> No <br>
  		<input type="radio" name="driver" value=1> Yes
  		<br> <br>
  	<input type="submit" value="Finish adding responder">
  	</form>
    </div>

    <div id="edit" class="tab-pane fade">
      <h3>Edit a Responder</h3>
      <form action=editresponder.php method="post">
      <input type="hidden" name="month" value=<?php echo $_POST[month] ?>>
      Who would you like to edit?
      <br>
	  <?php
		$query = "SELECT * FROM responder_info";
		$result = mysqli_query($conn, $query);
		if (!$result)	{
			?>
			<select>
				<option disabled></option>
			</select>
			<br>
			<br>
			<p>There are no responders in the database</p>
		<?php
		}
		else{
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
      <?php
  		}
  		?>
    </div>

    <div id="delete" class="tab-pane fade">
      <h3>Delete a Responder</h3>
      <form action=deleteresponder.php method="post">
      Who would you like to delete?<br>
	  <?php
		$query = "SELECT * FROM responder_info";
		$result = mysqli_query($conn, $query);
		if (!$result)	{
			?>
			<select>
				<option disabled></option>
			</select>
			<br>
			<br>
			<p>There are no responders in the database</p>
		<?php
		}
		else{
		?>
			<select name="id_to_be_deleted">
					<option disabled selected></option>
				<?php
					while($row = mysqli_fetch_assoc($result)){
				?>
					<option value=<?php echo $row["id"]?>> <?php echo $row["fname"] . " " . $row["lname"]?></option>
				<?php
					}
				?>
			</select>
      <br><br>
      Are you sure you wish to delete them?
      <br>
      <input type="submit" value="Yes, delete them.">
      </form>
      <?php
  		}
  		?>
    </div>

    <div id="availability" class="tab-pane fade">
    	<h3>Responder's Availability</h3>
		<form action=responderavail.php method="post">
  			Name:
		  <?php
			$query = "SELECT * FROM responder_info";
			$result = mysqli_query($conn, $query);
			if (!$result)	{
			?>
				<select>
					<option disabled></option>
				</select>
				<br>
				<br>
				<p>There are no responders in the database</p>
			<?php
			}
			else{
			?>
			<select name="id_view">
				<option disabled selected value=0></option>
				<?php
					while($row = mysqli_fetch_assoc($result)){
				?>
					<option value=<?php echo $row["id"]?>> <?php echo $row["fname"] . " " . $row["lname"]?></option>
				<?php
					}
				?>
			</select>
			Month:
			<select name="month_view">
				<option value="September">September</option>
				<option value="October">October</option>
				<option value="November">November</option>
				<option value="December">December</option>
				<option value="January">January</option>
				<option value="February">February</option>
				<option value="March">March</option>
				<option value="April">April</option>
			</select>
			<?php
	  		}
	  		?>
	  		<input type="submit" value="Update">
  		</form>
  		<br>
  		
	</div>

    <div id="settings" class="tab-pane fade">
      <h3>Settings</h3>
      <a href="AdminLogin.php">Logout</a>
    </div>

  </div>

<?php mysqli_close($conn) ?>
</body>
</html>
