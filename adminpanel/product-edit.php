<?php
session_start();
require "../config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($conn, "SELECT * FROM productdetails WHERE productdetails_id ='$id'");
    $data = mysqli_fetch_array($query);
} else {
    echo "Product ID is not provided.";
    exit; 
}

if (isset($_POST['editBtn'])) {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    
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

            $updateQuery = mysqli_query($conn, "UPDATE productdetails SET description = '$description', price = '$price', image = '$imageName' WHERE productdetails_id = '$id'");
        }
    } else {
        $updateQuery = mysqli_query($conn, "UPDATE productdetails SET description = '$description', price = '$price' WHERE productdetails_id = '$id'");
    }

    if ($updateQuery) {
        header("Location: product-edit.php?id=$id");
        exit();
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST['deleteBtn'])) {
    $deleteQuery = mysqli_query($conn, "DELETE FROM productdetails WHERE productdetails_id = '$id'");
    if ($deleteQuery) {
        header("Location: product.php");
        exit();
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Product</title>
</head>

<body>

    <?php require "navbar.php"; ?>
    <div class="container mx-auto mt-8 flex justify-center">
        <div class="w-full md:w-1/2 bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-6">Edit Product</h2>
            <form action="" method="post" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"><?php echo htmlspecialchars($data['description']); ?></textarea>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" value="<?php echo $data['price']; ?>" id="price" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="flex items-center space-x-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <img src="../image/<?php echo $data['image'] ?>" alt="Product Image" width="100" class="rounded">
                    <input type="file" name="image" id="image" accept="image/*" class="block flex-grow px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="flex justify-end space-x-4">
                    <button name="editBtn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Edit</button>
                    <button name="deleteBtn" type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    <a href="product.php" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded">Back</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>