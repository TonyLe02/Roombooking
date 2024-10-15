<!-- Register form or content goes here -->
<div class="container mx-auto max-w-md p-4">
        <h1 class="text-3xl font-bold text-gray-900">Register</h1>
        <form action="register.php" method="POST" class="mt-4">
            <div class="mb-4">
                <label for="username" class="block text-sm font-bold text-gray-900">Username</label>
                <input type="text" name="username" id="username" class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-bold text-gray-900">Password</label>
                <input type="password" name="password" id="password" class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-bold text-gray-900">Role</label>
                <select name="role" id="role" class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200" required>
                    <option value="guest">Guest</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <button type="submit" class="w-full rounded-md bg-gray-900 px-4 py-2 text-white shadow-sm">Register</button>
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