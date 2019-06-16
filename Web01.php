<html>
<head>
 <title>Web-01</title>
</head>
<body>
<p>welcome to web-01 example webpage</p>
<?php
$servername = "localhost";
$username = "root";
$password = "redhat"; 
$dbname = "CernDB"; 

// Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
  if (!$conn) {
	die("Connection failed: " . mysqli_connect_error()); }

// get current processes from table Requests
 echo "<center><table border='1'>";
 echo "<tr><th>ID</th><th>Start Time</th><th>req CPU</th><th>req MEM</th><th>req Time</th></tr>";
 $sqlcurr = "select * from Requests where Name='Node1' and addtime(Starttime,sec_to_time(reqtime))>now();";
 $result = mysqli_query($conn, $sqlcurr);
 $i=1;
 while($row =mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
	echo "<tr><td>";
	echo "".$i;	
	echo "</td><td>";
	echo $row['Starttime'];
	echo "</td><td>";
	echo $row['reqCPU'];
	echo "</td><td>";
	echo $row['reqMEM'];
	echo "</td><td>";
	echo $row['reqTime'];
	echo "</td></tr>";
 $i+=1;
}
echo "</table>";
echo "<br><br>";

// get old processes from table Requests
echo "<h2>History</h2>";
 $sqlold = "select * from Requests where Name='Node1' and addtime(Starttime,sec_to_time(reqtime))<now();";
 $result = mysqli_query($conn, $sqlold);
 $i=1;
 echo "<table border='1'>";
 echo "<tr><th>ID</th><th>Start Time</th><th>req CPU</th><th>req MEM</th><th>req Time</th></tr>";
 while($row =mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo "<tr><td>";
	echo "".$i;	
	echo "</td><td>";
	echo $row['Starttime'];
	echo "</td><td>";
	echo $row['reqCPU'];
	echo "</td><td>";
	echo $row['reqMEM'];
	echo "</td><td>";
	echo $row['reqTime'];
	echo "</td></tr>";
 $i+=1;
}
echo "</table></center>";	
mysqli_close($conn);
?>
</body>
</html>
