<title> Confirm Pages </title>

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

$conn = new mysqli($servername,$username,$password,$dbname);
$sql = "SELECT username,email,identity FROM userdata";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()){
    if ($_COOKIE["login"] == $row['username']){
        $username = $row['username'];
        $email = $row['email'];
        $identity = $row['identity'];
        //print_r($_COOKIE["login"]);
        if($identity != "teacher"){
          header("Location: ../signin.php");
        }
    }
}
$conn->close();
?>
<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$dbname = "myDB";

$asgn = $_POST['number'];
$language = $_POST["language"];
$file = $_POST["file"];
$time = $_POST["time"];

//print_r($asgn);
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
if ($result = $conn->query("SHOW TABLES LIKE '".$asgn."'")) {
    if($result->num_rows != 1) {
        $sql = "CREATE TABLE $asgn (sid VARCHAR(50),score VARCHAR(50),t INT(255),file_path VARCHAR(50),day timestamp,status VARCHAR(50))";
        $conn->query($sql);
    }
}

$asgn_requirement = $asgn."_requirement";
if ($result = $conn->query("SHOW TABLES LIKE '".$asgn_requirement."'")) {
    if($result->num_rows != 1) {
        $sql = "CREATE TABLE $asgn_requirement (language VARCHAR(50), filesize INT(255), timelimit INT(255) ,compile_name VARCHAR(9999))";
        $conn->query($sql);
    }
}

/////////////
//may have problem
setcookie("data",$asgn."_".$language."_".$file."_".$time."_".$_POST["compile"]."_".$_POST["customized"],time() + (3600*1),"/");
$asgn_number = $asgn[3];

echo "<p style = \"text-align:center\">";
echo "For Assignment $asgn_number, You have chosen";
echo "<br>";
echo "Language $language.";
echo "<br>";
echo "The file size limit is $file.";
echo "<br>";
echo "The time limit is $time.";
echo "<br>";
echo "<p>";
$conn ->close();
//print_r($_POST['testcase']);
?>

<form style = "text-align: center" method="post" name = "post" action = "./index.php" >
<input type="submit" name= "redo" value = "Redo">
</form>

<?php
echo "<form style = \"text-align: center\" action=\"submit.php\" method=\"post\" enctype=\"multipart/form-data\"><br><br>Approximate file:";
echo "<input type=\"file\" name=\"approximate_files[]\" multiple=\"multiple\"><br><br>Testcase:";
echo "<input type=\"file\" name=\"files[]\" multiple=\"multiple\"><br><input type = \"submit\" name = \"submit\" value = \"submit\"></form>";

?>
<p style = "text-align:center">
<a href = "./signout.php">Sign out</a>
</p>