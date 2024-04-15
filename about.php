@ -1,23 +1,29 @@
<?php
include "config.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItSeven - Top Up Game, E-Wallet, and More</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php require "navbar.php"; ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4 text-center">Welcome to <span class="text-green-500">ItSeven</span></h1>
        <p class="text-lg mb-6">ItSeven is an online store that offers various services such as top up for games, e-wallets, and much more.</p>
        <p class="text-lg mb-6">We provide convenience in transactions to meet your gaming and digital payment needs.</p>
        <h2 class="text-2xl font-bold mb-4">About Us</h2>
        <p class="text-lg mb-6">This website was created as a college project by our group consisting of:</p>
        <ul class="list-disc ml-8 text-lg mb-6">
            <li>Muhammad Haikal Islami</li>
            <li>Haskal Dellas Moedja</li>
            <li>Samuel Adoman Manalu</li>
            <li>Fikhar Gifari</li>
        </ul>
    </div>
