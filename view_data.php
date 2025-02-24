<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_home";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$device_filter = '';
$date_filter = '';
$search_filter = '';
$device_status_filter = ''; // New filter to show active or deleted devices

// Handle device status filter (Active or Deleted)
if (isset($_GET['device_status']) && $_GET['device_status'] == 'deleted') {
    $device_status_filter = "status = 'DELETED'";
} else {
    $device_status_filter = "status != 'DELETED'"; // Default filter for active devices
}

// Check if the user has selected a device filter
if (isset($_GET['device']) && $_GET['device'] == 'kitchen') {
    $device_filter = "device_name = 'Kitchen Light'";
} elseif (isset($_GET['device']) && $_GET['device'] == 'living_room') {
    $device_filter = "device_name = 'Living Room Light'";
}

// Check if the user has selected a date filter
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date_filter = "DATE(timestamp) = '" . $_GET['date'] . "'";
}

// Handle search functionality (search by device name)
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_filter = "device_name LIKE '%" . $_GET['search'] . "%'";
}

// Combine all filters in SQL query
$sql = "SELECT device_name, status, timestamp FROM device_status";

// Apply the filters (combine them using AND)
$filters = [];
if ($device_filter) {
    $filters[] = $device_filter;
}
if ($date_filter) {
    $filters[] = $date_filter;
}
if ($search_filter) {
    $filters[] = $search_filter;
}
if ($device_status_filter) {
    $filters[] = $device_status_filter;
}

// If there are any filters, add them to the SQL query
if (count($filters) > 0) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

// Add sorting
$sql .= " ORDER BY timestamp DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - IoT Smart Home</title>
    <link rel="stylesheet" href="Smart_Home.css?v=1">
    <link rel="icon" href="images/logo.svg" type="image/icon type">
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
    <style>
        :root {
            --accent-color: #2e4156;
            --background-color: #dbe3e7; /* Updated background color */
            --color: #aab7b7;
            --blue-color: #1a2d42d8;
            --boxback-color: hsl(213, 63%, 18%);
            --button-hover-color: #4d6f8b;
            --button-active-color: #3a5f7c;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --primary-font: 'Arial', sans-serif;
            --secondary-font: 'Roboto', sans-serif;
        }

        body {
            background-color: var(--background-color);
            font-family: var(--primary-font);
            color: var(--color);
            padding: 20px;
            width:95%;
        }

        .header {
            background-color: var(--accent-color);
            padding: 10px 0;
            text-align: center;
            font-size: 24px;
            color: white;
        }

        /* Back to Dashboard Button */
        .back-btn {
            position: absolute;
            top: 30px;
            left: 30px;
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--accent-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: var(--button-hover-color);
        }

        .back-btn:active {
            background-color: var(--button-active-color);
        }

        .filters {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .filters input, .filters select {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
            border: 1px solid var(--color);
            border-radius: 4px;
        }

        .filters select {
            background-color: var(--background-color);
            color: var(--accent-color);
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: var(--accent-color);
            color: white;
            font-weight: bold;
        }

        table td {
            background-color: var(--blue-color);
            color: white;
        }

        table td:nth-child(odd) {
            background-color: var(--boxback-color);
        }

        .no-history {
            font-size: 18px;
            text-align: center;
            color: var(--color);
            margin-top: 50px;
        }

        .calendar-wrapper {
            display: inline-block;
        }

        input[type="date"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid var(--color);
        }
    </style>
</head>
<body>
<a href="control.php" class="back-btn">Back to Dashboard</a>

<div class="header">
    IoT Smart Home - Device History
</div>
<div class="filters">
    <!-- Search by device -->
    <form method="GET" action="view_data.php">
        <input type="text" name="search" placeholder="Search by device" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
        <input type="submit" value="Search" />
    </form>

    <!-- Calendar for date selection -->
    <form method="GET" action="view_data.php">
        <div class="calendar-wrapper">
            <input type="date" name="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>" />
            <input type="submit" value="Filter by Date" />
        </div>
    </form>

    <!-- Filter by active or deleted devices -->
    <form method="GET" action="view_data.php">
        <select name="device_status">
            <option value="active" <?php echo !isset($_GET['device_status']) || $_GET['device_status'] == 'active' ? 'selected' : ''; ?>>Active Devices</option>
            <option value="deleted" <?php echo isset($_GET['device_status']) && $_GET['device_status'] == 'deleted' ? 'selected' : ''; ?>>Deleted Devices</option>
        </select>
        <input type="submit" value="Filter" />
    </form>
</div>

<!-- Active Devices Section -->
<?php if ($result->num_rows > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>Device Name</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Output data of each row for the selected devices (active or deleted)
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["device_name"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>" . $row["timestamp"] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="no-history">No history found for the selected filters.</p>
<?php } ?>

<?php
$conn->close();
?>

</body>
</html>
