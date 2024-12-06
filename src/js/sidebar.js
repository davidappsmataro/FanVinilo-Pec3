document.getElementById("openSidebar").addEventListener("click", function () {
  document.getElementById("sidebar").classList.remove("translate-x-full");
});

document.getElementById("closeSidebar").addEventListener("click", function () {
  document.getElementById("sidebar").classList.add("translate-x-full");
});
document.querySelectorAll(".menu-sidebar-option").forEach(function (element) {
  element.addEventListener("click", function () {
    document.getElementById("sidebar").classList.add("translate-x-full");
  });
});
document.getElementById("fondoCapa").addEventListener("click", function () {
  console.log("hola");
  document.getElementById("sidebar").classList.add("translate-x-full");
});
