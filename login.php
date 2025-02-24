<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //var_dump($_POST);  
    $Email = $_POST['email'];
    $password = $_POST['pswd'];

    // Prepare and execute the query to get the password from the database
    $stmt = $conn->prepare("SELECT passwor FROM form WHERE email = ?");
  $stmt->bind_param("s", $Email);
    $stmt->execute();
   $stmt->store_result();

    // Check if email exists in the database
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        
        if ($password === $db_password) {
            session_start();
            $_SESSION['email'] =  $Email;
            $_SESSION['passwor'] = true;

            echo "<script>alert('Login successful!')</script><br>";
            header("Location:main1.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password')</script>";  
            header("Location:index.php");
         } 
        }
         else {
        echo "<script>alert('Email not found')</script>";
        header("Location:index.php");
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
