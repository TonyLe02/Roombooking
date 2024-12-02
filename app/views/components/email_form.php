<!-- Email Input Form -->
<div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 mt-8">
    <form method="POST" action="">
        <div class="mb-6 relative">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Enter your email:</label>
            <div class="flex items-center border border-gray-300 rounded-lg">
                <span class="px-3 text-gray-500">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" id="email" name="email" class="w-full p-4 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="yourname@example.com" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="inline-block rounded-lg bg-green-600 px-5 py-3 text-white font-semibold hover:bg-green-700 transition duration-300 ease-in-out shadow-md">
                Send Confirmation Email
            </button>
        </div>
    </form>
</div>