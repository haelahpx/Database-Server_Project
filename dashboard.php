<?php
require "config.php"; 
session_start();

if (!isset($_SESSION['customer_id'])) {
    exit("You are not logged in.");
}

$id = $_SESSION['customer_id'];

$query = mysqli_query($conn, "SELECT * FROM ordermaster WHERE customer_id ='$id'");
$orderDetails = [];
while ($data = mysqli_fetch_array($query)) {
    $orderDetails[] = $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Order Details</title>
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold my-4">History Payment</h1>
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Customer ID</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">User ID</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($orderDetails as $order): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap"><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td class="px-6 py-4 whitespace-no-wrap"><?php echo htmlspecialchars($order['customer_id']); ?></td>
                    <td class="px-6 py-4 whitespace-no-wrap"><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td class="px-6 py-4 whitespace-no-wrap"><?php echo htmlspecialchars($order['userid']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
