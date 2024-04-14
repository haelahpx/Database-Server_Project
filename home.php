<?php
include "config.php";
session_start();

$query = "SELECT * FROM product";
            $result = mysqli_query($conn, $query);
$result= mysqli_query($conn, $query);

$query_bpjs = "SELECT product.* FROM product 
            INNER JOIN category ON product.category_id = category.category_id
            WHERE category.category_name = 'BPJS'";
$result_bpjs = mysqli_query($conn, $query_bpjs);

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
    
    <h1 class="text-2xl font-bold text-left my-8 pl-10">Recommendation</h1>
    <div class="flex flex-wrap justify-center">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg m-4 relative">
                <a href="product.php?id=<?php echo $row['product_id']; ?>" class="relative block group">
                    <img class="object-cover w-48 h-48 transform transition-transform hover:scale-50 z-0 hover:blur-sm" src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <span class="font-bold text-xl text-white"><?php echo $row['product_name']; ?></span>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <h1 class="text-2xl font-bold text-left my-8 pl-10">Game</h1>
    <div class="flex flex-wrap justify-center">
        <?php while ($row = mysqli_fetch_assoc($result_game)): ?>
            <div class="max-w-sm rounded overflow-hidden shadow-lg m-4 relative">
                <a href="product.php?id=<?php echo $row['product_id']; ?>" class="relative block group">
                    <img class="object-cover w-48 h-48 transform transition-transform hover:scale-50 z-0 hover:blur-sm" src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <span class="font-bold text-xl text-white"><?php echo $row['product_name']; ?></span>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>