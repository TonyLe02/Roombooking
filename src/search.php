<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Search for Roombooking</title>
    <link href="/Roombooking/dist/styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow">
        <!-- Navigation Menu -->
        <nav class="container mx-auto p-4">
            <ul class="flex justify-center space-x-4">
                <li><a href="/Roombooking/login.php" class="text-blue-500 hover:underline">Login</a></li>
                <li><a href="/Roombooking/register.php" class="text-blue-500 hover:underline">Register</a></li>
                <li><a href="/Roombooking/search.php" class="text-blue-500 hover:underline">Search Rooms</a></li>
                <li><a href="/Roombooking/admin.php" class="text-blue-500 hover:underline">Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>
    <div class="container mx-auto max-w-4xl p-4">
        <h1 class="text-3xl font-bold text-green-500">Search the following room you are requesting</h1>
        <p class="mt-4">The following site is for finding rooms.</p>

<!-- Room Boxes -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
    <a href="/Roombooking/room1.php" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
        <h2 class="text-xl font-bold mb-2">Room 1</h2>
        <p class="text-gray-700">Description for Room 1</p>
    </a>
    <a href="/Roombooking/room2.php" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
        <h2 class="text-xl font-bold mb-2">Room 2</h2>
        <p class="text-gray-700">Description for Room 2</p>
    </a>
    <a href="/Roombooking/room3.php" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
        <h2 class="text-xl font-bold mb-2">Room 3</h2>
        <p class="text-gray-700">Description for Room 3</p>
    </a>
    <a href="/Roombooking/room4.php" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
        <h2 class="text-xl font-bold mb-2">Room 4</h2>
        <p class="text-gray-700">Description for Room 4</p>
    </a>
</div>
    </div>
</body>

</html>