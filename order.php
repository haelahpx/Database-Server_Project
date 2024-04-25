<?php
require "config.php";
session_start();

$id = $_GET['id'] ?? null;

$product_name = $description = $price = $order_date = $paymentmethod = null;

if ($id !== null) {
    $stmt = $conn->prepare("SELECT od.*, p.product_name, pd.description, pd.price, om.order_date, pm.payment_method 
                            FROM orderdetails od 
                            JOIN product p ON od.product_id = p.product_id 
                            JOIN productdetails pd ON od.productdetails_id = pd.productdetails_id 
                            JOIN ordermaster om ON od.order_id = om.order_id 
                            JOIN payment pm ON om.order_id = pm.order_id 
                            WHERE od.productdetails_id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $description = $row['description'];
        $price = $row['price'];
        $order_date = $row['order_date'];
        $paymentmethod = $row['payment_method'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting for Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <?php require "navbar.php"; ?>
    <div class="min-h-screen flex flex-col justify-center items-center">
        <p class="text-2xl font-bold mb-4">Waiting for Payment</p>
        <div class="flex flex-col lg:flex-row items-start lg:space-x-8 w-full max-w-screen-lg">
            <div class="bg-white p-4 rounded-lg shadow-lg flex-1">
                <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
                <?php if ($product_name !== null): ?>
                    <p class="mb-2"><span class="font-semibold">Product Name:</span> <?= htmlspecialchars($product_name) ?></p>
                    <p class="mb-2"><span class="font-semibold">Order Date:</span> <?= $order_date ?></p>
                    <p class="mb-2"><span class="font-semibold">Description:</span> <?= htmlspecialchars($description) ?></p>
                    <p class="mb-2"><span class="font-semibold">Payment Method:</span> <?= $paymentmethod ?></p>
                    <p class="mb-2"><span class="font-semibold">Price:</span> <?= $price ?></p>
                <?php else: ?>
                    <p>No data found for the provided ID.</p>
                <?php endif; ?>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-lg mt-4 lg:mt-0 flex flex-col items-center">
                <p class="mb-4">Scan the QR code below:</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=demo" alt="QR Code for Payment" class="w-64 h-64">
                <div class="mt-4">
                    <a href="index.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">DONE</a>
                </div>
            </div>
        </div>
    </div>
    <?php require "footer.php"; ?>
</body>
</html>
