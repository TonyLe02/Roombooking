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