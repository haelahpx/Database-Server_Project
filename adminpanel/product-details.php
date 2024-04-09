<?php
session_start();
require "../config.php";

$id = $_GET['id'] ?? null;

if ($id !== null) {
    // Prevent SQL injection using prepared statements
    $stmt = mysqli_prepare($conn, "SELECT productdetails.*, product.product_name FROM productdetails JOIN product ON productdetails.product_id = product.product_id WHERE productdetails.product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $totalProduct = mysqli_num_rows($query);
} else {
    $totalProduct = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $price = $_POST['price'];
    $product_id = $_POST['product_id'];

    // Handle image upload
    $target_dir = "../image/";
    $fileNames = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $fileNames;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_size = $_FILES["image"]["size"];

    // Check if file is an image
    if (getimagesize($_FILES["image"]["tmp_name"]) === false) {
        echo "File is not an image.";
        exit();
    }

    // Check file size
    if ($image_size > 500000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
        exit();
    }

    // Move uploaded file to destination directory
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    // Insert data into database
    $insertQuery = "INSERT INTO productdetails (description, price, image, product_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssi", $description, $price, $fileNames, $product_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: product-details.php?id=$product_id");
        exit();
    } else {
        echo "Error inserting record: " . mysqli_error($conn); // Display the MySQL error
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Details-Category</title>
</head>

<body>

    <?php require "navbar.php"; ?>

    <div class="flex justify-center mt-8">
        <a href="product.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            BACK
        </a>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 my-6">Details Product</h1>
        <div class="overflow-hidden shadow-md rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Product</th>
                        <th class="py-3 px-4 text-left">Description</th>
                        <th class="py-3 px-4 text-left">Price</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($totalProduct == 0) { ?>
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-600">There is no product data in the database</td>
                        </tr>
                    <?php } else {
                        $number = 1;
                        while ($data = mysqli_fetch_array($query)) {
                    ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4"><?= $number ?></td>
                                <td class="py-3 px-4"><?= $data["product_name"] ?></td>
                                <td class="py-3 px-4"><?= $data["description"] ?></td>
                                <td class="py-3 px-4"><?= $data["price"] ?></td>
                                <td class="py-3 px-4">
                                    <a href="product-edit.php?id=<?= $data['productdetails_id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block align-middle mr-2">
                                            <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z" clip-rule="evenodd" />
                                        </svg>
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
        <h1 class="text-3xl font-bold text-gray-800 my-6">Add Product</h1>
        <div class="overflow-hidden shadow-md rounded-lg">
            <form method="POST" class="my-6 mx-4" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                    <input type="text" name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                    <input type="text" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                    <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Add New Data
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
