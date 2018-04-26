<!DOCTYPE html>
<html>
<head>
<title>score page</title>
</head>
<body>

<?php
	if (($_COOKIE["login"] == "fail") OR !isset($_COOKIE["login"])){
			//echo "Here";
			header("Location: ../signin.php");
		}
// Create connection
$servername = "localhost";
$username = "root";
$password = "shanghai";
$dbname = "myDB";

$conn1 = new mysqli($servername,$username,$password,$dbname);
$sql = "SELECT username,identity FROM userdata";
$result = $conn1->query($sql);

while ($row = $result->fetch_assoc()){
	if ($_COOKIE["login"] == $row['username']){
		$username = $row['username'];
		$identity = $row['identity'];
		if($identity != "student"){
		  header("Location: ../signin.php");
		}
	}
}
$conn1->close();
?>

<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$dbname = "myDB";

$conn = new mysqli($servername,$username,$password,$dbname);
$SID = $_COOKIE["login"];
$asgn = $_COOKIE["asgn"];

$sql = "SELECT sid,t FROM $asgn";
$result = $conn->query($sql);
$t = 0;

if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
		if ($SID == $row["sid"]){
			if ($t < $row["t"]){
				$t = $row["t"];
			}
		}
	}
	$sql = "SELECT sid,t,score FROM $asgn";
	$result1 = $conn->query($sql);
	while($row1 = $result1->fetch_assoc()) {
		if ($SID == $row1["sid"] AND $t == $row1["t"]){
			echo "<p style = \"text-align:center\">SID:".$SID."<br>Score:".$row1["score"]."<br>Base on the Submission ".$t."</p>";
		}
	}
}
else{
	echo "Wrong message from MySQL, Please contact me.";
}
$conn->close();
$target = $SID."_".$t."_".$asgn."/";
setcookie("file", $target, time() + (3600 * 1), "/");
echo '<p style = "text-align: center"><a href = "/Project/student_interface/download.php" >Download</a></p>';

?>

<p style = "text-align:center"><a href = "./index.php">Return to HomePage </a></p>
<p style = "text-align:center"><a href = "./signout.php">Sign out </a></p>
</body>
</html>
