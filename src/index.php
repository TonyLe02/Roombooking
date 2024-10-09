<?php
session_start(); // Start the session

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Check if logout is requested
if (isset($_POST['logout'])) {
    // Perform logout operations
    session_unset(); // Clear all session variables
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to index.php
    exit(); // Ensure no further code is executed
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Roombooking</title>
    <link href="/Roombooking/dist/styles.css" rel="stylesheet">
    <script>
        <!-- Mobile menu toggle 
        -->
        document.addEventListener('DOMContentLoaded',
        function
        ()
        {
        const
        mobileMenuButton
        =
        document.getElementById('mobile-menu-button');
        const
        mobileMenu
        =
        document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click',
        function
        ()
        {
        mobileMenu.classList.toggle('hidden');
        });
        });
    </script>
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button id="mobile-menu-button" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <!-- <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Roombooking">
                    </div> -->
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <a href="/Roombooking/src/index.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Home</a>
                            <?php if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'guest' && $_SESSION['role'] !== 'admin')) : ?>

                                <a href="/Roombooking/src/register.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
                                <a href="/Roombooking/src/login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
                            <?php endif; ?>
                            <a href="/Roombooking/src/search.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search Rooms</a>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>

                                <a href="/Roombooking/src/admin.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin Dashboard</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ($role === 'guest' || $role === 'admin'): ?>
                    <div class="absolute inset-y-0 right-0 flex space-x-4 items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <span class="mr-4 text-sm text-gray-300"><?php echo htmlspecialchars($username); ?></span>
                        <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button" class="relative flex rounded-full bg-gray-800 text-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <svg class="h-8 w-8 rounded-full" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div id="dropdown-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700">Settings</a>
                                <form action="index.php" method="POST">
                                    <button type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        <?php endif; ?>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden sm:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <a href="/Roombooking/src/index.php" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Home</a>
                <a href="/Roombooking/src/register.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
                <a href="/Roombooking/src/login.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Login</a>
                <a href="/Roombooking/src/search.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search Rooms</a>
                <a href="/Roombooking/src/admin.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto max-w-4xl p-4">
        <h1 class="text-3xl font-bold text-gray-900">Welcome to Roombooking</h1>
        <p class="mt-4 text-lg text-gray-700">
            Welcome to our room booking system! We offer a variety of rooms to suit your needs, whether you're looking for a single room, a double room, or a junior suite. Our system allows you to easily search for available rooms, register as a guest, and manage your bookings.
        </p>
        <p class="mt-4 text-lg text-gray-700">
            If you're an administrator, you can manage room types, make rooms unavailable for certain periods, and more. Use the navigation bar above to get started.
        </p>
        <p class="mt-4 text-lg text-gray-700">
            We hope you have a pleasant experience using our system. If you have any questions or need assistance, please don't hesitate to contact us.
        </p>
    </div>
    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</body>

</html>