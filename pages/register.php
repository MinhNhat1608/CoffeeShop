<?php
session_start();
include("../config/database.php");

$message = "";

if (empty($_SESSION['captcha_code'])) {
    $_SESSION['captcha_code'] = rand(10000, 99999);
}

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $captcha  = trim($_POST['captcha']);

    if ($username == "" || $password == "" || $captcha == "") {
        $message = "Vui lòng nhập đầy đủ thông tin";
    } elseif ($captcha != $_SESSION['captcha_code']) {
        $message = "Mã captcha không đúng";
        $_SESSION['captcha_code'] = rand(10000, 99999);
    } else {
        $checkQuery = "SELECT id FROM users WHERE username = ?";
        $stmtCheck = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmtCheck, "s", $username);
        mysqli_stmt_execute($stmtCheck);
        $checkResult = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($checkResult) > 0) {
            $message = "Tên đăng nhập đã tồn tại";
            $_SESSION['captcha_code'] = rand(10000, 99999);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insertQuery = "INSERT INTO users(username, password) VALUES(?, ?)";
            $stmtInsert = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmtInsert, "ss", $username, $hashedPassword);

            if (mysqli_stmt_execute($stmtInsert)) {
                $_SESSION['captcha_code'] = rand(10000, 99999);
                header("Location: /webbanhang/login.php");
                exit();
            } else {
                $message = "Đăng ký thất bại";
                $_SESSION['captcha_code'] = rand(10000, 99999);
            }
        }
    }
}

include("../includes/header.php");
?>

