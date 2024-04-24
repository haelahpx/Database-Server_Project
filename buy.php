<?php
include "config.php";
session_start();

if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
} else {
    header("Location: login.php");
    exit(); 
}

$id = $_GET['id'] ?? null;

$product_id = null;
if ($id !== null) {
    $query = "SELECT product_id FROM productdetails WHERE productdetails_id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $product_id = $row['product_id'];
    } else {
        echo "Product not found.";
        exit();
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['userid'])) {
        $userid = $_POST['userid'];

        $order_date = date('Y-m-d H:i:s');
        $sql_order = "INSERT INTO ordermaster (customer_id, order_date, userid) VALUES ('$customer_id', '$order_date', '$userid')";
        if (mysqli_query($conn, $sql_order)) {
            $order_id = mysqli_insert_id($conn); 

            if (isset($_POST['payment_method'])) {
                $payment_method = $_POST['payment_method'];

                $transaction_date = date('Y-m-d');
                $sql_payment = "INSERT INTO payment (order_id, payment_method, transaction_date) VALUES ('$order_id', '$payment_method', '$transaction_date')";
                if (mysqli_query($conn, $sql_payment)) {
                    $sql_order_details = "INSERT INTO orderdetails (order_id, product_id, productdetails_id) VALUES ('$order_id', '$product_id', '$id')";
                    if (mysqli_query($conn, $sql_order_details)) {
                        if ($payment_method === 'Indomaret' || $payment_method === 'Qris') {
                            header("Location: order.php?id=$id");
                            exit();
                        }
                    } else {
                        echo "Error inserting order details: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting payment details: " . mysqli_error($conn);
                }
            } else {
                echo "Payment method is required.";
            }
        } else {
            echo "Error inserting order details: " . mysqli_error($conn);
        }
    } else {
        echo "User ID is required.";
    }
}

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-50">
    <?php require "navbar.php"; ?>
    <a href="index.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Back</a>

    <div class="flex items-center justify-center pt-10 bg-gray-50">
        <form method="post" class="max-w-md w-full bg-white p-8 rounded-md shadow-md">
            <div class="mt-4 flex flex-col gap-y-4">
                <input required type="text" name="userid" placeholder="Enter User ID" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                
            </div>
            
            <h1 class="text-2xl font-semibold mt-8 mb-4">Payment Method</h1>
            <div class="grid grid-cols-2 gap-6">
                <label for="payment_indomaret" class="relative cursor-pointer">
                    <input class="peer " type="radio" id="payment_indomaret" name="payment_method" value="Indomaret" />
                    <div class="payment-content rounded-md shadow-md p-4 border border-gray-200 hover:border-indigo-400 transition duration-300">
                        <img class="w-32 mx-auto" src="image/indomaret.png" alt="Indomaret">
                        <p class="text-lg font-semibold mt-4">Rp.<?= $price ?></p>
                    </div>
                </label>
                <label for="payment_qris" class="relative cursor-pointer">
                    <input class="peer " type="radio" id="payment_qris" name="payment_method" value="Qris" />
                    <div class="payment-content rounded-md shadow-md p-4 border border-gray-200 hover:border-indigo-400 transition duration-300">
                        <img class="w-32 mx-auto" src="image/qris.png" alt="Qris">
                        <p class="text-lg font-semibold mt-4">Rp.<?= $price ?></p>
                    </div>
                </label>
            </div>

            <button type="submit" name="submit" class="mt-8 py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                Order
            </button>
        </form>
    </div>
    <?php require "footer.php"; ?>
</body>

</html>
