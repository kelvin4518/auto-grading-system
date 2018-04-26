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

$conn = new mysqli($servername,$username,$password,$dbname);
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
    }
}
$conn->close();
setcookie('asgn',$_GET['asgn'],time() + (3600*1),"/");
?>


<form style = "text-align: center" action="upload_file.php" method="post" enctype="multipart/form-data">
	<br>
	<br>
	<br>
	File:
	<input type="file" name="files[]" multiple="multiple"><br>
	<input type = "submit" name = "submit" value = "submit">
</form>

<p style = "text-align:center"><a href = "./index.php">Return to HomePage </a></p>
<p style = "text-align:center"><a href = "./signout.php">Sign out </a></p>

</body>
</html>