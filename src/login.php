<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h1 class="text-3xl font-bold text-gray-500">Login</h1>
        <form action="login.php" method="POST" class="mt-4">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Login</button>
        </form>

        <?php
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require '../config.php'; // Database connection

            // Set UTF-8 encoding
            $conn->set_charset("utf8");

            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password, $role);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Start session and set session variables
                    session_start();
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;

                    // Redirect based on role
                    if ($role == 'admin') {
                        header("Location: /Roombooking/src/admin.php");
                    } else {
                        header("Location: /Roombooking/src/search.php");
                    }
                    exit();
                } else {
                    echo "<p class='text-red-500 text-center mt-4'>Invalid password.</p>";
                }
            } else {
                echo "<p class='text-red-500 text-center mt-4'>No user found with that username.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>

</html>