<?php
require "config.php"; 
session_start();

$id = $_GET['id'] ?? null;

if ($id !== null) {
    $stmt = $conn->prepare("SELECT price FROM productdetails WHERE productdetails_id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];
    } else {
        $price = null; 
    }
    $stmt->close();
} else {
    $price = null;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting for Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="bg-gray-200 min-h-screen flex flex-col justify-center items-center">
        <p class="text-2xl font-bold mb-4">Waiting for Payment</p>
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=demo" alt="QR Code for Payment">
            <?php if ($price !== null): ?>
                <p class="text-lg font-semibold mt-4">Price: $<?= $price ?></p>
            <?php else: ?>
                <p class="text-lg font-semibold mt-4">Price not available</p>
            <?php endif; ?>
            <div class="mt-4">
                <a href="home.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded items-center justify-center flex">DONE</a>
            </div>
        </div>
    </div>
    <?php require "footer.php"; ?>
</body>
</html>

