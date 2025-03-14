<link rel="stylesheet" href="http://localhost/high-school/public/css/reset.css">
<link rel="stylesheet" href="http://localhost/high-school/public/css/style.css">
<link rel="stylesheet" href="http://localhost/high-school/public/css/gerenal.css">
<link rel="stylesheet" href="http://localhost/high-school/public/css/dataTab.css">
<link rel="stylesheet" href="http://localhost/high-school/public/css/tabs.css">
<link rel="stylesheet" href="http://localhost/high-school/public/css/tuvan.css">
<link rel="stylesheet" href="http://localhost/high-school/public/css/course.css">
<link rel="stylesheet" href=" http://localhost/high-school/public/css/return-home.css">
<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
    rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
    rel="stylesheet">
<script src="http://localhost/high-school/public/js/ThongTinTuyenSinh.js"></script>
<script src="http://localhost/high-school/public/js/tabs.js"></script>
<script src="http://localhost/high-school/public/js/onclick-course.js"></script>

<style>
#loadingOverlay {
    display: none;
    /* ẩn mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

#loadingOverlay .spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

<script>
$(document).ready(function() {

    $("a[href]:not([href='#'])").on("click", function() {
        $("#loadingOverlay").show();
    });
    // Khi submit form
    $("form").on("submit", function() {
        $("#loadingOverlay").show();
    });
});
</script>

</head>
<style>
.loading span {
    display: flex;
    align-items: center;
    color: lightgreen;
}

.loading span {
    position: relative;
    display: inline-block;
    font-size: 2rem;
    text-transform: uppercase;
    animation: loading 1s infinite;
    animation-delay: calc(0.1s* var(--i));
    display: flex;
    justify-items: center;
    color: green;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}


@keyframes loading {

    0%,
    40%,
    100% {
        transform: translate(0)
    }

    20% {
        transform: translatey(-20px);
    }
}
</style>