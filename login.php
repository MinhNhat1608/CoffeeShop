<?php
session_start();
include("config/database.php");

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users 
              WHERE username='$username' 
              AND password='$password'";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        if ($user['role'] == 'admin') {
            $_SESSION['admin'] = $user['username'];
            header("Location: admin/index.php");
            exit();
        } else {
            $_SESSION['user'] = $user['username'];
            header("Location: index.php");
            exit();
        }
    } else {
        $error = "Đăng nhập thất bại! Sai tài khoản hoặc mật khẩu.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: Montserrat;
            background: #f5f5f5;
        }

        .login-section {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            padding: 40px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #6f4e37;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #4b3224;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #6f4e37;
            text-decoration: none;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>

</head>

<body>
    <section class="login-section">
        <div class="login-box">
            <h2>Login</h2>
            <?php
            if (isset($error)) {
                echo "<div class='error'>$error</div>";
            }
            ?>

            <form method="post">
                <div class="input-group">
                    <label>Email or Username</label>
                    <input type="text" name="username" placeholder="Enter email or username" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" name="login" class="login-btn">
                    <i class="fa fa-sign-in-alt"></i>
                    Login
                </button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="/webbanhang/pages/register.php">Register</a>
            </div>
        </div>
    </section>
</body>

</html>