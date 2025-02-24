<!--database connected file-->

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
   $FN = $_POST['firstname'];
   $E = $_POST['email'];
   $P = $_POST['passwor'];
   $sql = "INSERT INTO form (firstname, email, passwor) VALUES ('$FN', '$E', '$P')";
   
   if ($conn->query($sql) === TRUE) {
   //  echo "<script>alert ('New record created successfully')</script>";
   } 
     else
     {
     echo "Error: " . $sql . "<br>" . $conn->error;
   }
   
   $conn->close();
   ?>

