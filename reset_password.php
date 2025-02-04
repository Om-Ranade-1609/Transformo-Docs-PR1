<?php
require 'db_connection.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token is valid
    $stmt = $conn->prepare("SELECT * FROM recovery_pass WHERE token = ? AND expiration > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, display password reset form
        echo '<form action="reset_password.php" method="POST">
                <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <button type="submit">Reset Password</button>
              </form>';
    } else {
        echo "Invalid or expired token.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'], $_POST['new_password'])) {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verify the token again
    $stmt = $conn->prepare("SELECT email FROM recovery_pass WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $email = $row['email'];

        // Update password in users table
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        // Delete token after use
        $stmt = $conn->prepare("DELETE FROM recovery_pass WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid token.";
    }
}
?>
