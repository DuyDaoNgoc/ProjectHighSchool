<?php include_once '../DATABASE/DataCouser.php'; ?>

<?php

$demDaiHoc = count(array_filter($courses, function($course) {
    return $course['cap_hoc'] === 'Đại học';
}));
$demThacSi = count(array_filter($courses, function($course) {
    return $course['cap_hoc'] === 'Thạc sĩ';
}));
$demTienSi = count(array_filter($courses, function($course) {
    return $course['cap_hoc'] === 'Tiến sĩ';
}));
?>

<nav class="style-container">
    <h1 class="bold">Chương trình đào tạo</h1>
    <ul class="tabs2">
        <li data-tab="daihoc" class="active">Đại học (<?php echo $demDaiHoc; ?> Ngành)</li>
        <li data-tab="thacsi">Thạc sĩ (<?php echo $demThacSi; ?> Ngành)</li>
        <li data-tab="tiensi">Tiến sĩ (<?php echo $demTienSi; ?>)</li>
    </ul>


    <div class="tab-content2 active" id="daihoc">
        <div class="carousel-wrapper">
            <button class="carousel-btn left">←</button>
            <div class="carousel-container">
                <?php foreach($courses as $course): ?>
                <?php if($course['cap_hoc'] == 'Đại học'): ?>
                <a
                    href="../baiviet/course_detail.php?id=<?php echo $course['id']; ?>&cap_hoc=<?php echo urlencode($course['cap_hoc']); ?>">
                    <div class="course-item">
                        <img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>"
                            alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>">
                        <h2><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h2>
                    </div>
                </a>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <button class="carousel-btn right">→</button>
        </div>
    </div>

    <div class="tab-content2" id="thacsi">
        <div class="carousel-wrapper">
            <button class="carousel-btn left">←</button>
            <div class="carousel-container">
                <?php foreach($courses as $course): ?>
                <?php if($course['cap_hoc'] == 'Thạc sĩ'): ?>
                <a
                    href="../baiviet/course_detail.php?id=<?php echo $course['id']; ?>&cap_hoc=<?php echo urlencode($course['cap_hoc']); ?>">
                    <div class="course-item">
                        <img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>"
                            alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>">
                        <h2><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h2>
                    </div>
                </a>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <button class="carousel-btn right">→</button>
        </div>
    </div>


    <div class="tab-content2" id="tiensi">
        <div class="carousel-wrapper">
            <button class="carousel-btn left">←</button>
            <div class="carousel-container">
                <?php foreach($courses as $course): ?>
                <?php if($course['cap_hoc'] == 'Tiến sĩ'): ?>
                <a
                    href="../baiviet/course_detail.php?id=<?php echo $course['id']; ?>&cap_hoc=<?php echo urlencode($course['cap_hoc']); ?>">
                    <div class="course-item">
                        <img src="<?php echo htmlspecialchars($course['hinh_anh']); ?>"
                            alt="<?php echo htmlspecialchars($course['ten_khoahoc']); ?>">
                        <h2><?php echo htmlspecialchars($course['ten_khoahoc']); ?></h2>
                    </div>
                </a>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <button class="carousel-btn right">→</button>
        </div>
    </div>
</nav>