<?php
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';
require 'mail/Exception.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    
    if (empty($email) || empty($password)) {
        $errors[] = "Email and Password are required.";
    }

   
    if (empty($errors)) {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rishikesh403pat@gmail.com';
            $mail->Password   = 'aqhd shox jfvg zaug'; // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('rishikesh403pat@gmail.com', 'Helpmefy');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome Back to Helpmefy';
            $mail->Body    = "Hey user!! 🌟 Greetings from Helpmefy! 🌟
Thank you so much for connecting with us!
We're truly grateful to have you as part of our helping community. ❤️
No matter the need — big or small — we’re always here, ready to help you.
Let’s make the world a kinder place, together. 🙌

#StaySafe #StayConnected #HelpmefyCares

";

            $mail->send();

            header("Location: afterlogin.html");
            exit();
        } catch (Exception $e) {
            $errors[] = "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Helpmefy Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen bg-[image:url(login.jpg)]">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-purple-700">Login to Helpmefy</h1>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <div>• <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email Address" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-400">

            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-400">

            <button type="submit"
                    class="w-full bg-purple-600 text-white font-bold py-2 px-4 rounded hover:bg-purple-700 transition">
                Login
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            New to Helpmefy? <a href="signup.php" class="text-purple-600 hover:text-purple-800">Signup here</a>
        </p>
    </div>
</body>
</html>
