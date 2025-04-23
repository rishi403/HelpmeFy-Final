<?php
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';
require 'mail/Exception.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $name     = $_POST['name'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validation
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!preg_match('/^(?=.*[A-Z]).{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters and contain at least 1 uppercase letter.";
    }

    if (empty($errors)) {
       
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname     = "emergency_services";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if (!$stmt->execute()) {
            $errors[] = "Database Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

      
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
                $mail->Subject = 'Welcome to Helpmefy';
                $mail->Body = "
                    Hey $name!! 🌟 Greetings from Helpmefy! 🌟<br><br>
                    Thank you so much for connecting with us!<br>
                    We're truly grateful to have you as part of our helping community. ❤️<br>
                    No matter the need — big or small — we’re always here, ready to help you.<br>
                    Let’s make the world a kinder place, together. 🙌<br><br>
                    Team Helpmefy!!!<br>
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Helpmefy Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen bg-[image:url(login.jpg)]">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-purple-700">Signup to Helpmefy</h1>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <div>• <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="name" placeholder="Full Name" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-400">

            <input type="email" name="email" placeholder="Email Address" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-400">

            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-400">

            <input type="password" name="confirm" placeholder="Confirm Password" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-400">

            <button type="submit"
                    class="w-full bg-purple-600 text-white font-bold py-2 px-4 rounded hover:bg-purple-700 transition">
                Signup
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Already have an account? <a href="login.php" class="text-purple-600 hover:text-purple-800">Login</a>
        </p>
    </div>
</body>
</html>
