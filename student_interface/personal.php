<title>Personal Page</title>

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

        if($identity != "student"){
        	header("Location: ../signin.php");
        }

        echo "<p style = \"text-align: center\">";
        echo "Name:$username<br>E-mail:$email<br>Identity:$identity";
        echo "</p>";
    }
}

?>
<p>
All the submission<br><br>
<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$DBname = "myDB";
$conn = new mysqli($servername,$username,$password,$DBname);

$num = 1;
while($num < 6){
	//print_r($conn->query("SHOW TABLES LIKE '".$asgn."';"));
	echo "<table border=\"1\">
	<tr>
	<th>Student ID</th>
    	<th>Score</th>
    	<th>Submission number</th>
    	<th>Assignment $num</th>
	</tr>";
	$asgn = "asg".$num;
	//print_r($asgn);
	if($result1 = $conn->query("SHOW TABLES LIKE '".$asgn."';")){
		if ($result1 == 1){
			$sql = "SELECT sid,score,t FROM $asgn";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$sid = $row["sid"];
					$score = $row["score"];
					$t = $row["t"];
					if($_COOKIE["login"] == $sid)
		  				echo "<tr><td>$sid</td><td>$score</td><td> $t</td></tr>";
				}
			}
			$num = $num + 1;
		}
	}
}
?>
</table>
</p>
<p style = "text-align:center"><a href = "./index.php">Return to HomePage</a></p>