<?php
include "config.php";

// Validate the email address entered by the user.
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email address.';
    exit;
}

try {
    // Generate a new password reset token.
    $password_reset_token = bin2hex(random_bytes(16));

    // Escape the password reset token before sending it in the email.
    $password_reset_token = htmlspecialchars($password_reset_token);

    // Save the password reset token to the database.
    $sql = 'UPDATE users SET password_reset_token = :password_reset_token, password_reset_expires = NOW() + INTERVAL 1 DAY WHERE email = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':password_reset_token', $password_reset_token);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        // Send an email to the user with the password reset link.
        $to = $email;
        $subject = 'Password Reset Link';
        $message = "
Hi,

You have requested to reset your password.

To reset your password, click on the following link:

http://localhost/reset-password.php?token=$password_reset_token

This link will expire after 24 hours.

If you did not request to reset your password, please ignore this email.

Thanks,
The Administrator
";
        if (mail($to, $subject, $message)) {
            echo 'success';
        } else {
            echo 'Failed to send the email. Please try again later.';
        }
    } else {
        echo 'Email not found in the database.';
    }
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
?>
