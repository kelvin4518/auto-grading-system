<?php
if (($_COOKIE["login"] == "fail") OR !isset($_COOKIE["login"]))
{
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

$src = "/var/www/html/Project/Auto_grading/student_set/".$_COOKIE["file"];
//print_r($src);
$compile_name = scandir($src);
unset($compile_name[0],$compile_name[1]);
foreach($compile_name as $file){

	$filepath = "/var/www/html/Project/Auto_grading/student_set/".$_COOKIE["file"]."/".$file;

	if(file_exists($filepath)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepath));
		flush(); // Flush system output buffer
		readfile($filepath);
		exit;
	}
}

?>