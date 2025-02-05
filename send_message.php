<?php
require_once('ultramsg.class.php'); // Ensure this file is included
require_once('ultramsg-dictionary.php');

$ultramsg_token = "ip5czx0zzbqpma5d";
$instance_id = "instance106231";

$client = new UltraMsg\WhatsAppApi($ultramsg_token, $instance_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $recipient = "+265888015107@c.us"; // Correct format for Malawian WhatsApp number

    $fullMessage = "*$subject*\n$message"; // Formatting with bold subject

    try {
        $client->sendChatMessage($recipient, $fullMessage);
        header("Location: your_page.php?success=Message sent successfully");
    } catch (Exception $e) {
        header("Location: your_page.php?error=" . urlencode($e->getMessage()));
    }
    exit();
}
?>
