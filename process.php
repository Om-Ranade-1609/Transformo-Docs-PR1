<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["pdfFile"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFilePath)) {
        echo "File uploaded successfully: " . $targetFilePath;
    } else {
        echo "Failed to upload file.";
    }
}
?>
