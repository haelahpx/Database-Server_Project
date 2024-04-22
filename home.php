<?php
include "config.php";
session_start();

$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);

$query_eWallet = "SELECT product.* FROM product 
            INNER JOIN category ON product.category_id = category.category_id
            WHERE category.category_name = 'e-walLlet'";
$result_eWallet = mysqli_query($conn, $query_eWallet);

$query_game = "SELECT product.* FROM product 
            INNER JOIN category ON product.category_id = category.category_id
            WHERE category.category_name = 'game'";
$result_game = mysqli_query($conn, $query_game);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body class="bg-gray-300">
    <?php require "navbar.php"; ?>

    <div class="w-10/12 2xl mx-auto">

        <div id="default-carousel" class="relative rounded-lg overflow-hidden shadow-lg mt-5 " data-carousel="static">
            <div class="relative h-80 md:h-96" data-carousel-inner>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="image/test.png" class="object-cover w-full h-full" alt="Slide 1">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="image/test.png" class="object-cover w-full h-full" alt="Slide 2">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="image/test.png" class="object-cover w-full h-full" alt="Slide 3">
                </div>
            </div>
            <div class="flex absolute bottom-5 left-1/2 z-30 -translate-x-1/2 space-x-2" data-carousel-indicators>
                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
            </div>
            <button type="button" class="flex absolute top-1/2 left-3 z-40 items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition" data-carousel-prev>
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button type="button" class="flex absolute top-1/2 right-3 z-40 items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition" data-carousel-next>
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
        <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
    </div>


    <h1 class="text-2xl font-bold text-left my-8 pl-36">Game</h1>
    <div class="flex flex-wrap justify-center">
        <?php while ($row = mysqli_fetch_assoc($result_game)) : ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg m-2 relative">
                <a href="product.php?id=<?php echo $row['product_id']; ?>" class="relative block group">
                    <img class="h-48 w-40 object-cover object-center group-hover:blur-xl transition-all duration-200 ease-in-out !rounded-[20px]" src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <span class="font-bold text-xl text-white"><?php echo $row['product_name']; ?></span>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <h1 class="text-2xl font-bold text-left my-8 pl-36">E-Wallet</h1>
    <div class="flex flex-wrap justify-center">
        <?php while ($row = mysqli_fetch_assoc($result_eWallet)) : ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg m-2 relative">
                <a href="product.php?id=<?php echo $row['product_id']; ?>" class="relative block group">
                    <img class="h-48 w-40 object-cover object-center group-hover:blur-xl transition-all duration-200 ease-in-out !rounded-[20px]" src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <span class="font-bold text-xl text-white"><?php echo $row['product_name']; ?></span>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <h1 class="text-2xl font-bold text-left my-8 pl-36">All Items</h1>
    <div class="flex flex-wrap justify-center">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg m-2 relative">
                <a href="product.php?id=<?php echo $row['product_id']; ?>" class="relative block group">
                    <img class="h-48 w-40 object-cover object-center group-hover:blur-xl transition-all duration-200 ease-in-out !rounded-[20px]" src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <span class="font-bold text-xl text-white"><?php echo $row['product_name']; ?></span>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php require "footer.php"; ?>
</body>

</html>