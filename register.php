<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simple Validation
    if (empty($name) || empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Name validation for special characters
        if (preg_match("/[^a-zA-Z\s]/", $name)) {
            $error_message = "Name should not contain special characters.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format.";
        } else {
            // If validation is successful, redirect to afterlogin.html
            header("Location: afterlogin.html");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpmefy SignUp</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST" action="register.php">
                <h1>Create An Account</h1>
                <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
                <span>Use your email for registration</span>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
