// Menu hamburger
document.getElementById("hamburger").addEventListener("click", () => {
    document.getElementById("hamburger").classList.toggle("open");
    document.getElementById("navLinks").classList.toggle("open");
});

// Sidebar filtres
document.getElementById("filterToggle").addEventListener("click", () => {
    document.getElementById("sidebar").classList.toggle("open");
});