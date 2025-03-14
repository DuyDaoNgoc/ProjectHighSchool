document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tabs2 li");
  const tabContents = document.querySelectorAll(".tab-content2");

  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      // Bỏ class "active" của tất cả các tab
      tabs.forEach((t) => t.classList.remove("active"));
      this.classList.add("active");

      // Ẩn tất cả nội dung tab
      tabContents.forEach((content) => content.classList.remove("active"));

      // Hiển thị nội dung tab được chọn
      const targetId = this.getAttribute("data-tab");
      document.getElementById(targetId).classList.add("active");
    });
  });
});
