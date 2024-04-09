<?php
session_start();
if(!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}
require "../config.php";

$totalcategory = 0;
$querycategory = mysqli_query($conn, "SELECT * FROM category");
if ($querycategory) {
    $totalcategory = mysqli_num_rows($querycategory);
}

$totalproduct = 0;
$queryproduct = mysqli_query($conn, "SELECT * FROM product");
if ($queryproduct) {
    $totalproduct = mysqli_num_rows($queryproduct);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body>
    <?php require "navbar.php"; ?>


    <div class="bg-slate-800 text-white rounded-lg p-4 shadow-md max-w-xs mt-5 ml-5">
        <div class="flex items-center">
            <div class="mr-8"> 
                <div class="w-6 h-0.5 bg-white mb-1"></div>
                <div class="w-6 h-0.5 bg-white mb-1"></div>
                <div class="w-6 h-0.5 bg-white"></div>
            </div>


            <div>
                <h1 class="text-xl font-bold">Category</h1>
                <p></p>
                <p class="text-gray-300"><?php echo $totalcategory ?> categories</p>
                <p class="text-gray-300">Details</p>
            </div>
        </div>
    </div>
    <div class="bg-slate-800 text-white rounded-lg p-4 shadow-md max-w-xs mt-5 ml-5">
        <div class="flex items-center">
            <div class="mr-8"> 
                <div class="w-6 h-0.5 bg-white mb-1"></div>
                <div class="w-6 h-0.5 bg-white mb-1"></div>
                <div class="w-6 h-0.5 bg-white"></div>
            </div>

            <div>
                <h1 class="text-xl font-bold">Product</h1>
                <p></p>
                <p class="text-gray-300"><?php echo $totalproduct ?> products</p>
                <p class="text-gray-300">Details</p>
            </div>
        </div>
    </div>

</body>

</html>