
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db="register";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST["submit"])){
    $firstname=$_POST['Firstname'];
    $email=$_POST['Email'];
    $password=$_POST['Password'];
    $repeatpassword=$_POST['Repeat-Password'];
    $sql="INSERT INTO form (fname, email, pass, repeatpass) VALUES (' {$firstname}', '{$email}', ' {$password}', ' {$repeatpassword}')";
   if ( mysqli_query ($conn ,$sql) )
    {
        echo "new record created";

    }
    else{
        echo "error" . $sql . "<br>" .$conn->error;
    }
}
$conn->close();
?>