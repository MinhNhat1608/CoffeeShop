<?php include("../includes/header.php"); ?>

<style>
    body {
        background: #f5efe6;
        font-family: Arial, sans-serif;
    }

    .banner {
        position: relative;
        height: 400px;
        border-radius: 15px;
        overflow: hidden;
        margin: 30px;
    }

    .banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-text {
        position: absolute;
        bottom: 30px;
        left: 40px;
        color: white;
        font-size: 32px;
        font-weight: bold;
        max-width: 600px;
    }

    .section {
        max-width: 1100px;
        margin: 50px auto;
        padding: 20px;
    }

    .about {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .about img {
        width: 400px;
        border-radius: 15px;
    }

    .about-text h2 {
        color: #3E2723;
    }

    .about-text ul {
        margin-top: 10px;
    }

    .card-container {
        display: flex;
        gap: 20px;
        justify-content: space-between;
    }

    .card {
        background: #8B5E3C;
        color: white;
        padding: 20px;
        border-radius: 15px;
        width: 32%;
        text-align: center;
    }

    .card img {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .team {
        text-align: center;
    }

    .team-container {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .member {
        width: 23%;
    }

    .member img {
        width: 100%;
        border-radius: 15px;
    }

    .member h4 {
        margin: 10px 0 5px;
    }
</style>

<div class="banner">
    <img src="../assets/images/banner_aboutus.jpg">
    <div class="banner-text">
        Câu Chuyện Của Chúng Tôi: Từ Nông Trại Đến Tách Cà Phê
    </div>
</div>

<div class="section about">
    <div class="about-text">
        <h2>Về Chúng Tôi</h2>
        <p>
            Chúng tôi được sinh ra từ niềm đam mê mãnh liệt với cà phê nguyên chất
            và mong muốn mang đến cho khách hàng những trải nghiệm chân thật nhất trong từng tách cà phê.
            Chúng tôi tin rằng, một ly cà phê ngon không chỉ đến từ kỹ thuật pha chế, mà còn bắt đầu từ chính
            vùng đất nơi hạt cà phê được trồng.</p>
        <p>
            Chúng tôi hợp tác trực tiếp với các nông hộ tại Tây Nguyên – nơi có điều kiện khí hậu và thổ nhưỡng
            lý tưởng để tạo ra những hạt cà phê chất lượng cao. Từng hạt cà phê đều được chọn lọc kỹ lưỡng,
            rang xay theo phương pháp truyền thống kết hợp công nghệ hiện đại để giữ trọn hương vị tự nhiên.
        </p><br />

        <p><b>Sứ mệnh của chúng tôi:</b></p>
        <ul>
            <li>Đưa cà phê sạch và nguyên chất đến gần hơn với người tiêu dùng</li>
            <li>Xây dựng chuỗi giá trị bền vững từ nông trại đến bàn uống</li>
            <li>Hỗ trợ và phát triển cộng đồng nông dân địa phương</li>
            <li>Tạo ra trải nghiệm cà phê đáng nhớ cho mỗi khách hàng</li>
        </ul><br />

        <p><b>Giá trị cốt lõi:</b></p>
        <ul>
            <li><b>Chất lượng:</b> Cam kết 100% cà phê nguyên chất</li>
            <li><b>Bền vững:</b> Sản xuất thân thiện với môi trường</li>
            <li><b>Đam mê:</b> Không ngừng sáng tạo và cải tiến</li>
            <li><b>Kết nối:</b> Gắn kết con người thông qua cà phê</li>
        </ul>
    </div>

    <img src="../assets/images/about1.jpg">
</div>

<div class="section">
    <h2 style="text-align:center;">Hành Trình Gắn Kết</h2>

    <div class="card-container">
        <div class="card">
            <img src="../assets/images/card1.jpg">
            <h3>Sứ Mệnh & Tầm Nhìn</h3>
            <p>Chúng tôi hướng đến việc trở thành thương hiệu cà phê đáng tin cậy,
                mang đến sản phẩm chất lượng cao và lan tỏa văn hóa cà phê Việt Nam
                đến với mọi người.</p>
        </div>

        <div class="card">
            <img src="../assets/images/card2.jpg">
            <h3>Cam Kết Chất Lượng</h3>
            <p>Tất cả sản phẩm đều được chọn lọc kỹ lưỡng, rang xay theo tiêu chuẩn cao,
                không sử dụng chất phụ gia hay chất bảo quản, đảm bảo giữ nguyên hương vị tự nhiên.</p>
        </div>

        <div class="card">
            <img src="../assets/images/card3.jpg">
            <h3>Nông Trại & Nông Dân</h3>
            <p>Chúng tôi đồng hành cùng nông dân địa phương, hỗ trợ kỹ thuật canh tác
                và đảm bảo đầu ra ổn định, góp phần nâng cao đời sống và phát triển bền vững.</p>
        </div>
    </div>
</div>

<div class="section team">
    <h2>Đội Ngũ Đam Mê</h2>

    <div class="team-container">
        <div class="member">
            <img src="../assets/images/team.jpg">
            <h4>Nhật (Rang xay)</h4>
            <p>Chuyên gia rang xay cà phê.</p>
        </div>

        <div class="member">
            <img src="../assets/images/team.jpg">
            <h4>Phúc (Vận hành)</h4>
            <p>Quản lý chất lượng.</p>
        </div>

        <div class="member">
            <img src="../assets/images/team.jpg">
            <h4>Lộc (Cộng đồng)</h4>
            <p>Kết nối cộng đồng.</p>
        </div>

        <div class="member">
            <img src="../assets/images/team.jpg">
            <h4>Thức (Barista)</h4>
            <p>Nghệ nhân pha chế.</p>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>