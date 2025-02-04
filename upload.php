<?php
// Database configuration
$host = 'localhost:3307';
$dbname = 'docease';
$username = 'root';
$password = '';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $uploadDir = 'uploads/';
    
    // Ensure upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileName = basename($file['name']);
    $filePath = $uploadDir . $fileName;
    
    // Move the uploaded file to the server
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Insert file information into the database
        $stmt = $conn->prepare("INSERT INTO files (filename, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $fileName, $filePath);
        $stmt->execute();
        
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded.";
}

// Close connection
$conn->close();
?>
