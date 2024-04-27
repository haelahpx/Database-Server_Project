<?php
include '../config.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit;
}

$totalcategory = 0;
$querycategory = mysqli_query($conn, "SELECT * FROM category");
if ($querycategory) {
    $totalcategory = mysqli_num_rows($querycategory);
}

$totalproduct = 0;
$queryproduct = mysqli_query($conn, "SELECT * FROM product");
if ($queryproduct) {
    $totalproduct = mysqli_num_rows($queryproduct);
}

$queryCustomers = mysqli_query($conn, "SELECT * FROM customers");

$queryOrderDetails = mysqli_query($conn, "SELECT product_id, COUNT(*) as total FROM orderdetails GROUP BY product_id");

$productChartData = [];

while ($row = mysqli_fetch_assoc($queryOrderDetails)) {
    $productChartData[] = [
        'product_id' => $row['product_id'],
        'total' => $row['total']
    ];
}

$productChartDataJson = json_encode($productChartData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php require "navbar.php"; ?>

    <div class="p-12">
        <div class="md:pl-64 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-200 rounded-lg p-6 shadow-md">
                <a href="category.php" class="text-xl font-bold text-gray-800 hover:text-blue-600">Category</a>
                <p class="text-gray-600"><?php echo $totalcategory ?> categories</p>
                <a href="category.php" class="text-gray-600 hover:text-blue-600">Details</a>
            </div>
            <div class="bg-gray-200 rounded-lg p-6 shadow-md">
                <h1 class="text-xl font-bold text-gray-800">Product</h1>
                <p class="text-gray-600"><?php echo $totalproduct ?> products</p>
                <a href="product.php" class="text-gray-600 hover:text-blue-600">Details</a>
            </div>
        </div>
        <div class="md:pl-64 grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="bg-gray-200 rounded-lg p-6 shadow-md">
                <h1 class="text-xl font-bold text-gray-800">Buy</h1>
                <p class="text-gray-600"><?php echo $totalproduct ?> products</p>
                <a href="product.php" class="text-gray-600 hover:text-blue-600">Details</a>
            </div>
            <div class="bg-gray-200 rounded-lg p-6 shadow-md">
                <h1 class="text-xl font-bold text-gray-800">Customer</h1>
                <p class="text-gray-600"><?php echo mysqli_num_rows($queryCustomers) ?> customers</p>
                <a href="customer.php" class="text-gray-600 hover:text-blue-600">Details</a>
            </div>
        </div>

        <div class="md:pl-64 mt-6">
            <h1 class="text-3xl font-bold text-gray-800 my-6 pl-6">Customer Table</h1>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-3 uppercase font-semibold text-sm">Customer ID</th>
                            <th class="px-4 py-3 uppercase font-semibold text-sm">Username</th>
                            <th class="px-4 py-3 uppercase font-semibold text-sm">First Name</th>
                            <th class="px-4 py-3 uppercase font-semibold text-sm">Last Name</th>
                            <th class="px-4 py-3 uppercase font-semibold text-sm">Email</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryCustomers)) {
                            echo "<tr>";
                            echo "<td class='border-t px-4 py-3'>" . $row['customer_id'] . "</td>";
                            echo "<td class='border-t px-4 py-3'>" . $row['username'] . "</td>";
                            echo "<td class='border-t px-4 py-3'>" . $row['first_name'] . "</td>";
                            echo "<td class='border-t px-4 py-3'>" . $row['last_name'] . "</td>";
                            echo "<td class='border-t px-4 py-3'>" . $row['email'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="md:pl-64 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Product Chart</h1>
                <canvas id="productChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Product Pie Chart</h1>
                <canvas id="productPieChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var productChartData = <?php echo $productChartDataJson; ?>;
        var labels = [];
        var data = [];
        productChartData.forEach(function(item) {
            labels.push(item.product_id);
            data.push(item.total);
        });
        var ctx = document.getElementById('productChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Product',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        var pieCtx = document.getElementById('productPieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Product',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>