<style>
body {
    min-height: 100vh;
    padding-top: 120px;
    background:
        radial-gradient(circle at top left, rgba(184, 138, 88, 0.18), transparent 32%),
        radial-gradient(circle at bottom right, rgba(111, 78, 55, 0.16), transparent 30%),
        linear-gradient(135deg, #f8f2ea 0%, #efe2d2 50%, #f5ede4 100%);
    font-family: "Montserrat", sans-serif;
}

.register-wrapper {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    padding: 30px 20px 80px;
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 32px;
    align-items: stretch;
}

.register-hero {
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    padding: 48px 42px;
    min-height: 640px;
    background:
        linear-gradient(160deg, rgba(42, 28, 22, 0.88), rgba(85, 55, 38, 0.82)),
        url("../assets/images/banner_aboutus.jpg") center/cover no-repeat;
    box-shadow: 0 24px 50px rgba(62, 39, 35, 0.18);
    color: #fff7f0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.register-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(0,0,0,0.12));
    pointer-events: none;
}

.hero-top,
.hero-bottom {
    position: relative;
    z-index: 1;
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

.register-panel {
    background: rgba(255,255,255,0.95);
    border-radius: 28px;
    padding: 34px 30px 30px;
    box-shadow: 0 24px 50px rgba(62, 39, 35, 0.14);
    backdrop-filter: blur(10px);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.panel-header {
    text-align: center;
    margin-bottom: 22px;
}

.panel-title {
    margin: 0;
    color: #3E2723;
    font-size: 34px;
    font-weight: 800;
}

.panel-subtitle {
    margin: 10px 0 0;
    color: #7b685a;
    font-size: 15px;
    line-height: 1.7;
}

.message {
    margin-bottom: 18px;
    padding: 14px 16px;
    border-radius: 14px;
    background: linear-gradient(135deg, #fff3e8, #fce6d3);
    color: #b85b11;
    font-weight: 600;
    text-align: center;
    border: 1px solid rgba(184, 91, 17, 0.08);
}

.form-grid {
    display: grid;
    gap: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 9px;
    color: #3E2723;
    font-size: 14px;
    font-weight: 700;
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

.form-group input {
    width: 100%;
    height: 54px;
    border-radius: 16px;
    border: 1px solid #e2d6cb;
    background: #fff;
    padding: 0 16px 0 46px;
    font-size: 15px;
    outline: none;
    transition: 0.25s ease;
    box-sizing: border-box;
}

.form-group input:focus {
    border-color: #8b5e3c;
    box-shadow: 0 0 0 4px rgba(139, 94, 60, 0.10);
}

.captcha-box {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 12px;
    align-items: stretch;
}

.captcha-code {
    border-radius: 16px;
    background: linear-gradient(135deg, #f4e8dc, #ead9c7);
    border: 1px dashed #c7aa8c;
    color: #5b3c29;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: 4px;
    user-select: none;
    text-shadow: 1px 1px 0 rgba(255,255,255,0.55);
}

.register-btn {
    width: 100%;
    height: 56px;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, #a77449, #7b4f2f);
    color: white;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    transition: 0.25s ease;
    margin-top: 6px;
    box-shadow: 0 14px 26px rgba(123, 79, 47, 0.18);
}

.register-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 30px rgba(123, 79, 47, 0.22);
}

.register-note {
    margin-top: 18px;
    padding: 14px 16px;
    border-radius: 16px;
    background: #f8f2ec;
    color: #7b685a;
    font-size: 14px;
    line-height: 1.7;
    text-align: center;
}

.register-footer {
    text-align: center;
    margin-top: 18px;
    color: #6b5c52;
    font-size: 14px;
}

.register-footer a {
    color: #8b5e3c;
    text-decoration: none;
    font-weight: 800;
}

.register-footer a:hover {
    text-decoration: underline;
}

@media (max-width: 980px) {
    .register-wrapper {
        grid-template-columns: 1fr;
    }

    .register-hero {
        min-height: 480px;
    }
}

@media (max-width: 640px) {
    body {
        padding-top: 105px;
    }

    .register-wrapper {
        padding: 18px 14px 60px;
        gap: 20px;
    }

    .register-hero,
    .register-panel {
        border-radius: 22px;
        padding: 24px 20px;
    }

    .hero-title {
        font-size: 34px;
    }

    .hero-features {
        grid-template-columns: 1fr;
    }

    .captcha-box {
        grid-template-columns: 1fr;
    }

    .captcha-code {
        min-height: 54px;
    }

    .panel-title {
        font-size: 28px;
    }
}
</style>

<div class="register-wrapper">
    <div class="register-hero">
        <div class="hero-top">
            <div class="hero-badge">
                <span>☕</span>
                <span>Chào mừng đến với Coffee</span>
            </div>

            <h1 class="hero-title">Tạo tài khoản để bắt đầu hành trình thưởng thức cà phê theo cách riêng của bạn</h1>

            <p class="hero-desc">
                Đăng ký thành viên để mua sắm nhanh hơn, theo dõi đơn hàng dễ dàng và lưu lại những lựa chọn yêu thích của bạn tại cửa hàng.
            </p>
        </div>

        <div class="hero-bottom">
            <div class="hero-features">
                <div class="hero-feature">
                    <strong>Nhanh</strong>
                    <span>Đặt hàng chỉ trong vài bước đơn giản</span>
                </div>
                <div class="hero-feature">
                    <strong>Tiện</strong>
                    <span>Lưu thông tin tài khoản để đăng nhập dễ dàng</span>
                </div>
                <div class="hero-feature">
                    <strong>Mượt</strong>
                    <span>Trải nghiệm mua sắm hiện đại, gọn gàng</span>
                </div>
            </div>
        </div>
    </div>

    <div class="register-panel">
        <div class="panel-header">
            <h2 class="panel-title">Đăng ký tài khoản</h2>
            <p class="panel-subtitle">Tạo tài khoản mới để tiếp tục mua sắm và khám phá thêm nhiều sản phẩm hấp dẫn.</p>
        </div>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-user"></i>
                        <input
                            type="text"
                            name="username"
                            placeholder="Nhập tên đăng nhập"
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Mật khẩu</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            name="password"
                            placeholder="Nhập mật khẩu">
                    </div>
                </div>

                <div class="form-group">
                    <label>Mã captcha</label>
                    <div class="captcha-box">
                        <div class="captcha-code"><?php echo $_SESSION['captcha_code']; ?></div>
                        <div class="input-wrap">
                            <i class="fa-solid fa-shield-halved"></i>
                            <input
                                type="text"
                                name="captcha"
                                placeholder="Nhập mã xác nhận">
                        </div>
                    </div>
                </div>

                <button type="submit" name="register" class="register-btn">Tạo tài khoản</button>
            </div>
        </form>

        <div class="register-note">
            Bằng việc tạo tài khoản, bạn có thể đăng nhập nhanh hơn và tiếp tục hoàn tất đơn hàng thuận tiện hơn trên hệ thống.
        </div>

        <div class="register-footer">
            Đã có tài khoản? <a href="/webbanhang/login.php">Đăng nhập ngay</a>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>