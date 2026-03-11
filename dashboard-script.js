// Hamburger
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");
hamburger.addEventListener("click", () => {
	hamburger.classList.toggle("open");
	navLinks.classList.toggle("open");
});

// Wish-list remove
document.querySelectorAll(".wish-remove").forEach((btn) => {
	btn.addEventListener("click", () => {
		btn.closest(".wish-card").style.opacity = "0";
		btn.closest(".wish-card").style.transform = "scale(.95)";
		btn.closest(".wish-card").style.transition = "all .3s";
		setTimeout(() => btn.closest(".wish-card").remove(), 300);
	});
});

// Animate stat values on load
function animateVal(el, target) {
	if (target === 0) return;
	const start = performance.now();
	const tick = (now) => {
		const p = Math.min((now - start) / 1000, 1);
		el.textContent = Math.round((1 - Math.pow(1 - p, 3)) * target);
		if (p < 1) requestAnimationFrame(tick);
	};
	requestAnimationFrame(tick);
}

document.querySelectorAll(".stat-card-value").forEach((el) => {
	const val = parseInt(el.textContent);
	el.textContent = "0";
	setTimeout(() => animateVal(el, val), 300);
});
