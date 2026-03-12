const sidebar = document.querySelector(".sidebar");
const overlay = document.getElementById("overlay");

document.getElementById("toggleSidebar").addEventListener("click", () => {
    sidebar.classList.toggle("active");
});

// Close sidebar when clicking outside
overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
});
