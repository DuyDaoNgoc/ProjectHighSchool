<?php include '../DATABASE/datatuvan.php' ?>
<div class="consultation-container">
    <h1 class="consultation-title">Đăng ký tư vấn</h1>
    <div id="messageBox"></div>
    <div class="background-tu-van">
        <form id="consultationForm" class="consultation-form">
            <div class="form-group">
                <label for="ho_ten" class="form-label">Họ tên:</label>
                <input type="text" name="ho_ten" id="ho_ten" class="form-input">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-input">
            </div>
            <div class="form-group">
                <label for="so_dien_thoai" class="form-label">Số điện thoại:</label>
                <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="form-input">
            </div>
            <div class="form-group">
                <label for="que_quan" class="form-label">Quê quán:</label>
                <input type="text" name="que_quan" id="que_quan" class="form-input">
            </div>
            <div class="form-group">
                <label for="nganh_quan_tam" class="form-label">Ngành quan tâm:</label>
                <select name="nganh_quan_tam" id="nganh_quan_tam" class="form-select">
                    <option value="">-- Chọn ngành --</option>
                    <?php foreach ($course_options as $course): ?>
                    <option value="<?php echo htmlspecialchars($course); ?>">
                        <?php echo htmlspecialchars($course); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Đăng ký" class="btn-submit">
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById("consultationForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn trang reload

    let ho_ten = document.getElementById("ho_ten").value.trim();
    let email = document.getElementById("email").value.trim();
    let so_dien_thoai = document.getElementById("so_dien_thoai").value.trim();
    let que_quan = document.getElementById("que_quan").value.trim();
    let nganh_quan_tam = document.getElementById("nganh_quan_tam").value.trim();

    // Kiểm tra xem có trường nào bị bỏ trống không
    if (!ho_ten || !email || !so_dien_thoai || !que_quan || !nganh_quan_tam) {
        document.getElementById("messageBox").innerHTML =
            "<div class='form-message error'>Vui lòng điền đầy đủ thông tin.</div>";
        return;
    } else {
        document.getElementById("messageBox").innerHTML =
            "<div class='orm-message success'>Đăng ký tư vấn thành công.</div>";
        return;
    }

    let formData = new FormData(this);

    fetch("../DATABASE/datatuvan.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("messageBox").innerHTML = data;
            if (data.includes("success")) {
                document.getElementById("consultationForm").reset();
            }
        })
        .catch(error => {
            document.getElementById("messageBox").innerHTML =
                "<div class='form-message error'>Lỗi: Không thể gửi dữ liệu.</div>";
        });
});
</script>