<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <header class="mt-4 rounded-lg bg-gradient-to-r from-[#2E3192] to-[#1BFFFF] text-white py-12 shadow-lg">
        <div class="container mx-auto text-center">
            <h1 class="text-6xl font-extrabold leading-snug">Welcome to MoteIT </h1>
            <p class="mt-4 text-2xl italic">Your simple room booking system</p>
            <p class="mt-2 text-lg">Book your favorite room easily and efficiently</p>
        </div>
    </header>

    <main class="container mx-auto mt-6">
        <section class="text-center mb-10">
            <h2 class="text-4xl font-bold mb-4 leading-normal bg-clip-text text-transparent bg-gradient-to-r from-[#2E3192] to-[#1BFFFF]">Simple, Efficient, Elegant</h2>
            <p class="text-gray-800 text-lg leading-snug">Experience a simple and efficient way to book your favorite room, with an elegant user experience that puts guests first.</p>
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="/Roombooking/public/login.php" class="mt-4 inline-block bg-gradient-to-r from-[#2E3192] to-[#1BFFFF] text-white font-semibold py-3 px-6 rounded-lg shadow">
                    Get Started
                </a>
            <?php endif; ?>
        </section>
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-300">
                <a href="Roomtype.php?room=single">
                    <img src="/Roombooking/public/images/Single.webp" alt="Single Room" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-3xl font-semibold mb-3 leading-normal bg-clip-text text-transparent bg-gradient-to-r from-[#2E3192] to-[#1BFFFF]">Single Room</h3>
                    </div>
                </a>
            </div>
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-300">
                <a href="Roomtype.php?room=double">
                    <img src="/Roombooking/public/images/Double.webp" alt="Double Room" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-3xl font-semibold mb-3 leading-snug bg-clip-text text-transparent bg-gradient-to-r from-[#2E3192] to-[#1BFFFF]">Double Room</h3>
                    </div>
                </a>
            </div>
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-300">
                <a href="Roomtype.php?room=suite">
                    <img src="/Roombooking/public/images/Suite.webp" alt="Junior Suite" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-3xl font-semibold mb-3 leading-snug bg-clip-text text-transparent bg-gradient-to-r from-[#2E3192] to-[#1BFFFF]">Junior Suite</h3>
                    </div>
                </a>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center mt-10">
            <div class="card bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h3 class="text-3xl font-semibold mb-3 leading-snug">Quick Booking</h3>
                <p class="text-gray-700">Find and reserve your room with just a few clicks.</p>
            </div>
            <div class="card bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h3 class="text-3xl font-semibold mb-3 leading-snug ">Flexible Options</h3>
                <p class="text-gray-700">Choose from various room types for any occasion.</p>
            </div>
            <div class="card bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h3 class="text-3xl font-semibold mb-3 leading-snug">Outstanding Service</h3>
                <p class="text-gray-700">Experience our unparalleled customer service.</p>
            </div>
        </section>
    </main>

    <style>
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</body>