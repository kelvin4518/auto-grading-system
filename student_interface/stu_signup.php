<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Sign up</title>
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
$sql = "SELECT username FROM userdata";
$result = $conn->query($sql);

$usernameErr = $password1Err = $password2Err = $emailErr =  "";
$username = " ";
$password1 = $password2 = "";
$email = " ";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["username"]))
    {
        $usernameErr = "Username is neccessary";
    }
    else
    {
        $username = test_input($_POST["username"]);
        if ($result->num_rows > 0){
           while($row = $result->fetch_assoc()){
              if ($username == $row["username"] ){
                 $usernameErr = "Username already occupied";
                 break;
              }
           }
        }
     }

    if (empty($_POST["password1"]))
    {
        $password1Err = "Password is neccessary";
    }
    else
    {
        $password1 = test_input($_POST["password1"]);
        
    }
    if (empty($_POST["password2"]))
    {
        $password2Err = "Please repeat the password";
    }
    else
    {
        $password2 = test_input($_POST["password2"]);
        if ($password1 != $password2){
            $password2Err = "Reinput password incorrect!";
        }
    }
    if (!empty($_POST["email"])){
        $email = test_input($_POST["email"]);
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){
            $emailErr = "Inlegal email address";
        }
    }

    if ($usernameErr == "" AND $password1Err == "" AND $password2Err == "" AND $emailErr == ""){
        $sql = "INSERT INTO userdata (username,password, email,identity) VALUES ('$username','$password1','$email','student')";
        header("Location: ./index.php");    
    }
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
}
    $conn->close();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<form style = "text-align: center" method="post" name = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  User name: 
  </br>
  <input type="text" name="username" value="<?php echo $username;?>">
  <span class="error"><?php echo "* </br>".$usernameErr;?></span>
  </br>
  </br>
  Password:
  </br>
  <input type="password" name="password1" value="<?php echo $password1;?>">
  <span class="error"><?php echo "* </br>".$password1Err;?></span>
  </br>
  </br>
  Repeat the Password:
  </br>
  <input type="password" name="password2" value="<?php echo $password2;?>">
  <span class="error"><?php echo "* </br>".$password2Err;?></span>
  </br>
  </br>
  Email address:
  <br>
  <input type="text" name="email" value="<?php echo $email;?>">
  </br>
  <span class="error"><?php echo $emailErr;?></span>
  </br>
  </br>
  <input type="submit" name="signup" value="Sign up as student"> 
</form>

</body>
</html>

<form style = "text-align:center" method= "post" action = "./tea_signin.php">
<input type = "submit" name = "signin" value = "     To Sign in Page     ">
</form>
