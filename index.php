<?php include("includes/header.php"); ?>
<?php include("config/database.php"); ?>

<?php
$sql_featured = "
    SELECT p.*, c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE p.name IN ('Espresso', 'Trà Đào Cam Sả', 'Tiramisu')
    ORDER BY FIELD(p.name, 'Espresso', 'Trà Đào Cam Sả', 'Tiramisu')
    LIMIT 3
";
$result_featured = mysqli_query($conn, $sql_featured);
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-subtitle">
                <i class="fas fa-seedling"></i>
                Hạt cà phê tuyển chọn
            </div>
            <h1 class="hero-title">Cà phê thủ công <br><span>Đậm vị từ tâm huyết</span></h1>
            <p class="hero-text">
                Khám phá những dòng cà phê nguyên bản được rang theo từng mẻ nhỏ,
                chăm chút để giữ trọn hương vị tinh tế. Từ hạt cà phê nơi nông trại
                đến tách cà phê trên tay bạn, mọi công đoạn đều được nâng niu bởi
                những nghệ nhân rang xay giàu kinh nghiệm.
            </p>
            <div class="hero-buttons">
                <a href="/webbanhang/pages/products.php" class="btn btn-primary">Khám phá sản phẩm</a>
                <a href="/webbanhang/pages/posts.php" class="btn btn-secondary">Góc chuyện cà phê</a>
            </div>
        </div>
        <img src="../webbanhang/assets/images/1.jpg" alt="Cà phê thủ công" width="370px">
    </div>
</section>

<section class="products" id="products">
    <div class="container">
        <div class="section-header">
            <div class="section-subtitle">Tuyển chọn nổi bật</div>
            <h2 class="section-title">Những sản phẩm đặc trưng</h2>
            <p class="section-desc">
                Những món được yêu thích và mang dấu ấn riêng của quán, hài hòa từ hương vị đến trải nghiệm.
            </p>
        </div>

        <div class="product-grid">
            <?php while($row = mysqli_fetch_assoc($result_featured)) { ?>
                <div class="product-card">
                    <div class="product-img">
                        <img src="../webbanhang/assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    </div>
                    <div class="product-info">
                        <?php if($row['name'] == 'Espresso') { ?>
                            <div class="product-tag">BÁN CHẠY</div>
                        <?php } elseif($row['name'] == 'Trà Đào Cam Sả') { ?>
                            <div class="product-tag">YÊU THÍCH</div>
                        <?php } elseif($row['name'] == 'Tiramisu') { ?>
                            <div class="product-tag">NỔI BẬT</div>
                        <?php } ?>

                        <h3 class="product-title"><?php echo $row['name']; ?></h3>
                        <p class="product-desc"><?php echo $row['description']; ?></p>

                        <div class="product-footer">
                            <div class="product-price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>