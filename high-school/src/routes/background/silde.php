<section class="banner">
    <button id="prevBtn">❮</button>
    <div class="image-container">
        <img class="active" src="http://localhost/high-school/public/asset/img/marketing.jpg" alt="Hình ảnh 1">
        <img src="http://localhost/high-school/public/asset/img/netdeptuoihoctro.jpg" alt="Hình ảnh 2">
        <img src="http://localhost/high-school/public/asset/img/daisuvanhoa.jpg" alt="Hình ảnh 3">
    </div>
    <button id="nextBtn">❯</button>
</section>

<script>
const images = document.querySelectorAll(".image-container img");
let currentIndex = 0;

const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

function updateImage() {
    images.forEach((img, index) => {
        img.style.display = index === currentIndex ? "block" : "none";
    });
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length; // Nếu cuối thì quay về đầu
    updateImage();
}

function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length; // Nếu đầu thì quay về cuối
    updateImage();
}

// Auto chuyển ảnh sau 5s
let autoSlide = setInterval(nextImage, 5000);

function resetAutoSlide() {
    clearInterval(autoSlide);
    autoSlide = setInterval(nextImage, 5000);
}

// Xử lý sự kiện click
prevBtn.addEventListener("click", () => {
    prevImage();
    resetAutoSlide();
});

nextBtn.addEventListener("click", () => {
    nextImage();
    resetAutoSlide();
});

// Xử lý phím mũi tên trái/phải
document.addEventListener("keydown", (event) => {
    if (event.key === "ArrowLeft") {
        prevImage();
        resetAutoSlide();
    } else if (event.key === "ArrowRight") {
        nextImage();
        resetAutoSlide();
    }
});

// Hiển thị ảnh ban đầu
updateImage();
</script>

<style>
.banner {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    overflow: hidden;
}

.image-container {
    width: 100%;

    justify-content: center;
}

.image-container img {
    width: 100%;
    display: none;
}

.image-container img.active {
    display: block;
}

.banner button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 30px;
    cursor: pointer;
    border-radius: 100px;
    font-size: 30px;
    z-index: 10;
}

#prevBtn {
    left: 10px;
}

#nextBtn {
    right: 10px;
}
</style>