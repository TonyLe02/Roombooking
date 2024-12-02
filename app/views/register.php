<?php
if (isset($toastMessage)) {
    include __DIR__ . '/../../app/views/components/toast_success.php';
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