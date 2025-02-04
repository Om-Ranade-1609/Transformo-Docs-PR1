<?php
require 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\CODING\projects\Transmodoccs\Transformo-Docs-PR1\src\PHPMailer.php';

require 'C:\CODING\projects\Transmodoccs\Transformo-Docs-PR1\src\SMTP.php';
require 'C:\CODING\projects\Transmodoccs\Transformo-Docs-PR1\src\Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if email exists in the users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a token and expiration
        $token = bin2hex(random_bytes(32));
        $expiration = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store the token and expiration in the database
        $stmt = $conn->prepare("INSERT INTO recovery_pass (email, token, expiration) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expiration);
        $stmt->execute();

        // Send reset email using PHPMailer
        $resetLink = "reset_password.php?token=$token";
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'techdep205@gmail.com'; // Your Gmail address
            $mail->Password = 'bjlh xtoq qhep abwh';   // App-specific password
            $mail->SMTPSecure = 'tls';               // Secure connection type
            $mail->Port = 587;                       // Port for STARTTLS

            $mail->setFrom('no-reply@yourdomain.com', 'Your App Name');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click this link to reset your password: $resetLink";

            $mail->send();
            echo "Password reset email sent. Please check your inbox.";
        } catch (Exception $e) {
            echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email address not found.";
    }
}
?>
