<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<head>  

<?php
   $cookie_name = "login";
   include ("sidebar.php");
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
   $sql = "SELECT username,identity FROM userdata";
  $result = $conn->query($sql);

while ($row = $result->fetch_assoc()){
    if ($_COOKIE["login"] == $row['username']){
        $username = $row['username'];
        $identity = $row['identity'];
        if($identity != "teacher"){
          header("Location: ./tea_signup.php");
        }
    }
}
$conn->close();
?>
</head>

<body>
<h1 style = "text-align: center">Auto Grading System</h1>

<form style = "text-align: center" method="post" name = "post" action = "./confirm.php">  
  Assignment Number:
  </br>
  <input type="text" name = "number" value="">
  <br>
  <br>
  Requred Language: 
  </br>
  <input type="text" name="language" value="">
  </br>
  </br>
  File size limit: 
  </br>
  <input type="text" name="file" value="">
  </br>
  </br>
  Time Limit: 
  </br>
  <input type="text" name="time" value="">
  </br>
  </br>
  Specify the file to compile:
  </br> 
  <textarea name="compile" rows="5" cols="40"></textarea>
  </br>
  </br>
  Customized package :
  </br> 
  <textarea name="customized" rows="5" cols="40"></textarea>
  </br>
  </br>
  <input type="submit" name="submit" value="Submit"> 
</form>


</body>
</html>
<p style = "text-align:center">
<a href = "./signout.php">Sign out</a>
</p>