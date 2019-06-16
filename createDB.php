<?php
$servername = "localhost";
$username = "root";
$password = "redhat";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// Create database
$sql = "CREATE DATABASE CernDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
    $dbname = "CernDB";
} else {
    echo "Error creating database: " . $conn->error;
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create table1
$sql = "CREATE TABLE Nodes (
ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Name VARCHAR(30) NOT NULL,
NCPU INT(6) UNSIGNED,
avCPU INT(6) UNSIGNED,
NMEM INT(6) UNSIGNED,
avMEM INT(6) UNSIGNED
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Nodes created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Inserting details of 4 nodes to table1
$sql1 = "INSERT INTO Nodes (Name, NCPU, avCPU, NMEM, avMEM) VALUES ('Node1', 10, 10, 10, 10)";
$sql2 = "INSERT INTO Nodes (Name, NCPU, avCPU, NMEM, avMEM) VALUES ('Node2', 20, 20, 20, 20)";
$sql3 = "INSERT INTO Nodes (Name, NCPU, avCPU, NMEM, avMEM) VALUES ('Node3', 30, 30, 30, 30)";
$sql4 = "INSERT INTO Nodes (Name, NCPU, avCPU, NMEM, avMEM) VALUES ('Node4', 40, 40, 40, 40)";
if (mysqli_query($conn, $sql1)) {
    if (mysqli_query($conn, $sql2)) {
    	if (mysqli_query($conn, $sql3)) {
   	    if (mysqli_query($conn, $sql4)) {
   	  	  echo "4 records created successfully"; }
	      else { echo "Error: " . $sql4 . "<br>" . mysqli_error($conn); } }
	    else { 	echo "Error: " . $sql3 . "<br>" . mysqli_error($conn); } }
    else {  echo "Error: " . $sql2 . "<br>" . mysqli_error($conn); } }
else {    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn); }
echo "<br>";

// Check connection
if (mysqli_connect_errno())
 { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

//print table1
$sqlget = "select * from Nodes;";
$result = mysqli_query($conn, $sqlget);
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>NCPU</th><th>avCPU</th><th>NMEM</th><th>avMEM</th></tr>";
while($row =mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo "<tr><td>";
	echo $row['ID'];	
	echo "</td><td>";
	echo $row['Name'];
	echo "</td><td>";
	echo $row['NCPU'];
	echo "</td><td>";
	echo $row['avCPU'];
	echo "</td><td>";
	echo $row['NMEM'];
	echo "</td><td>";
	echo $row['avMEM'];
	echo "</td></tr>";
}
echo "</table>";	
echo "<br>";

// sql to create table2
$sql = "CREATE TABLE Requests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
Name VARCHAR(30) NOT NULL,
Starttime TIMESTAMP,
reqCPU INT(6) UNSIGNED,
reqMEM INT(6) UNSIGNED,
reqTime INT(10)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Requests created successfully";}
else { echo "Error creating table: " . $conn->error; }

/*//Mock request
$sql = "INSERT INTO Requests (Name, Starttime, reqCPU, reqMEM, reqTime)
VALUES ('Trial', 0, 0, 0, 0)";
if (mysqli_query($conn, $sql)) {
    echo "New record21 created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}*/

mysqli_close($conn);
?>
