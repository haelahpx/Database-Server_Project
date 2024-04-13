<?php
include 'config.php';
session_start();



$id = $_GET['id'] ?? null;

$query = mysqli_prepare($conn, "SELECT product.product_name, productdetails.image, productdetails.description, productdetails.price, productdetails.productdetails_id 
                               FROM productdetails 
                               INNER JOIN product ON productdetails.product_id = product.product_id 
                               WHERE productdetails.product_id = ?");
mysqli_stmt_bind_param($query, 'i', $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

$totalProduct = mysqli_num_rows($result);

$detail = mysqli_query($conn, "SELECT * FROM product WHERE product_id = '$id'");

$result2 = mysqli_query($conn, "SELECT * FROM product WHERE product_id = '$id'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php require "navbar.php"; ?>
    <a href="home.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Back</a>

    <div class="max-w-10xl mx-auto px-4 flex">
        <div class="w-3/10 pl-10">
            <?php if ($totalProduct > 0) {
                $data2 = mysqli_fetch_array($result2);
            ?>
                <h1 class="text-3xl font-bold text-gray-800 my-6"><?php echo $data2['product_name'] ?></h1>
                <img src="image/<?php echo $data2['image'] ?>" alt="Product Image" class="w-full h-64 object-cover mb-6 rounded-lg">
            <?php } else { ?>
                <h1 class="text-3xl font-bold text-gray-800 my-6">No Product Found</h1>
            <?php } ?>
        </div>
        <div class="w-7/10 pl-40">
            <?php if ($totalProduct > 0) {
                $data = mysqli_fetch_array($result);
            ?>
                <h1 class="text-3xl font-bold text-gray-800 my-6">Pilih Item</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-6 pb-6">
                    <?php
                    mysqli_data_seek($result, 0);
                    while ($data = mysqli_fetch_array($result)) { ?>
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md cursor-pointer" onclick="selectProduct(this)">
                            <img src="image/<?php echo $data['image'] ?>" alt="Product Image" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h2 class="text-xl font-semibold text-gray-800"><?php echo $data["description"] ?></h2>
                                <p class="text-gray-600">Rp.<?php echo $data["price"] ?></p>
                                <a href="buy.php?id=<?php echo $data['productdetails_id']; ?>" class="text-blue-500 hover:text-blue-700">BUY</a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            <?php } else { ?>
                <h1 class="text-3xl font-bold text-gray-800 my-6">No Products Available</h1>
            <?php } ?>
        </div>
    </div>

</body>

</html>