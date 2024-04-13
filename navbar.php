<nav class="bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">

            <div class="flex space-x-4">
                <div>
                    <a href="home.php" class="flex items-center py-5 px-2 text-gray-700 hover:text-gray-900">
                        <svg class="h-6 w-6 mr-1 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span class="font-bold">ItSeven</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="about.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">About</a>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-1">
                <a href="adminpanel/logout.php" class="py-5 px-3">Logout</a>
            </div>

            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div class="mobile-menu hidden md:hidden">
        <a href="about.php" class="block py-2 px-4 text-sm hover:bg-gray-200">About</a>
        <a href="adminpanel/logout.php" class="block py-2 px-4 text-sm hover:bg-gray-200">Logout</a>
    </div>
</nav>

<script>
    const btn = document.querySelector("button.mobile-menu-button");
    const menu = document.querySelector(".mobile-menu");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
</script>