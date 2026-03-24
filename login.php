<?php
session_start();
include("config/database.php");

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $isValidPassword = false;

                if (password_verify($password, $user['password'])) {
                    $isValidPassword = true;
                } elseif ($password === $user['password']) {
                    $isValidPassword = true;

                    $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                    $stmtUpdate = mysqli_prepare($conn, $updateQuery);

                    if ($stmtUpdate) {
                        mysqli_stmt_bind_param($stmtUpdate, "si", $newHashedPassword, $user['id']);
                        mysqli_stmt_execute($stmtUpdate);
                    }
                }

                if ($isValidPassword) {
                    $_SESSION['user_id'] = $user['id'];

                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => isset($user['role']) ? $user['role'] : 'user'
                    ];

                    if (isset($user['role']) && $user['role'] === 'admin') {
                        $_SESSION['admin'] = $user['username'];
                        header("Location: /webbanhang/admin/index.php");
                        exit();
                    } else {
                        header("Location: /webbanhang/index.php");
                        exit();
                    }
                } else {
                    $error = "Sai tên đăng nhập hoặc mật khẩu.";
                }
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu.";
            }
        } else {
            $error = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Montserrat", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(184, 138, 88, 0.20), transparent 30%),
                radial-gradient(circle at bottom right, rgba(111, 78, 55, 0.18), transparent 28%),
                linear-gradient(135deg, #f7f0e8 0%, #efe2d2 50%, #f6ede4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-page {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            gap: 28px;
            align-items: stretch;
        }

        .login-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            min-height: 640px;
            padding: 46px 40px;
            background:
                linear-gradient(160deg, rgba(42, 28, 22, 0.88), rgba(85, 55, 38, 0.82)),
                url("/webbanhang/assets/images/banner_aboutus.jpg") center/cover no-repeat;
            color: #fff7f0;
            box-shadow: 0 24px 50px rgba(62, 39, 35, 0.18);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(8px);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .hero-title {
            margin: 0 0 16px;
            font-size: 46px;
            line-height: 1.15;
            font-weight: 800;
            max-width: 520px;
        }

        .hero-desc {
            margin: 0;
            max-width: 520px;
            color: rgba(255,247,240,0.88);
            font-size: 16px;
            line-height: 1.8;
        }

        .hero-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 28px;
        }

        .hero-feature {
            padding: 16px 14px;
            border-radius: 18px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.10);
            backdrop-filter: blur(8px);
        }

        .hero-feature strong {
            display: block;
            font-size: 20px;
            margin-bottom: 6px;
        }

        .hero-feature span {
            font-size: 13px;
            color: rgba(255,247,240,0.85);
        }

        .login-box {
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 28px;
            padding: 34px 30px 30px;
            box-shadow: 0 24px 50px rgba(62, 39, 35, 0.14);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-box h2 {
            text-align: center;
            margin: 0 0 10px;
            color: #3E2723;
            font-size: 34px;
            font-weight: 800;
        }

        .login-subtitle {
            text-align: center;
            color: #7a6a5f;
            margin-bottom: 24px;
            font-size: 15px;
            line-height: 1.7;
        }

        .error {
            color: #d35400;
            text-align: center;
            margin-bottom: 18px;
            background: linear-gradient(135deg, #fff3e8, #fce6d3);
            padding: 12px 14px;
            border-radius: 14px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: 700;
            color: #3E2723;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9b826f;
            font-size: 15px;
        }

        .input-group input {
            width: 100%;
            height: 54px;
            border: 1px solid #e2d6cb;
            border-radius: 16px;
            outline: none;
            font-size: 15px;
            background: #fff;
            padding: 0 16px 0 46px;
            transition: 0.25s ease;
        }

        .input-group input:focus {
            border-color: #8b5e3c;
            box-shadow: 0 0 0 4px rgba(139, 94, 60, 0.10);
        }

        .login-btn {
            width: 100%;
            height: 56px;
            background: linear-gradient(135deg, #a77449, #7b4f2f);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.25s ease;
            margin-top: 6px;
            box-shadow: 0 14px 26px rgba(123, 79, 47, 0.18);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 30px rgba(123, 79, 47, 0.22);
        }

        .register-link {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: #6b5c52;
        }

        .register-link a {
            color: #8b5e3c;
            text-decoration: none;
            font-weight: 800;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .login-note {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #f8f2ec;
            color: #7b685a;
            font-size: 14px;
            line-height: 1.7;
            text-align: center;
        }

        @media (max-width: 980px) {
            .login-page {
                grid-template-columns: 1fr;
            }

            .login-hero {
                min-height: 460px;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 14px;
            }

            .login-hero,
            .login-box {
                border-radius: 22px;
                padding: 24px 20px;
            }

            .hero-title {
                font-size: 34px;
            }

            .hero-features {
                grid-template-columns: 1fr;
            }

            .login-box h2 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <div class="login-hero">
            <div>
                <div class="hero-badge">
                    <span>☕</span>
                    <span>Welcome back to Coffee</span>
                </div>

                <h1 class="hero-title">Đăng nhập để tiếp tục hành trình thưởng thức cà phê của bạn</h1>

                <p class="hero-desc">
                    Truy cập tài khoản để theo dõi đơn hàng, mua sắm nhanh hơn và lưu lại những lựa chọn yêu thích tại cửa hàng.
                </p>
            </div>

            <div class="hero-features">
                <div class="hero-feature">
                    <strong>Nhanh</strong>
                    <span>Đăng nhập gọn gàng chỉ với vài thao tác</span>
                </div>
                <div class="hero-feature">
                    <strong>Tiện</strong>
                    <span>Dễ theo dõi đơn hàng và lịch sử mua sắm</span>
                </div>
                <div class="hero-feature">
                    <strong>An toàn</strong>
                    <span>Tự động nâng cấp tài khoản cũ lên bảo mật mới</span>
                </div>
            </div>
        </div>

        <div class="login-box">
            <h2>Đăng nhập</h2>
            <div class="login-subtitle">Chào mừng bạn quay lại với CoFFee</div>

            <?php if ($error != "") { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>

            <form method="post">
                <div class="input-group">
                    <label>Tên đăng nhập</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-user"></i>
                        <input
                            type="text"
                            name="username"
                            placeholder="Nhập tên đăng nhập"
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                            required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Mật khẩu</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            name="password"
                            placeholder="Nhập mật khẩu"
                            required>
                    </div>
                </div>

                <button type="submit" name="login" class="login-btn">
                    <i class="fa fa-sign-in-alt"></i>
                    Đăng nhập
                </button>
            </form>

            <div class="login-note">
                Sau khi đăng nhập, bạn có thể xem đơn hàng, tiếp tục thanh toán và quản lý tài khoản dễ dàng hơn.
            </div>

            <div class="register-link">
                Chưa có tài khoản? <a href="/webbanhang/pages/register.php">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</body>

</html>