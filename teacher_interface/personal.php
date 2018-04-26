<title>Personal Page</title>
<head>
</head>
<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$DBname = "myDB";
$conn = new mysqli($servername,$username,$password,$DBname);
$sql = "SELECT username,email,identity FROM userdata";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()){
    if ($_COOKIE["login"] == $row['username']){
        $username = $row['username'];
        $email = $row['email'];
        $identity = $row['identity'];
        if($identity != "teacher"){
        	header("Location: ./tea_signup.php");
        }
        echo "<p style = \"text-align: center\">";
        echo "Name:$username<br>E-mail:$email<br>Identity:$identity";
        echo "</p>";
    }
}
$conn -> close();
?>
<p> Latest score<br><br>
<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$DBname = "myDB";
$conn = new mysqli($servername,$username,$password,$DBname);

$num = 1;
while(1){
	echo "<table border=\"1\">
  	<tr>
    	<th>Student ID</th>
    	<th>Score</th>
    	<th>Submission number</th>
    	<th>Assignment $num</th>
	</tr>";
	$asgn = "asg".$num;
	$asgn_update = $asgn."_update";
	//print_r($asgn);
	$sql = "SELECT sid,score,t FROM $asgn_update";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			$sid = $row["sid"];
			$score = $row["score"];
			$t = $row["t"];
  			echo "<tr><td>$sid</td><td>$score</td><td> $t</td></tr>";
		}
	}
	else{
		break;
	}
	$num = $num + 1;
}
?>
</table>
</p>
<p>
All the submission<br><br>
<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$DBname = "myDB";
$conn = new mysqli($servername,$username,$password,$DBname);

$num = 1;
while(1){
	echo "<table border=\"1\">
  	<tr>
    	<th>Student ID</th>
    	<th>Score</th>
    	<th>Submission number</th>
    	<th>Assignment $num</th>
	</tr>";
	$asgn = "asg".$num;
	$asgn_update = $asgn."_update";
	//print_r($asgn);
	$sql = "SELECT sid,score,t FROM $asgn";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			$sid = $row["sid"];
			$score = $row["score"];
			$t = $row["t"];
  			echo "<tr><td>$sid</td><td>$score</td><td> $t</td></tr>";
		}
	}
	else{
		break;
	}
	$num = $num + 1;
}
?>
</table>
</p>
<p style = "text-align:center">
<a href = "./index.php">Return to HomePage</a><br>
<a href = "./signout.php">Sign out</a>
</p>