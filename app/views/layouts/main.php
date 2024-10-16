<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Roombooking/public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <title>Room Booking App</title>
</head>

<body class="bg-gray-100">
    <?php
    // Get the current script's filename
    $current_page = basename($_SERVER['SCRIPT_FILENAME']);

    // Conditionally include the navbar
    if ($current_page !== 'process_booking.php' && $current_page !== 'confirmation.php') {
        include __DIR__ . '/../components/navbar.php';
    }
    ?> <div class="container mx-auto p-4">
        <?php include($view); ?>
    </div>
    <script src="/Roombooking/public/js/app.js"></script>
</body>
<?php include __DIR__ . '/../components/footer.php'; ?>

</html>