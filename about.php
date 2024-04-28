<?php
include "config.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItSeven - Top Up Game, E-Wallet, and More</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    body {
        background: #272730;
    }
</style>


<body>
    <?php require "navbar.php"; ?>





    <div class="mx-auto max-w-7xl px-4 md:px-8 lg:px-10 pt-2 md:pt-8 lg:pt-10 pb-16 flex flex-col gap-12 md:gap-16 lg:gap-20">
        <div class="flex flex-col">

            <style data-emotion="css scrciq">
                .css-scrciq {
                    border: 1px solid rgba(203, 203, 203, 0.5);
                    background: linear-gradient(163.42deg, #32323e -50%, #ffffff00 105.46%);
                }
            </style>
            <div class="rounded-2xl css-scrciq px-6">

                <div class="container mx-auto px-4 py-8">
                    <div class="flex items-center justify-center h-full">
                        <div class="w-full max-w-2xl">
                            <h1 class="text-3xl font-bold mb-4 text-center">Welcome to <span class="text-green-500">ItSeven</span></h1>
                            <p class="text-lg mb-6 text-center">ItSeven is an online store that offers various services such as top up for games, e-wallets, and much more.</p>
                            <p class="text-lg mb-6 text-center">We provide convenience in transactions to meet your gaming and digital payment needs.</p>
                            <h2 class="text-2xl font-bold mb-4 text-center">About Us</h2>
                            <p class="text-lg mb-6 text-center">This website was created as a college project by our group consisting of:</p>
                            <ul class=" ml-8 text-lg mb-6 text-center">
                                <li>Muhammad Haikal Islami</li>
                                <li>Haskal Dellas Moedja</li>
                                <li>Samuel Adoman Manalu</li>
                                <li>Fikhar Gifari</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 md:px-8 lg:px-10 pt-2 md:pt-8 lg:pt-10 pb-16 flex flex-col gap-12 md:gap-16 lg:gap-20">
        <div class="flex flex-col">

            <style data-emotion="css scrciq">
                .css-scrciq {
                    border: 1px solid rgba(203, 203, 203, 0.5);
                    background: #32323e;
                    color: #e6e6e6
                }
            </style>
            <div class="rounded-2xl css-scrciq px-6">
                <div class="flex flex-col">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3 md:gap-8 lg:gap-10 p-6 border-b border-[#626274]">
                        <p class="text-justify leading-7">A group of students from President University received a project assignment and we decided to choose a topup website theme. Itseven is
                            a website that provides game top up services for game players with
                            unique features such as a secure payment system, fast top up process,
                            and responsive customer service.</p>
                        <p class="text-justify leading-7">Itseven has a collaboration network with
                            various game publishers, making it easier for game players to top up for
                            these games. This business continues to grow and expand its reach,
                            and in 2021 it will become one of the leading game top up websites in
                            Indonesia. Customers can top up games easily and safely.
                            The business continually strives to improve its services by adding
                            new features such as top up via mobile application and integration with
                            several leading game publishers.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
                        <div class="p-6 flex lg:flex-row md:flex-row flex-col border-b lg:border-b-0 md:border-b-0 md:border-r lg:border-r border-[#626274] gap-3 items-start">
                            <img src="image/visi.png" alt="icon-visi" width="60" height="60" />
                            <div class="flex flex-col gap-3">
                                <h3 class="text-[20px] font-semibold">Visi</h3>
                                <p class="leading-7">Become the leading game top up service and
                                    trusted for game players all over the world.</p>
                            </div>
                        </div>
                        <div class="p-6 flex lg:flex-row md:flex-row flex-col gap-3 items-start"><img src="image/misi.png" alt="icon-misi" width="60" height="60" />
                            <div class="flex flex-col gap-3">
                                <h3 class="text-[20px] font-semibold ">Misi</h3>
                                <p class="leading-7">Providing fast, easy, game top up services
                                    and safe for gamers with responsive customer service
                                    and satisfying.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 css-scrciq rounded-2xl">
            <div class="p-6 flex lg:flex-row md:flex-row flex-col border-b lg:border-b-0 md:border-b-0 md:border-r lg:border-r border-[#626274] gap-3 items-start">
                <img src="image/alamat.png.png" alt="icon-visi" width="60" height="60" />
                <div class="flex flex-col gap-3">
                    <p class="leading-7"><strong>PRESIDENT UNIVERSITY</strong> <br /> Jababeka Education Park, Jl. Ki Hajar Dewantara, RT.2/RW.4 <br /> Mekarmukti, Cikarang Utara, Bekasi Regency, West Java 17530 <br /> <!-- -->TELEPHONE: 089 1111
                        0000</p>
                </div>
            </div>
            <div class="p-6 flex lg:flex-row md:flex-row flex-col gap-3 items-center justify-center">
                <div class="flex gap-3">
                    <i class="fa fa-instagram text-9xl text-gray-500 hover:text-gray-700 transition duration-300"></i>
                    <i class="fa fa-facebook text-9xl text-gray-500 hover:text-gray-700 transition duration-300"></i>
                </div>
                <div class="flex gap-3">
                    <i class="fa fa-twitter text-9xl text-gray-500 hover:text-gray-700 transition duration-300"></i>
                    <i class="fa fa-youtube text-9xl text-gray-500 hover:text-gray-700 transition duration-300"></i>
                </div>
            </div>
        </div>

    </div>




</body>
<?php require "footer.php"; ?>

</html>