<!DOCTYPE HTML> 
<?php
$cookie_name = "login";
$cookie_value = "fail";
setcookie($cookie_name, $cookie_value, time() + (3600 * 1), "/");
?>

<html>
<head>
<meta charset="utf-8">
<title>Sign in</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
$servername = "localhost";
$username = "root";
$password = "shanghai";
$DBname = "myDB";
$conn = new mysqli($servername,$username,$password,$DBname);

$sql = "SELECT username,password,identity FROM userdata";
$result = $conn->query($sql);

$usernameErr = $passwordErr = "";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["username"]))
    {
        $usernameErr = "Username is neccessary";
    }
    else
    {
        $username = test_input($_POST["username"]);
        //if ($result->num_rows > 0){
         //  while($row = $result->fetch_assoc()){
           //   if ($username == $row["username"] ){
             //    $usernameErr = "Username already occupied";
              //   break;
              //}
           //}
        //}
     }
    
    if (empty($_POST["password"]))
    {
      $passwordErr = "Password is neccessary";
    }
    else
    {
        $password = test_input($_POST["password"]);
    }

    if ($username != "" AND $password != ""){
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                //if username not found send the wrong message
                if ($row["username"] == $username){
                    //if password not correct send the wrong message
                    if ($row["password"] == $password){
                        //if it's a teacher's account, head to teacher's index.php
                        if ($row["identity"] == "teacher"){
			    setcookie('login', $username, time() + (3600 * 1), "/");
                            header("Location:./teacher_interface/index.php");
                        }
                        else
                        {//a student's account, head to student's index.php
			    setcookie('login', $username, time() + (3600 * 1), "/");
                            header("Location: ./student_interface/index.php");
                        }
                    }
                    else{
                        $nameorpasErr = "</br> The username or the password is wrong, please check again then enter again";
                    }
                }
                else{
                    $nameorpasErr = "</br>The username or the password is wrong, please check again then enter again";
                }
            }
        }
        else{
            echo "<p style = \"text-align: center\">No component</p>";
        }
   }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2 style = "text-align: center">Welcome to AGS</h2>
<p style = "text-align: center"><span class="error">* Neccessary</span></p>
<form style = "text-align: center" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Username:
   <br> 
   <input type="text" name="username" value="<?php echo $username;?>">
   <span class="error">* <?php echo $usernameErr;?></span>
   <br>
   <br>
   Password:
   <br>
   <input type="password" name="password" value="<?php echo $password;?>">
   <span class="error">* <?php echo $passwordErr;?></span>
   <br><br>
   <span class="error"><?php echo $nameorpasErr."</br>";?></span>
   <input type="submit" name="signin" value="Sign in"> 
</form>
<form style = "text-align:center" method= "post" action = "./signup.php">
<input type = "submit" name = "signup" value = "Sign up">
</form>

</body>
</html>
