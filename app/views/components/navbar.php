<?php
// Start the session
session_start();
// Include the database connection script
include __DIR__ . '/../../core/db_connect.php';

$current_page = basename($_SERVER['REQUEST_URI']); // Get the filename from the URL
?>

<nav class="bg-[#2E3192] shadow-lg">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="/Roombooking/public/index.php" class="rounded-md px-3 py-2 text-sm font-medium <?php echo $current_page == 'index.php' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>" aria-current="page">Home</a>
                        <?php if (!isset($_SESSION['username'])): ?>
                            <a href="/Roombooking/public/register.php" class="rounded-md px-3 py-2 text-sm font-medium <?php echo $current_page == 'register.php' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>">Register</a>
                            <a href="/Roombooking/public/login.php" class="rounded-md px-3 py-2 text-sm font-medium <?php echo $current_page == 'login.php' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>">Login</a>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['username']) && ($_SESSION['role'] == 'guest' || $_SESSION['role'] == 'admin')): ?>
                            <a href="/Roombooking/public/search.php" class="rounded-md px-3 py-2 text-sm font-medium <?php echo $current_page == 'search.php' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>">Search Rooms</a>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <a href="/Roombooking/public/admin.php" class="rounded-md px-3 py-2 text-sm font-medium <?php echo $current_page == 'admin.php' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>">Admin Dashboard</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex space-x-4 items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <?php if (isset($_SESSION['username'])): ?>
                    <?php
                    // Fetch the user's role from the database
                    $stmt = $conn->prepare("SELECT role FROM users WHERE username = ?");
                    $stmt->bind_param("s", $_SESSION['username']);
                    $stmt->execute();
                    $stmt->bind_result($userRole);
                    $stmt->fetch();
                    $stmt->close();
                    ?>

                    <span class="mr-4 text-sm text-white">
                        <span class="inline-block ml-2 px-2 py-1 text-xs font-semibold text-gray-900 bg-white rounded-full">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        <span class="inline-block ml-2 px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded-full">
                            <?php echo ucfirst($userRole); ?>
                        </span>
                    </span>

                    <!-- Notifications Button -->
                    <button type="button" class="relative rounded-full bg-transparent p-1 text-white hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative ml-3">
                        <div>
                            <button type="button" class="relative flex rounded-full bg-transparent text-sm text-white    hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onclick="toggleDropdown()">
                                <span class="sr-only">Open user menu</span>
                                <svg class="h-8 w-8 rounded-full" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                            <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <i class="fas fa-list mr-2 text-gray-400"></i>
                                Your Booking
                            </a>
                            <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <i class="fas fa-cog mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a href="/Roombooking/public/logout.php" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>

                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>
<script>
    // Dropdown menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('user-menu-button');
        const dropdownMenu = document.getElementById('dropdown-menu');

        // Toggle dropdown on button click
        menuButton.addEventListener('click', function(event) {
            event.preventDefault();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = menuButton.contains(event.target) || dropdownMenu.contains(event.target);
            if (!isClickInside) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>