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
?>
<?php
//print_r($_COOKIE["asgn"]);
$servername = "localhost";
$username = "root";
$password = "shanghai";
$dbname = "myDB";

$conn = new mysqli($servername,$username,$password,$dbname);

$asgn = "asg".$_COOKIE["asgn"];
setcookie("asgn",$asgn,time()+(3600*1),"/");

$sql = "SELECT sid,t FROM $asgn";
$result = $conn->query($sql);
$count = 0;
$t = 0;
$SID = $_COOKIE["login"];

$file_ary = reArrayFiles($_FILES['files']);

//if ($result1 = $conn->query("SHOW TABLES LIKE 'waitlist'")) {
  //  if($result1->num_rows != 1) {
//        $a = 'waitlist';
//        $sql = "CREATE TABLE $a (sid VARCHAR(50),t INT(255),asgn VARCHAR(50), day timestamp, status INT(255))";
//        $conn->query($sql);
//    }
//}

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($SID == $row["sid"]){
      if ($t < $row["t"])
        $t = $row["t"];
    }
  }
  $t = $t + 1;
  $target_f = $_COOKIE["login"]."_".$t;
  $target_f = $target_f."_".$asgn;
  $sql = "INSERT INTO $asgn (sid,score,t,file_path,day,status) VALUES ('$SID','','$t','$target_f',NOW(),'0')";
  //$sql1 = "INSERT INTO waitlist (sid,t,asgn, day,status) VALUES ('$SID','$t','$asgn',NOW(),'0')";
  $conn->query($sql);
  //$conn->query($sql1);
}
else{
  $target_f = $_COOKIE["login"]."_1";
  $target_f = $target_f."_".$asgn; 
  $sql = "INSERT INTO $asgn (sid,score,t,file_path,day,status) VALUES ('$SID','','1','$target_f',NOW(),'0')";
  //$sql1 = "INSERT INTO waitlist (sid,t,asgn,day,status) VALUES ('$SID','1','$asgn',NOW(),'0')";
  $conn->query($sql);   
  //$conn->query($sql1);
}
$conn->close();
mkdir("/var/www/html/Project/Auto_grading/student_set/".$target_f);
foreach ($file_ary as $file) {
    $target = "/var/www/html/Project/Auto_grading/student_set/".$target_f."/";
    $target = $target . basename($file['name']);
	if(move_uploaded_file($file['tmp_name'], $target))
	{ 
  	 //Tells you if it is all ok
   	echo "<p style = \"text-align: center\">The file ". basename( $file['name']). " has been uploaded</p>"; 
	} 
	else { 
   	//Gives an error if it is not ok
   	$error = error_get_last();
   	echo $error['message'];
	}
}


function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

?>

<form style = "text-align: center" action = "post.php" method = "POST">
<input type = "submit" value = "Check score" name = "check_score">
</form>

<p style = "text-align:center"><a href = "./index.php">Return to HomePage </a></p>
<p style = "text-align:center"><a href = "./signout.php">Sign out </a></p>