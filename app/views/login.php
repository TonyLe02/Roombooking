<!-- Login form or content goes here -->
<div class="container mx-auto max-w-md p-4">
    <h1 class="text-3xl font-bold text-gray-900">Login</h1>
    <form action="login.php" method="POST" class="mt-4">
        <div class="mb-4">
            <label for="username" class="block text-sm font-bold text-gray-900">Username</label>
            <input type="text" name="username" id="username" class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-bold text-gray-900">Password</label>
            <input type="password" name="password" id="password" class="mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200" required>
        </div>
        <button type="submit" class="w-full bg-gray-900 text-white py-2 px-4 rounded-md shadow-sm">Sign into account</button>
    </form>
</div>