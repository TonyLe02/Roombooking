<?php
require 'vendor/autoload.php';

use SendGrid\Mail\Mail;
use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendConfirmationEmail($toEmail, $booking)
{
    $email = new Mail();
    $email->setFrom("tonynl@uia.no", "Roombooking");
    $email->setSubject("Booking Confirmation");
    $email->addTo($toEmail, "Valued Customer");

    $plainTextContent = "Thank you for your booking. Here are your booking details:\n\n" .
        "Room Number: " . $booking['room_number'] . "\n" .
        "Room Type: " . $booking['room_type'] . "\n" .
        "Check-in Date: " . $booking['check_in'] . "\n" .
        "Check-out Date: " . $booking['check_out'] . "\n" .
        "Number of Adults: " . $booking['adults'] . "\n" .
        "Number of Children: " . $booking['children'];

    $bookingDetailsLink = "http://localhost/Roombooking/public/confirmation.php?booking_id=" . urlencode($booking['id']);

    $htmlContent = "
    <head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333333; margin: 0; padding: 0; }
        .header { background-color: #4CAF50; padding: 20px; text-align: center; color: white; }
        .content { background-color: white; padding: 20px; margin: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .content p { margin: 10px 0; }
        .button { display: inline-block; padding: 10px 20px; margin: 20px 0; background-color: #000000; color: white; text-decoration: none; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .button:hover { background-color: #333333; }
        a { color: white; text-decoration: none; }
        a:hover { color: white; }
    </style>
    </head>
    <body>
        <div class='header'>
            <h1>Roombooking</h1>
        </div>
        <div class='content'>
            <p><strong>Thank you for your booking. Here are your booking details:</strong></p>
            <p><strong>Room Number:</strong> " . htmlspecialchars($booking['room_number']) . "</p>
            <p><strong>Room Type:</strong> " . htmlspecialchars($booking['room_type']) . "</p>
            <p><strong>Check-in Date:</strong> " . htmlspecialchars($booking['check_in']) . "</p>
            <p><strong>Check-out Date:</strong> " . htmlspecialchars($booking['check_out']) . "</p>
            <p><strong>Number of Adults:</strong> " . htmlspecialchars($booking['adults']) . "</p>
            <p><strong>Number of Children:</strong> " . htmlspecialchars($booking['children']) . "</p>
            <a href='" . $bookingDetailsLink . "' class='button'>View Booking Details</a>
        </div>
    </body>
    </html>";

    $email->addContent("text/plain", $plainTextContent);
    $email->addContent("text/html", $htmlContent);
    $email->setReplyTo("lee.tony2002@gmail.com", "Tony Nguyen Le");

    $sendgrid = new \SendGrid($_ENV['SENDGRID_API_KEY']);
    try {
        $response = $sendgrid->send($email);
        return $response->statusCode() === 202;
    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
        return false;
    }
}
