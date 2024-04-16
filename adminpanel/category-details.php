<?php
session_start();
require "../config.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM category WHERE category_id ='$id'");
$data = mysqli_fetch_array($query);
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


    <div class="container mx-auto mt-8 flex justify-center">
        <div class="w-full md:w-1/2 bg-white rounded-lg shadow-md p-4">
            <h2 class="text-xl font-bold mb-4 ml-0">Details Category</h2>
            <form action="" method="post" class="space-y-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" value="<?php echo $data['category_name'] ?>" id="category" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <button name="editBtn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                    <button name="deleteBtn" type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    <a href="category.php" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Back</a>
                </div>
            </form>
            <?php
            if (isset($_POST['editBtn'])) {
                $category = htmlspecialchars($_POST['category']);

                if ($data['category_name'] == $category) {
            ?>
                    <meta http-equiv="refresh" content="0; url=category.php" />
                    <?php
                } else {
                    $query = mysqli_query($conn, "SELECT * FROM category WHERE category_name ='$category'");

                    $totalData = mysqli_num_rows($query);

                    if ($totalData > 0) {
                    ?>
                        <div id="warningAlert" class="flex items-center mt-3 p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Warning alert!</span> The data you entered is already available.
                            </div>
                        </div>
                        <?php
                    } else {
                        $saveQuery = mysqli_query($conn, "UPDATE category SET category_name = '$category' WHERE category_id = '$id'");

                        if ($saveQuery) {
                        ?>
                            <div id="successAlert" class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">Success alert!</span> The data you entered has been updated.
                                </div>
                                <meta http-equiv="refresh" content="1; url=category.php" />
                            </div>
                            <?php
                        } else {
                            echo mysqli_error($conn);
                        }
                    }
                }
            }

            if (isset($_POST['deleteBtn'])) {
                // Retrieve category_id from product table using product_id from productdetails table
                $categoryIdQuery = mysqli_query($conn, "SELECT c.category_id, p.product_id, pd.productdetails_id 
                FROM product p 
                LEFT JOIN productdetails pd ON p.product_id = pd.product_id 
                JOIN category c ON p.category_id = c.category_id 
                WHERE c.category_id = $id;
                ");
                
                if ($categoryIdQuery) {
                    if(mysqli_num_rows($categoryIdQuery) > 0) {
                        $categoryIdRow = mysqli_fetch_assoc($categoryIdQuery);
            
                        $deleteProductDetailsQuery = mysqli_query($conn, "DELETE FROM productdetails WHERE product_id = '$id'");
            
                        if ($deleteProductDetailsQuery) {
                            $deleteProductsQuery = mysqli_query($conn, "DELETE FROM product WHERE category_id = '{$categoryIdRow['category_id']}'");

            
                            if ($deleteProductsQuery) {
                                $deleteCategoryQuery = mysqli_query($conn, "DELETE FROM category WHERE category_id = '$id'");
            
                                if ($deleteCategoryQuery) {
                                    ?>
                                    <div class="flex items-center p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-medium">Delete alert!</span> Category and associated products have been deleted.
                                        </div>
                                        <meta http-equiv="refresh" content="1; url=category.php" />
                                    </div>
                                    <?php
                                } else {
                                    echo mysqli_error($conn);
                                }
                            } else {
                                echo mysqli_error($conn);
                            }
                        } else {
                            echo mysqli_error($conn);
                        }
                    } else {
                        echo "No category found for the given product ID.";
                    }
                } else {
                    echo mysqli_error($conn);
                }
            }
            
            
            
            ?>


        </div>
    </div>

</body>

</html>