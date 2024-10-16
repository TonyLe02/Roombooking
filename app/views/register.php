<?php
// Include the database connection script
include __DIR__ . '/../core/db_connect.php';

// Initialize error variable
$error = "";

// Check if the registration form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validate input
    if (empty($username) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Check if the username already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Username already exists. Please choose another.";
            } else {
                // Insert the new user
                $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $username, $hashedPassword, $role);
                $stmt->execute();

                // Redirect to login page after successful registration
                header('Location: /Roombooking/public/login.php');
                exit;
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!-- Register form or content goes here -->
<div class="container mx-auto max-w-md p-4">
    <h1 class="text-3xl font-bold text-gray-900">Register</h1>
    <form action="/Roombooking/public/register.php" method="POST" class="mt-4">
        <div class="mb-4">
            <label for="username" class="block text-sm font-bold text-gray-900">Username</label>
            <input type="text" name="username" id="username"
                class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200"
                required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-bold text-gray-900">Password</label>
            <input type="password" name="password" id="password"
                class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200"
                required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-sm font-bold text-gray-900">Role</label>
            <select name="role" id="role"
                class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200"
                required>
                <option value="" disabled selected>Select your role</option>
                <option value="guest">Guest</option>
                <option value="admin">Administrator</option>
            </select>
        </div>
        <button type="submit" class="w-full rounded-md bg-gray-900 px-4 py-2 text-white shadow-sm hover:bg-gray-700">Register</button>

        <?php if (isset($error)): ?>
            <div class="mt-4 text-red-500 text-sm">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="mt-4 text-sm">
            Already have an account? <a href="/Roombooking/public/login.php" class="text-blue-500 hover:underline">Login here</a>.
        </div>
    </form>
</div>