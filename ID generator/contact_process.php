<?php
require_once("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['contactName'] ?? '');
    $email = trim($_POST['contactEmail'] ?? '');
    $phone = trim($_POST['contactPhone'] ?? '');
    $subject = trim($_POST['contactSubject'] ?? '');
    $message = trim($_POST['contactMessage'] ?? '');

    // Validation: at least one of email or phone must be filled
    if (!$name || !$subject || !$message) {
        $error = "Name, subject, and message are required.";
    } elseif (empty($email) && empty($phone)) {
        $error = "Please provide at least an email or a phone number.";
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        if ($stmt->execute()) {
            $success = "Thank you for contacting us! We have received your message.";
        } else {
            $error = "Failed to send your message. Please try again.";
        }
        $stmt->close();
    }
}
if ($success) {
    header("Location: contact.html?status=success");
    exit();
} else {
    header("Location: contact.html?status=error");
    exit();
}
