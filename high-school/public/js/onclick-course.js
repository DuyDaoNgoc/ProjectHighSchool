document.addEventListener("DOMContentLoaded", function () {
  const carousels = document.querySelectorAll(".carousel-wrapper");

  carousels.forEach((carousel) => {
    const container = carousel.querySelector(".carousel-container");
    const leftBtn = carousel.querySelector(".carousel-btn.left");
    const rightBtn = carousel.querySelector(".carousel-btn.right");

    function slideRight() {
      const firstItem = container.firstElementChild;
      if (!firstItem) return;
      const itemWidth = firstItem.offsetWidth + 10;
      container.style.transition = "transform 0.5s ease";
      container.style.transform = `translateX(-${itemWidth}px)`;
      container.addEventListener(
        "transitionend",
        function () {
          container.style.transition = "none";
          container.appendChild(firstItem);
          container.style.transform = "translateX(0)";
        },
        { once: true }
      );
    }

    function slideLeft() {
      const lastItem = container.lastElementChild;
      if (!lastItem) return;
      const itemWidth = lastItem.offsetWidth + 10;
      container.style.transition = "none";
      container.insertBefore(lastItem, container.firstElementChild);
      container.style.transform = `translateX(-${itemWidth}px)`;
      container.offsetHeight; // reflow
      container.style.transition = "transform 0.5s ease";
      container.style.transform = "translateX(0)";
    }

    rightBtn.addEventListener("click", slideRight);
    leftBtn.addEventListener("click", slideLeft);

    // Tự động chuyển slide sau 10 giây cho carousel này
    setInterval(slideRight, 10000);
  });
});
