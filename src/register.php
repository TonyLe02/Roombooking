<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="/Roombooking/dist/styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <div class="text-gray-700 font-bold">Roombooking</div>
            <ul class="flex justify-center space-x-4">
                <li><a href="/Roombooking/src/index.php" class="text-blue-500 hover:underline">Home</a></li>
                <li><a href="/Roombooking/src/register.php" class="text-blue-500 hover:underline">Register</a></li>
                <li><a href="/Roombooking/src/login.php" class="text-blue-500 hover:underline">Login</a></li>
                <li><a href="/Roombooking/src/search.php" class="text-blue-500 hover:underline">Search Rooms</a></li>
                <li><a href="/Roombooking/src/admin.php" class="text-blue-500 hover:underline">Admin Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto max-w-md p-4">
        <h1 class="text-3xl font-bold text-gray-500">Register</h1>
        <form action="register.php" method="POST" class="mt-4">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full" required>
                    <option value="guest">Guest</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Register</button>
        </form>

        <?php
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require '../config.php'; // Database connection

            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = $_POST['role'];

            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $role);

            if ($stmt->execute()) {
                echo "<p class='text-green-500 text-center mt-4'>Registration successful!</p>";
            } else {
                echo "<p class='text-red-500 text-center mt-4'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>

</html>