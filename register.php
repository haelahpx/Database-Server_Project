<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital@1&family=Roboto:ital,wght@0,300;0,500;1,400&family=VT323&display=swap" rel="stylesheet">
</head>

<body class="flex items-center font-[VT323] bg-[url('../images/gray.jpg')] bg-no-repeat bg-cover select-none">
    <section class="w-full h-screen flex justify-center">
        <div class="flex flex-col-reverse md:flex-row items-center justify-center md:w-[80%] xl:w-[60%]">
            <div class="md:w-[50%] flex justify-center">
                <img src="image/loginreg.png" class="w-full" alt="Phone image" />
            </div>
            <div class="md:w-[50%] px-[4rem] py-[3rem] bg-transparent backdrop-blur-lg rounded-lg flex flex-col items-center justify-center space-y-4">
                <form action="" method="post" class="flex flex-col items-center justify-center space-y-4">
                    <?php
                    if (isset($error)) {
                        foreach ($error as $error) {
                            echo '<span class="error-msg">' . $error . '</span>';
                        }
                    }
                    ?>
                    <h1 class="font-bold text-[2.5rem] px-4">Register</h1>
                    <input type="text" name="username" placeholder="Enter your Username" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-[20rem]">
                    <input type="text" name="first_name" placeholder="Enter your First Name" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-[20rem]">
                    <input type="text" name="last_name" placeholder="Enter your Last Name" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-[20rem]">
                    <input type="email" name="email" placeholder="Enter your Email Address" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-[20rem]">
                    <input type="password" name="password" placeholder="Enter your Password" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-[20rem]">
                    <input type="password" name="cpassword" placeholder="Confirm your Password" class="border-2 rounded-full px-4 py-2 text-[1.2rem] w-[20rem]">
                    <div class="pilih">
                        <select name="user_type" class="invisible">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button name="submit" class="border-2 border-gray-100 rounded-lg px-2 py-2 w-[14rem] hover:scale-110 transition-all duration-300 hover:text-white hover:bg-blue-400">Register</button>
                    <p>Already have an account? <a href="login.php" class="text-blue-400">Login here</a>!</p>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
