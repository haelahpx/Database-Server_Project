<?php
session_start();
require "../config.php";

$query_game = mysqli_query($conn, "SELECT product.*, category.category_name FROM product JOIN category ON product.category_id = category.category_id WHERE category.category_name = 'game'");
$totalProductGame = mysqli_num_rows($query_game);

$query_ewallet = mysqli_query($conn, "SELECT product.*, category.category_name FROM product JOIN category ON product.category_id = category.category_id WHERE category.category_name = 'e-walllet'");
$totalProductEwallet = mysqli_num_rows($query_ewallet);

if(isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);

    $deleteOrderDetailsQuery = mysqli_query($conn, "DELETE FROM orderdetails WHERE productdetails_id IN (SELECT productdetails_id FROM productdetails WHERE product_id = '$delete_id')");
    if($deleteOrderDetailsQuery) {
        $deleteProductDetailsQuery = mysqli_query($conn, "DELETE FROM productdetails WHERE product_id = '$delete_id'");
        if($deleteProductDetailsQuery) {
            $deleteProductQuery = mysqli_query($conn, "DELETE FROM product WHERE product_id = '$delete_id'");
            if($deleteProductQuery) {
                header("Location: product.php");
                exit();
            } else {
                echo "Error deleting product record: " . mysqli_error($conn);
                exit();
            }
        } else {
            echo "Error deleting related product details: " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "Error deleting related order details: " . mysqli_error($conn);
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category'];
    $fileName = basename($_FILES["image"]["name"]);

    $target_dir = "../image/";
    $target_file = $target_dir . $fileName;
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

    $checkQuery = mysqli_query($conn, "SELECT * FROM product WHERE product_name='$product_name'");
    if (mysqli_num_rows($checkQuery) > 0) {
        $existingProduct = mysqli_fetch_assoc($checkQuery);
        if ($existingProduct['category_id'] != $category_id) {
            $insertQuery = "INSERT INTO product (product_name, category_id, image) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "sis", $product_name, $category_id, $fileName);
            if (mysqli_stmt_execute($stmt)) {
                $product_id = mysqli_insert_id($conn);
                header("Location: product.php?id=$product_id");
                exit();
            } else {
                echo "Error inserting record: " . mysqli_error($conn); 
            }
        } 
    } else {
        $insertQuery = "INSERT INTO product (product_name, category_id, image) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sis", $product_name, $category_id, $fileName);
        if (mysqli_stmt_execute($stmt)) {
            $product_id = mysqli_insert_id($conn);
            header("Location: product.php?id=$product_id");
            exit();
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
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
    <div class="max-w-4xl mx-auto bg-white rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 my-6">List Product (Game)</h1>
        <div class="overflow-hidden shadow-md rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Product</th>
                        <th class="py-3 px-4 text-left">Category</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($totalProductGame == 0) { ?>
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-600">There is no product data in the game category</td>
                        </tr>
                    <?php } else {
                        $number = 1;
                        while ($data = mysqli_fetch_array($query_game)) {
                    ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4"><?= $number ?></td>
                                <td class="py-3 px-4"><?= $data["product_name"] ?></td>
                                <td class="py-3 px-4"><?= $data["category_name"] ?></td>
                                <td class="py-3 px-4">
                                    <a href="product-details.php?id=<?= $data['product_id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Details
                                    </a>
                                    <a href="?delete_id=<?= $data['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                    <?php
                            $number++;
                        }
                    } ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 my-6">List Product (E-Wallet)</h1>
        <div class="overflow-hidden shadow-md rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Product</th>
                        <th class="py-3 px-4 text-left">Category</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($totalProductEwallet == 0) { ?>
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-600">There is no product data in the e-wallet category</td>
                        </tr>
                    <?php } else {
                        $number = 1;
                        while ($data = mysqli_fetch_array($query_ewallet)) {
                    ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4"><?= $number ?></td>
                                <td class="py-3 px-4"><?= $data["product_name"] ?></td>
                                <td class="py-3 px-4"><?= $data["category_name"] ?></td>
                                <td class="py-3 px-4">
                                    <a href="product-details.php?id=<?= $data['product_id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Details
                                    </a>
                                    <a href="?delete_id=<?= $data['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                    <?php
                            $number++;
                        }
                    } ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Product Form -->
    <div class="max-w-4xl mx-auto pt-4">
        <div class="bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-bold mb-4 text-gray-800 px-6 py-4 border-b border-gray-200">Add Product</h3>
            <form action="" method="post" enctype="multipart/form-data" class="space-y-4 px-6 py-4">
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product</label>
                    <input type="text" id="product_name" name="product_name" placeholder="Input Product Name" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                    <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category" name="category" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <?php
                        $category_query = mysqli_query($conn, "SELECT * FROM category");
                        while ($category_row = mysqli_fetch_assoc($category_query)) {
                            echo "<option value='" . $category_row['category_id'] . "'>" . $category_row['category_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <button type="submit" name="save" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
                </div>
            </form>
            <!-- PHP Form Submission and Alerts -->
            <?php
            if (isset($_POST['save'])) {
                $product_name = htmlspecialchars($_POST['product_name']);
                $category_id = $_POST['category'];

                $checkQuery = mysqli_query($conn, "SELECT * FROM product WHERE product_name='$product_name'");
                if (mysqli_num_rows($checkQuery) > 0) {
                    $existingProduct = mysqli_fetch_assoc($checkQuery);
                    if ($existingProduct['category_id'] != $category_id) {
                        $saveQuery = mysqli_query($conn, "INSERT INTO product (product_name, category_id) VALUES ('$product_name', '$category_id')");

                        if ($saveQuery) {
                            echo '<div id="successAlert" class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Success alert!</span> The product has been added.
                                    </div>
                                    <meta http-equiv="refresh" content="1; url=product.php" />
                                </div>';
                        } else {
                            echo mysqli_error($conn);
                        }
                    } else {
                        echo '<div id="warningAlert" class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">Warning alert!</span> The product you entered already exists in the same category.
                                </div>
                            </div>';
                    }
                } else {
                    $saveQuery = mysqli_query($conn, "INSERT INTO product (product_name, category_id) VALUES ('$product_name', '$category_id')");

                    if ($saveQuery) {
                        echo '<div id="successAlert" class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">Success alert!</span> The product has been added.
                                </div>
                                <meta http-equiv="refresh" content="1; url=product.php" />
                            </div>';
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
