<!DOCTYPE html>
<html>
<head>
<title>student page</title>
<form style = "text-align: right" method = "post" action = "./personal.php">
<input type = "image" src = "./person.jpg" width="60" height="60" value = <?php echo $_COOKIE["login"];?> name = "personal">
<?php echo "<span style=\" font-size:8pt; color:blue;\"><br>Personal infromation  </span>";?>
</form>
</head>
<body>
<?php
if (($_COOKIE["login"] == "fail") OR !isset($_COOKIE["login"])){
    //echo $_COOKIE["login"];
    header("Location: ../signin.php");
}
$servername = "localhost";
$username = "root";
$password = "shanghai";
$dbname = "myDB";

$conn1 = new mysqli($servername,$username,$password,$dbname);
   $sql = "SELECT username,email,identity FROM userdata";
  $result = $conn1->query($sql);

while ($row = $result->fetch_assoc()){
    if ($_COOKIE["login"] == $row['username']){
        $username = $row['username'];
        $email = $row['email'];
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

$conn = new mysqli($servername, $username,$password,$dbname);
$num = 1;

while(1){
	$asgn_requirement = "asg".$num."_requirement";
	$sql = "SELECT language,filesize,timelimit,compile_name FROM $asgn_requirement";
	//print_r($asgn);
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
    	echo "<p style = \"text-align:center\"><a href=\"./start.php?asgn=$num\">To Assignment $num uploading page</a></p>";
	} 
	else {
    	break;
	}
	$num = $num + 1;
}
?>

<p style = "text-align:center"><a href = "./signout.php">Sign out </a></p>

</body>
</html>
