<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "issue_reporting"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
$imagePath = '';
if ($_FILES['image']['name']) {
    $targetDir = "uploads/"; // Make sure this directory exists and is writable
    $imagePath = $targetDir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO issues (image, description, location, priority, status, date_reported, assigned_to) VALUES (?, ?, ?, ?, 'Pending', ?, ?)");
$location = "Not Provided"; // You can change this if you want to collect location
$date_reported = date('Y-m-d');
$stmt->bind_param("ssssss", $imagePath, $_POST['description'], $location, $_POST['priority'], $date_reported, $_POST['assignedTo']);

if ($stmt->execute()) {
    // Fetch the last inserted ID and return the response
    $issueId = $stmt->insert_id;
    $response = [
        'success' => true,
        'issue' => [
            'id' => $issueId,
            'image' => $imagePath,
            'description' => $_POST['description'],
            'location' => $location,
            'priority' => $_POST['priority'],
            'status' => 'Pending',
            'date_reported' => $date_reported,
            'assigned_to' => $_POST['assignedTo']
        ]
    ];
} else {
    $response = ['success' => false, 'message' => 'Error: ' . $stmt->error];
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>
 