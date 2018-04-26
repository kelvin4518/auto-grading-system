<?php
	$cookie_name = "login";
   if(!isset($_COOKIE[$cookie_name])) {
     header('Location: ../signin.php');
   }
   if ($_COOKIE['login'] == 'fail'){
     header('Location: ../signin.php');
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
        //print_r($_COOKIE["login"]);
        if($identity != "teacher"){
          header("Location: ./tea_signup.php");
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
$data = $_COOKIE["data"];
$data = explode("_",$data);

$conn = new mysqli($servername,$username,$password,$dbname);

$asgn_requirement = $data[0]."_requirement";
$sql = "INSERT INTO $asgn_requirement (language,filesize,timelimit,compile_name) VALUES ('$data[1]','$data[2]','$data[3]','$data[4]')";
$conn->query($sql);
$conn->close();

mkdir("/var/www/html/Project/Auto_grading/customized/$data[0]");
$customized_file = $data[5];
$fp = fopen("../Auto_grading/customized/$data[0]/customized.sh", 'w');
fwrite($fp, $customized_file);
fclose($fp);


$file_ary = reArrayFiles($_FILES['files']);

mkdir("/var/www/html/Project/Auto_grading/inputcases/$data[0]");
foreach ($file_ary as $file) {
    $target = "/var/www/html/Project/Auto_grading/inputcases/$data[0]/";
    //print_r($target);
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

$file_ary = reArrayFiles($_FILES['approximate_files']);

mkdir("/var/www/html/Project/Auto_grading/marking_scheme/$data[0]");
foreach ($file_ary as $file) {
    $target = "/var/www/html/Project/Auto_grading/marking_scheme/$data[0]/";
    //print_r($target);
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

<title>Success page</title>

<p style = "text-align: center">
	<br>
	done!
	<br>
<a href = "./index.php">Return to HomePage</a><br>
<a href = "./signout.php">Sign out</a>
</p>