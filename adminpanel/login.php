<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customers WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Page</title>
</head>

<body>
    <section>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Login</h1>
                <input type="email" name="email" id="" placeholder="Enter your Email Address">
                <input type="password" name="password" id="" placeholder="Enter your Password">
                <button type="submit" name="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register here</a>!</p>
                <p><?php if(isset($error)) echo $error; ?></p>
            </form>
        </div>
    </section>
</body>

</html>
