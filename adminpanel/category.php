<?php
session_start();
require "../config.php";

$sql = "SELECT * FROM category";
$result = $conn->query($sql);

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
        <h1 class="text-3xl font-bold text-gray-800 my-6">List Category</h1>
        <div class="overflow-hidden shadow-md rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        $number = 1;
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4"><?= $number ?></td>
                                <td class="py-3 px-4"><?= $row["category_name"] ?></td>
                                <td class="py-3 px-4">
                                    <a href="category-details.php?id=<?= $row['category_id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline-block align-middle mr-2">
                                            <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z" clip-rule="evenodd" />
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>


                        <?php
                            $number++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='3' class='text-center py-4'>There is no category data in the database</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="max-w-4xl mx-auto pt-4">
        <div class="bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-bold mb-4 text-gray-800 px-6 py-4 border-b border-gray-200">Add Category</h3>
            <form action="" method="post" class="space-y-4 px-6 py-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="category" name="category" placeholder="Input Category Name" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200" required/>
                </div>
                <div>
                    <button type="submit" name="save" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
                </div>
            </form>
            <?php


            if (isset($_POST['save'])) {
                $category = htmlspecialchars($_POST['category']);

                $queryExist = mysqli_query($conn, "SELECT category_name FROM category WHERE category_name='$category'");

                $totalNewCategory = mysqli_num_rows($queryExist);


                if ($totalNewCategory > 0) {
            ?>
                    <div id="warningAlert" class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
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
                    $saveQuery = mysqli_query($conn, "INSERT INTO category (category_name) VALUES ('$category')");

                    if ($saveQuery) {
                    ?>
                        <div id="successAlert" class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Success alert!</span> The data you entered has been added.
                            </div>
                            <meta http-equiv="refresh" content="1; url=category.php" />
                        </div>
            <?php
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