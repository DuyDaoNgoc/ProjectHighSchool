<aside class="aside">
    <div>
        <div style="    display: grid
;
    gap: 20px;justify-items:center;">
            <div>
                <div style="display: grid
;
    gap: 10px;"><?php $sql_event="SELECT * FROM sukien WHERE noi_bat = 1 ORDER BY ngay_bat_dau DESC LIMIT 1";
$result_event=$conn->query($sql_event);
echo "<h3 style =' font-weight: 700;'>Sự kiện nổi bật</h3>";
echo "<ul>";

if ($result_event && $result_event->num_rows > 0) {
    $event=$result_event->fetch_assoc();
    echo "<li>";
    echo "<a href='../menu/sukien_chitiet.php?id=". $event['id'] . "'>";

    if ( !empty($event['hinh_anh'])) {
        echo "<img src='". $event['hinh_anh'] . "' alt='". htmlspecialchars($event['tieu_de']) . "' style='max-width:100%;'>";
    }

    echo "<p>". $event['tieu_de'] . "</p>";
    echo "</a>";
    echo "</li>";
}

else {
    echo "<li style ='color:#333'>Chưa có sự kiện nổi bật.</li>";
}

echo "</ul>";
?></div>
            </div>
            <div>
                <div style="    display: grid
;
    gap: 20px;"><?php $sql="SELECT * FROM tintuc WHERE trang_thai = 'Hiển thị' ORDER BY ngay_dang DESC LIMIT 5";
$result=$conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row=$result->fetch_assoc()) {
        ?><li style="width: 142px;list-style: none;"><a href="../menu/id-tintuc.php?id=<?php echo $row['id']; ?>">
                            <div class="tin_tuc">
                                <div class="anh_asset-aside"><img src="<?php echo $row['hinh_anh']; ?>"
                                        alt="<?php echo htmlspecialchars($row['tieu_de']); ?>">
                                    <p><?php echo $row['tieu_de'];
        ?></p>
                                </div>

                            </div>
                        </a></li><?php
    }
}

else {
    echo "<li style ='color:#333'>Không có tin tức mới.</li>";
}

?></div>
            </div>
            <div>
                <div style="display: grid
;
    gap: 10px;"><?php $sql_ts="SELECT * FROM tuyensinh ORDER BY id ASC";
$result_ts=$conn->query($sql_ts);
echo "<h3 style =' font-weight: 700;'>Thông tin tuyển sinh</h3>";
echo "<ul >";

if ($result_ts && $result_ts->num_rows > 0) {
    while ($ts=$result_ts->fetch_assoc()) {
        echo "<li><a href='". $ts['link'] . "'>". $ts['tieu_de'] . "</a></li>";
    }
}

else {
    echo "<li>Chưa có thông tin tuyển sinh.</li>";
}

echo "</ul>";
?></div>
            </div>
            <div>
                <div style="display: grid
;
    gap: 10px;"><?php $sql_hb="SELECT * FROM hocbong ORDER BY id ASC";
$result_hb=$conn->query($sql_hb);
echo "<h3 style =' font-weight: 700;' >Thông tin học bổng</h3>";
echo "<ul>";

if ($result_hb && $result_hb->num_rows > 0) {
    while ($hb=$result_hb->fetch_assoc()) {
        echo "<li><a href='". $hb['link'] . "'>". $hb['tieu_de'] . "</a></li>";
    }
}

else {
    echo "<li>Chưa có thông tin học bổng.</li>";
}

echo "</ul>";
?></div>
            </div>
        </div>

    </div>
</aside>