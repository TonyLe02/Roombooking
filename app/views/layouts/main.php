<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Roombooking/public/css/styles.css">
    <title>Room Booking App</title>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-500 p-4">
        <ul class="flex space-x-4">
            <li><a href="/Roombooking/public/index.php" class="text-white">Home</a></li>
            <li><a href="/Roombooking/public/booking.php" class="text-white">Booking</a></li>
            <li><a href="/Roombooking/public/login.php" class="text-white">Login</a></li>
            <li><a href="/Roombooking/public/dashboard.php" class="text-white">Dashboard</a></li>
        </ul>
    </nav>
    <div class="container mx-auto p-4">
        <?php include($view); ?>
    </div>
    <script src="/Roombooking/public/js/app.js"></script>
</body>
</html>