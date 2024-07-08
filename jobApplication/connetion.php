<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "job_applications";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO applications (first_name, last_name, email, job_role, address, city, pin_code, date, cv_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $first_name, $last_name, $email, $job_role, $address, $city, $pin_code, $date, $cv_file);

// Set parameters and execute
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$job_role = $_POST['job_role'];
$address = $_POST['Address'];
$city = $_POST['City'];
$pin_code = $_POST['pinCode'];
$date = $_POST['Date'];

// Handle file upload
if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['upload']['name']);
    
    // Move uploaded file to the server
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $upload_file)) {
        $cv_file = $upload_file;
    } else {
        $cv_file = NULL;
    }
} else {
    $cv_file = NULL;
}

$stmt->execute();

echo "New record created successfully";

$stmt->close();
$conn->close();
?>
