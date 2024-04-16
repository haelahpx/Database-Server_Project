<?php
session_start();
require "../config.php";

$id = $_GET['id'] ?? null;

$query = mysqli_query($conn, "SELECT * FROM product WHERE product_id ='$id'");
$data = mysqli_fetch_array($query);

if ($id !== null) {
    $stmt = mysqli_prepare($conn, "SELECT productdetails.*, product.product_name FROM productdetails JOIN product ON productdetails.product_id = product.product_id WHERE productdetails.product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $totalProduct = mysqli_num_rows($query);
} else {
    $totalProduct = 0;
}

if (isset($_POST['inputData'])) {
    $description = $_POST['description'];
    $price = $_POST['price'];
    $product_id = $_POST['product_id'];

    $target_dir = "../image/";
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

    $insertQuery = "INSERT INTO productdetails (description, price, image, product_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssi", $description, $price, $fileNames, $product_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: product-details.php?id=$product_id");
        exit();
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}
if (isset($_POST['editImage'])) {
    $id = $_GET['id'] ?? null;
    $target_dir = "../image/";
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

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageType = $image['type'];

        if (strpos($imageType, 'image') !== false) {
            $uploadPath = '../images/' . $imageName;
            move_uploaded_file($imageTmpName, $uploadPath);

            $updateQuery = mysqli_query($conn, "UPDATE product SET image = '$imageName' WHERE product_id = '$id'");
            header("Location: product-details.php?id=$id");
        }
    } else {
        $updateQuery = mysqli_query($conn, "UPDATE product SET image = '$imageName' WHERE product_id = '$id'");
        header("Location: product-details.php?id=$id");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details-Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100">

    <?php include "navbar.php"; ?>
    <a href="product.php" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Back</a>

    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-3">
            <div class="border border-gray-300 p-6 rounded-lg">
                <h1 class="text-3xl font-bold mb-4">Details Product</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <img src="../image/<?php echo $data['image'] ?>" alt="Product Image"  width="180px" class=" h-auto rounded-lg mb-4">
                    <label for="image" class="block mb-2">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="border border-gray-300 px-4 py-2 w-full rounded-lg mb-2">
                    <button name="editImage" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full">Update</button>
                </form>
            </div>

            <div class="border border-gray-300 p-6 rounded-lg p-3">
                <h1 class="text-3xl font-bold mb-4">Add Item</h1>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="description" class="block mb-2">Description</label>
                        <input type="text" name="description" id="description" required class="border border-gray-300 px-4 py-2 w-full rounded-lg mb-2">
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block mb-2">Price</label>
                        <input type="text" name="price" id="price" required class="border border-gray-300 px-4 py-2 w-full rounded-lg mb-2">
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block mb-2">Image</label>
                        <input type="file" name="image" id="image" required class="border border-gray-300 px-4 py-2 w-full rounded-lg mb-2">
                    </div>
                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    <button name="inputData" type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg w-full mt-6">Add New Data</button>
                </form>
            </div>
        </div>
        <div class="mt-8 p-3">
    <h1 class="text-3xl font-bold mb-4">Product List</h1>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Product</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Price</th>
                    <th class="border border-gray-300 px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($totalProduct == 0) { ?>
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-4 py-2">There is no product data in the database</td>
                    </tr>
                <?php } else {
                    $number = 1;
                    while ($data = mysqli_fetch_array($query)) { ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2"><?= $number ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $data["product_name"] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $data["description"] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $data["price"] ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="product-edit.php?id=<?= $data['productdetails_id'] ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
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

</body>

</html>
