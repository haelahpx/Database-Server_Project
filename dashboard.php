<?php
require "config.php";
session_start();

if (!isset($_SESSION['customer_id'])) {
    exit("You are not logged in.");
}

$id = $_SESSION['customer_id'];

$query_customer = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id ='$id'");
$data_customer = mysqli_fetch_array($query_customer);

$query_orders = mysqli_query($conn, "SELECT * FROM ordermaster WHERE customer_id ='$id'");
$orderDetails = [];
while ($data_order = mysqli_fetch_array($query_orders)) {
    $orderDetails[] = $data_order;
}

if (isset($_POST['editImage'])) {
    $id = $_SESSION['customer_id'];
    $target_dir = "image/";
    $fileNames = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $fileNames;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_size = $_FILES["image"]["size"];

    if (getimagesize($_FILES["image"]["tmp_name"]) === false) {
        echo "File is not an image.";
        exit();
    }

    if ($image_size > 500000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
        exit();
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    $imageName = $_FILES['image']['name'];
    $updateQuery = mysqli_query($conn, "UPDATE customers SET image = '$imageName' WHERE customer_id = '$id'");
    header("Location: dashboard.php");
    exit();
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

    <div class="border p-4">
    <h1 class="text-xl font-bold mb-4">Profile</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <img src="image/<?php echo $data_customer['image'] ?>" alt="Product Image" width="180px" height="180px" class="mb-4 rounded">
        <label for="image" class="block mb-2">Image</label>
        <input type="file" name="image" id="image" class="border rounded px-3 py-2 mb-4">
        <button name="editImage" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
    </form>
</div>


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
                <?php foreach ($orderDetails as $order) : ?>
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