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

if (isset($_POST['editProfile'])) {
    $id = $_SESSION['customer_id'];
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : $data_customer['username'];

    if (!empty($_FILES['image']['name'])) {
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
    } else {
        $imageName = $data_customer['image'];
    }

    $updateQuery = mysqli_query($conn, "UPDATE customers SET image = '$imageName', username ='$username' WHERE customer_id = '$id'");
    header("Location: dashboard.php");
    exit();
}
?>

<style>
.placeholder-center::placeholder {
    text-align: center;
}
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Order Details</title>
</head>

<body class="bg-gray-100">
    <?php require "navbar.php"; ?>

    <div class="container mx-auto flex flex-col lg:flex-row justify-between">
        <div class="w-full lg:w-1/3 p-4">
            <div class="profile-container bg-white rounded-lg p-4 shadow-md mt-8 mx-auto">

                <form class="max-w-lg mx-auto" method="post" enctype="multipart/form-data">
                    <div class=" mb-4">
                        <div class="form-group">
                            <img src="image/<?php echo $data_customer['image'] ?>" alt="Product Image" class="w-40 h-40 rounded-full mx-auto block"><br>

                            <div class=" mb-2 pl-40">
                                <label for="image-upload" class="bg-gray-900 border-gray-200 dark:bg-gray-900 text-white font-bold py-2 px-4 rounded cursor-pointer">
                                    Upload Image
                                    <input type="file" name="image" id="image-upload" class="hidden">
                                </label>
                            </div>
                            <hr class="my-4 border-gray-400">

                            <div class="flex items-center mb-2 pl-18">
                                <input type="text" name="username" placeholder="change username" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-full lg:w-[20rem] placeholder-center">

                            </div>
                        </div>
                    </div>
                    <div class="pl-48">
                        <button name="editProfile" class="bg-gray-900 border-gray-200 dark:bg-gray-900 text-white font-bold py-2 px-4 rounded">Update</button>
                    </div>
                </form>

            </div>
            <div class="profile-container rounded-lg mt-4 mx-auto">
                <div class="bg-white rounded-lg shadow-md ">
                    <img class=" rounded-lg" src="image/baner.jpg">
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 p-4">
            <div class="history-section mt-8 mx-auto rounded-lg bg-white border p-4 shadow-md">
                <h1 class="text-2xl font-bold mb-4 text-gray-800">History Payment</h1>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Customer ID</th>
                                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">User ID</th>
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
            </div>
        </div>
    </div>
</body>

</html>
