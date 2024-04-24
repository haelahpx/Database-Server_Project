<?php
    require "config.php";

    // Check if user is logged in
    $loggedIn = isset($_SESSION['user_name']);

    // Define the base URL for logged in and logged out users
    $baseUrl = $loggedIn ? "dashboard.php" : "login.php";

    // Get the customer ID if user is logged in
    $id = $loggedIn ? $_SESSION['customer_id'] : null;

    // Fetch customer data if user is logged in
    $data_customer = null;
    if ($loggedIn) {
        $query_customer = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id ='$id'");
        $data_customer = mysqli_fetch_array($query_customer);
        // Extract the image path from the fetched data
        $image_path = $data_customer['image']; // Assuming 'image' is the column name
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <style>
        #user-dropdown {
            top: calc(0.5rem);
            right: calc(80rem);
        }

        @media (max-width: 768px) {
            #text {
                display: none;
            }

            #user-dropdown {
                right: calc(20rem);
            }
        }

        @media (max-width: 1024px) {

            #text {
                font-size: smaller;
            }

            #user-dropdown {
                right: calc(42rem);
            }
        }
    </style>
</head>

<body>
    <nav class="sticky top-0 z-50 bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="image/logo.png" class="h-8 hover:scale-110 hover:rotate-180 transition-transform duration-300" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">ItSeven</span>
            </a>

            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <?php if ($loggedIn) { ?>
                    <!-- Show user menu if logged in -->
                    <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <!-- Update src attribute to display dynamic image -->
                        <img class="w-8 h-8 rounded-full" src="image/<?php echo $image_path; ?>" alt="user photo">
                    </button>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-12" id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white"><?php echo $_SESSION['user_name']; ?></span>
                            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?php echo $loggedIn ? $_SESSION['email'] : ''; ?></span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="adminpanel/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                            </li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <!-- Show sign-in and register dropdown if not logged in -->
                    <div class="flex space-x-3">
                        <a href="login.php" class="text-sm text-white hover:text-blue-700">Sign In</a>
                        <a href="register.php" class="text-sm text-white hover:text-blue-700">Register</a>
                    </div>
                <?php } ?>

                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="home.php" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo $baseUrl; ?>" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                    </li>
                </ul>
            </div>
            <p id="text" class="text-white">Anti-Blind Map Top Up Website, Fastest and Most Trusted in Indonesia.</p>
        </div>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userMenuButton = document.getElementById("user-menu-button");
            const userDropdown = document.getElementById("user-dropdown");
            const navbarUserButton = document.querySelector("[data-collapse-toggle='navbar-user']");
            const navbarUser = document.getElementById("navbar-user");

            userMenuButton.addEventListener("click", function() {
                const expanded = userMenuButton.getAttribute("aria-expanded") === "true" || false;
                userMenuButton.setAttribute("aria-expanded", !expanded);
                userDropdown.classList.toggle("hidden");
            });

            navbarUserButton.addEventListener("click", function() {
                const expanded = navbarUserButton.getAttribute("aria-expanded") === "true" || false;
                navbarUserButton.setAttribute("aria-expanded", !expanded);
                navbarUser.classList.toggle("hidden");
            });
        });
    </script>
</body>

</html>