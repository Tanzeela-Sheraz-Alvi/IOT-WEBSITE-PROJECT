<?php       
// PHP code for handling the device data and database interactions
date_default_timezone_set('Asia/Karachi');  // Set this to your local time zone

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_home";  // Use the correct database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the device status change (ON or OFF)
if (isset($_POST['device_name']) && isset($_POST['device_status'])) {
    $device_name = $_POST['device_name'];
    $status = $_POST['device_status'];
    $timestamp = date('Y-m-d H:i:s');  // Current timestamp in the correct time zone

    // Insert the device status into the database
    $sql = "INSERT INTO device_status (device_name, status, timestamp) VALUES ('$device_name', '$status', '$timestamp')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $conn->error;
    }
}

// Add a new device to the database (if the form is submitted)
if (isset($_POST['new_device_name'])) {
    $new_device_name = $_POST['new_device_name'];

    // Insert the new device into the device_status table with initial status "OFF"
    $sql = "INSERT INTO device_status (device_name, status, timestamp) VALUES ('$new_device_name', 'OFF', NOW())";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $conn->error;
    }
}

// Handle deleting the device box (but not the data from the database)
if (isset($_POST['delete_device_name'])) {
    $device_name_to_delete = $_POST['delete_device_name'];

    // Update or mark the device as deleted (instead of actually deleting it from the database)
    $sql = "UPDATE device_status SET status = 'DELETED' WHERE device_name = '$device_name_to_delete'";
    if ($conn->query($sql) === TRUE) {
        // Return a success message to the client (in JSON format)
        echo json_encode(['status' => 'success', 'device_name' => $device_name_to_delete]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete device']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IoT-based Smart Home</title>
    <link rel="stylesheet" href="Smart_Home.css?v=1.1">
    <link rel="icon" href="images/logo.svg" type="image/icon type">
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
</head>
<body>

<!-- Header section -->
<div class="header">
    <nav>
        <ul>
            <a href="main1.php" class="back-btn">Back</a>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="view_data.php">View History</a></li>
            <li><a href="index.php">Signout</a></li>
            <span class="plus-icon" onclick="toggleAddDeviceBox()">+</span> <!-- Trigger to open form -->
        </ul>
    </nav>
</div>

<!-- The overlay to darken the background when the form is visible -->
<div id="overlay" class="overlay" onclick="toggleAddDeviceBox()"></div>

<!-- The form box to add a new device -->
<div id="addDeviceBox" class="add-device-box">
    <h3>Add New Device</h3>
    <form method="POST" action="">
        <h2>Please specify the device with (light,AC) like room light, room AC</h2>
        <input type="text" name="new_device_name" placeholder="Enter device name" required>
        <button type="submit">Add Device</button>
    </form>
</div>

<div class="dashboard">
    <div class="mainrow">
        <div class="box1"style="background-image: url('images/sonset.png'); background-size: cover;">
            <h2>Today</h2>
            <div class="datetime">
                <p style="margin-right: 30px;" id="date"></p>
                <p id="time"></p>
            </div>
            <span class="tempsymbol"><i class="fas fa-clouds cloud"></i><span class="cloudy"> Humidity</span></span>
            <div class="temp">
                <div class="Temperature">
                    <strong id="temperature">Loading...°C</strong>
                    <p>Temperature</p>
                </div>
                <div class="Humidity" >
                    <strong id="humidity">Loading...</strong>
                    <p>Humidity</p>
                </div>
            </div>
        </div>
    </div>

    <div class="devices" id="device-boxes">
        <!-- Display existing devices from the device_status table -->
        <?php
        // Assuming $conn is the established database connection
        $result = $conn->query("SELECT DISTINCT device_name FROM device_status WHERE status != 'DELETED'");
        while ($row = $result->fetch_assoc()) {
            $device_name = $row['device_name'];
            echo '<div class="box" data-name="' . $device_name . '">';
            echo '<p>' . $device_name . '</p>';
            echo '<form method="POST" action="">';
            echo '<input type="hidden" name="device_name" value="' . $device_name . '">';
            echo '<button type="submit" name="device_status" value="ON">Turn ON</button>';
            echo '<button type="submit" name="device_status" value="OFF">Turn OFF</button><br>';
            echo '<a href="view_data.php?device=' . $device_name . '">View History</a>';
            echo '</form>';

            echo '<div class="three-dots" onclick="toggleDropdown(\'' . $device_name . '\')">...</div>';
            echo '<div id="dropdown-' . $device_name . '" class="dropdown-content">';
            echo '<button type="button" value="delete_box" onclick="selectOption(event, \'' . $device_name . '\')">Delete Box</button>';

            // Only show the "Adjust" option for light or ac devices
            if (stripos($device_name, 'light') !== false || stripos($device_name, 'ac') !== false) {
                echo '<button type="button" value="adjust_box" onclick="selectOption(event, \'' . $device_name . '\')">Adjust</button>';
            }

            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- Modal for Light/AC Adjustment -->
<div id="adjust-modal" class="modal">
    <div class="modal-content">
        <h3>Adjust Device Settings</h3>
        <div id="light-adjustments" style="display: none;">
            <label for="intensity">Light Intensity: </label>
            <input type="range" id="intensity" min="20" max="100" value="50" onchange="adjustLight()">
            <br><br>
            <label for="color">Select Color: </label>
            <input type="color" id="color" value="#ffffff" onchange="adjustLight()">
        </div>
        <div id="ac-adjustments" style="display: none;">
            <label for="temperature">AC Temperature: </label>
            <input type="number" id="temperature" min="16" max="30" value="22" onchange="adjustAC()">
            <br><br>
            <label for="mode">AC Mode: </label>
            <select id="mode" onchange="adjustAC()">
                <option value="cool">Cool</option>
                <option value="heat">Heat</option>
                <option value="fan">Fan</option>
            </select>
            <br><br>
            <label for="angle">AC Angle: </label>
            <input type="range" id="angle" min="0" max="180" value="90" onchange="adjustAC()">
            <br><br>
            <span id="angle-value">Angle: 90°</span>
        </div>
        <br><br>
        <button onclick="applySettings()">Apply</button>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<script>
// Toggle the form for adding new devices
function toggleAddDeviceBox() {
    var addDeviceBox = document.getElementById('addDeviceBox');
    var overlay = document.getElementById('overlay');
    
    addDeviceBox.style.display = addDeviceBox.style.display === 'block' ? 'none' : 'block';
    overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
}

// Real-time Date and Time
function updateDateTime() {
    var now = new Date();
    var date = now.toLocaleDateString(); // "MM/DD/YYYY"
    var time = now.toLocaleTimeString(); // "HH:MM:SS"

    document.getElementById('date').innerText = date;
    document.getElementById('time').innerText = time;
}

setInterval(updateDateTime, 1000); // Update every second

// Handle the dropdown options for each device
function toggleDropdown(deviceName) {
    var dropdown = document.getElementById('dropdown-' + deviceName);
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Close the dropdown if the user clicks outside of it
document.addEventListener('click', function(event) {
    var allDropdowns = document.querySelectorAll('.dropdown-content');
    
    allDropdowns.forEach(function(dropdown) {
        if (!dropdown.contains(event.target) && !event.target.classList.contains('three-dots')) {
            dropdown.style.display = 'none'; // Hide the dropdown if the click is outside
        }
    });
});

// Handle option selection from the dropdown
function selectOption(event, deviceName) {
    var option = event.target.value;

    // Close the dropdown after selecting an option
    var dropdown = document.getElementById('dropdown-' + deviceName);
    dropdown.style.display = 'none';  // Hide the dropdown when an option is selected

    if (option === 'delete_box') {
        // Handle device box deletion (not the database entry)
        deleteDeviceBox(deviceName);
    } else if (option === 'adjust_box') {
        // Open the adjustment modal
        openAdjustmentModal(deviceName);
    }
}

// Handle device deletion (marking as deleted in the database)
function deleteDeviceBox(deviceName) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Device box deleted');
            location.reload(); // Reload to reflect changes
        } else {
            alert('Error deleting device box');
        }
    };
    xhr.send('delete_device_name=' + deviceName);
}

// Open the adjustment modal
function openAdjustmentModal(deviceName) {
    var modal = document.getElementById('adjust-modal');
    var lightAdjustments = document.getElementById('light-adjustments');
    var acAdjustments = document.getElementById('ac-adjustments');
    
    modal.style.display = 'block';
    
    if (deviceName.toLowerCase().includes('light')) {
        lightAdjustments.style.display = 'block';
        acAdjustments.style.display = 'none';
    } else if (deviceName.toLowerCase().includes('ac')) {
        lightAdjustments.style.display = 'none';
        acAdjustments.style.display = 'block';
    }
}

// Close the adjustment modal
function closeModal() {
    document.getElementById('adjust-modal').style.display = 'none';
}

// Apply the settings (send to the server)
function applySettings() {
    // Get the adjustments
    var intensity = document.getElementById('intensity').value;
    var color = document.getElementById('color').value;
    var temperature = document.getElementById('temperature').value;
    var mode = document.getElementById('mode').value;
    var angle = document.getElementById('angle').value;
    
    // Use AJAX to send the settings to the server
    console.log({ intensity, color, temperature, mode, angle });
    
    // For now, just close the modal
    closeModal();
}
</script>
<script src='weather.js'></script>
</body>
</html>
