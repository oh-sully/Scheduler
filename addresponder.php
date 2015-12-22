<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "availabilities";
$conn = mysqli_connect($servername, $username, $password, $dbname);
        
    session_start();
    $query = "SELECT * FROM responder_info";
    $result = mysqli_query($conn, $query);
    $month = array("September", "October", "November", "December", "January", "February", "March", "April");
    $num_rows = mysqli_num_rows($result);
    if($num_rows == 0 || !$result)	{
    	
        $createtable = "CREATE TABLE `responder_info` (id INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY, fname VARCHAR(20) NOT NULL , lname VARCHAR(20) NOT NULL , sex INT(1) NOT NULL , year INT(1) NOT NULL , driver INT(1) NOT NULL)";
        $result2 = mysqli_query($conn, $createtable);
        if(!$result2)   {
            die("Query creating table responder_info failed " . mysqli_error($conn));
        }

        $i = 0;
    	while($i < 8)	{
    		if($i < 4)	{
    			$days_in_month = cal_days_in_month(CAL_GREGORIAN, $i + 9, date('Y'));
    		}
    		else{
    			$days_in_month = cal_days_in_month(CAL_GREGORIAN, $i - 3, date('Y', strtotime('+1 year')));
    		}
    		$result = mysqli_query($conn, "CREATE TABLE `$month[$i]` ( id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY )");
			$j = 1;
			while ($j <= $days_in_month)
			{
			    $column_AM = "day_".$j."_AM";
			    $sql = "ALTER TABLE `$month[$i]` ADD `$column_AM` INT(1) NOT NULL DEFAULT 1; " ;
			    mysqli_query($conn, $sql);
                $column_PM = "day_".$j."_PM";
                $sql2 = "ALTER TABLE `$month[$i]` ADD `$column_PM` INT(1) NOT NULL DEFAULT 1; " ;
                mysqli_query($conn, $sql2);
				$j++;
			}
				$sql3 = "INSERT INTO `$month[$i]` (day_1_AM, day_1_PM) VALUES ('1', '1')";
			    mysqli_query($conn, $sql3);
			$i++;
    	}
    }
    else{
    	$i = 0;
    	while($i < 8)	{
    		$sql = "INSERT INTO `$month[$i]` (day_1_AM, day_1_PM) VALUES ('1', '1')";
			mysqli_query($conn, $sql);
			$i++;
		}
    }

        $enterinfo = "INSERT INTO responder_info (fname, lname, sex, year, driver)
    VALUES ('" . mysql_real_escape_string($_POST['fname']) . "', '" . mysql_real_escape_string($_POST['lname']) . "', '$_POST[sex]', '$_POST[year]', '$_POST[driver]')";
    $result = mysqli_query($conn, $enterinfo);
        if (!$result)   {
            die("Database query failed");
        }

    echo "<form action=Website%20-%20Backend.php method=\"post\">";
    echo "<input type=\"hidden\" name=\"month\" value=$_POST[month]> ";
    echo "$_POST[fname] $_POST[lname] added successfully";
    echo "<br> <br>";
    echo "<input type=\"submit\" value=\"Main Page\">";
    echo "</form>";
    //header("refresh: 1.5; url=Website%20-%20Backend.php");

$conn = null;
?>

<html>
<body>

</body>
</html>
