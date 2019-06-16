<html>
<head>
 <title>MyProxy</title>
</head>
<body>

<?php
// redirecting
$s="http://".LoadBalancer_GetIP();
header('Location: '.$s);

function LoadBalancer_GetIP() {
	$servers=array("127.0.0.1","127.0.0.2","127.0.0.3","127.0.0.4");  //ip addresses of web servers or nodes
	$reqCPU=2;    // to be passed from request
	$reqMEM=2;    // to be passed from request
	$reqTime=120; // to be passed from request
	$n=0;
	$n=getDB($reqCPU, $reqMEM, $reqTime);   // access DB to select node
	if ($n!="err")
	  return $servers[$n-1];     // passes the ip address of selected node
	else
	  echo "incompatible info"."<br>";
  } 

function getDB($rCPU, $rMEM,$rtime) {
  $servername = "localhost";
  $username = "root";
  $password = "redhat"; 
  $dbname = "CernDB";
  
 // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
 // Check connection
  if (!$conn) {
     die("Connection failed: " . mysqli_connect_error()); }

//update table Nodes with the Availabe Cpu & Available Memory

  $sqlUpdate="update Nodes set avcpu=ncpu-(select ifnull(sum(reqcpu),0) from Requests where Requests.name=Nodes.Name and addtime(Starttime,sec_to_time(reqtime))>now()), avMEM=NMEM-(select ifnull(sum(reqmem),0) from Requests where Requests.name=Nodes.Name and addtime(Starttime,sec_to_time(reqtime))>now());";
  $resT = mysqli_query($conn, $sqlUpdate);

//select appropriate node for new process

  $sqlget = "select * from Nodes where avCPU>".$rCPU." and avMEM>".$rMEM." order by avCPU+avMEM desc limit 1;";
  $result = mysqli_query($conn, $sqlget);
  $row =mysqli_fetch_array($result, MYSQLI_ASSOC);
  $aName=$row['Name'];
  $aID=$row['ID'];

// insert the new process into table 'Requests'

  $sqlinsert ="insert into Requests (Name,Starttime,reqCPU,reqMEM,reqTIME) values("."'".$aName."'".", NOW(), ".$rCPU.",".$rMEM.",".$rtime.");";
  if ($conn->query($sqlinsert) === TRUE) {
	echo "";  }
  else {
	echo "sql1 failed<br>"; } 

// update table Nodes again

 $resT = mysqli_query($conn, $sqlUpdate);
return $aID;
mysqli_close($conn);
} 
?>

</body>
</html>
