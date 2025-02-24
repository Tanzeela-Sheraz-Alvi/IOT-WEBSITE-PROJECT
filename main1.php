<?php
session_start(); // Start the session
if (!isset($_SESSION['email'])) { // Check if the user is logged in
    header("Location: login.php"); // If not logged in, redirect to the login page
    exit(); // Ensure that no further code is executed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOT BASED WEBSITE</title>
    <link rel="stylesheet" type="text/css" href="main1.css">
    <link rel="icon" href="images/logo.svg" type="image/icon type">
    
</head>
<body >
  
<div class="hero">
    
 <nav>
        <img src="img/logo1.png" class="cloud">
         <ul>
                  <li><a href="control.php">Control</a></li>
                  <li><a href="#about">About</a></li>
                  <li><a href="Contact.php">Contact</a></li>
                  <li><a href="index.php">signout</a></li>
                </ul>
    </nav>
     
   <div class="lamp container">
             
                   <img src="images/blackbackground.png" class="lamp">
                   <img src="images/finallight.png" class="light" id="light">
                   <!--<img src="background1.jpg" class="pic">-->
               </div>
                    
<div class="wrapper">
    <h1>  Welcome to Iotify!</h1>
    <p class="welcome">
     Explore, control, and experience seamless automation like never before. Welcome to the world of connected living!
     <br><button type="btn" onclick="togglebtn()" id="btn"><span></span></button>
       </p>
</div>
<div class="container">
    <!-- Introduction Section with Image on Left -->
    <section id="about">
        <img src="images/mob2.jpg" alt="Iotify Device" class="product-img">
        <div class="text-content">
            <h4 class="small-text">WHAT IS IOTIFY</h4>
            <h1 class="small1-text">Your Digital Smart Home Assistant</h1>
            <p class="description-text">
                Iotify is a state-of-the-art smart home assistant that brings
                convenience,automation, and security to your fingertips. With
                its advanced IoT capabilities,it connects various devices, 
                offering seamless control over lighting, temperature,security,
                and entertainment. Your home, your rules, all controlled effortlessly with Iotify.
            </p>
        </div>
    </section>
    
    <div class="features-section">
        <!-- Why Choose HomeSync Section -->
        <section class="why-choose">
            <h1>Why Choose Iotify ?</h1>
            <!-- Flex Container for Boxes and Image -->
            <div class="flex-container">
                <!-- Left Side Boxes -->
                <div class="left-side">
                    <div class="div1">
                        <label for="Universal Control">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M702-480 560-622l57-56 85 85 170-170 56 57-226 226Zm-342 0q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 260Zm0-340Z"/></svg>
                            </label>
                        <h3>Universal-Control</h3>
                        <p>Control all your smart devices from one central platform, making your life easier and more connected.</p>
                    </div>
                    <div class="div2">
                        <label for="Highly Secure">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-80q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm-80-240h160q17 0 28.5-11.5T600-360v-120q0-17-11.5-28.5T560-520v-40q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560v40q-17 0-28.5 11.5T360-480v120q0 17 11.5 28.5T400-320Zm40-200v-40q0-17 11.5-28.5T480-600q17 0 28.5 11.5T520-560v40h-80Z"/></svg>
                            </label>
                        <h3>Highly Secure</h3>
                        <p>Iotify offers top-notch encryption to protect your data and provide a safe environment for your smart devices.</p>
                    </div>
                </div>
                <!-- Centered iPhone Image -->
                <div class="centered-image">
                    <img src="images/mob1.jpg" alt="iPhone Display with IoT Devices" class="iphone-img">
                </div>
                <!-- Right Side Boxes -->
                <div class="right-side">
                    <div class="div3">
                        <label for="User-Friendly">
                        <svg xmlns="http://www.w3.org/2000/svg"height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-40q-33 0-56.5-23.5T160-120v-720q0-33 23.5-56.5T240-920h400q33 0 56.5 23.5T720-840v160h-80v-40H240v480h400v-40h80v160q0 33-23.5 56.5T640-40H240Zm358-280L428-490l56-56 114 114 226-226 56 56-282 282Z"/></svg>
                        </label>
                        <h3>User-Friendly</h3>
                        <p>Simple interface design ensures everyone can operate Iotify without any technical knowledge.</p>
                    </div>
                    <div class="div4">
                        <label for="Real-Time Monitoring">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-240q100 0 170-70t70-170q0-100-70-170t-170-70v240L310-310q35 33 78.5 51.5T480-240Zm0 160q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                            </label>
                        <h3>Real-Time Monitoring</h3>
                        <p>Monitor all your smart devices in real-time and make changes on the fly for maximum convenience.</p>
                    </div>
                
            </div>
        </section>
        
    </div>
    <script>
        var btn =document.getElementById("btn");
        var light =document.getElementById("light");
        function togglebtn() {
            btn.classList.toggle("active");
light.classList.toggle("on");
         }
         
</script>
</body>
</html>