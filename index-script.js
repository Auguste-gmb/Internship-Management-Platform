// Hamburger
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");
hamburger.addEventListener("click", () => {
	hamburger.classList.toggle("open");
	navLinks.classList.toggle("open");
});

// Tag → search
function fillSearch(btn) {
	document.getElementById("jobInput").value = btn.textContent;
	document.getElementById("jobInput").focus();
}

// Wish-list toggle
function toggleWish(btn) {
	btn.classList.toggle("active");
	btn.querySelector("svg").setAttribute(
		"fill",
		btn.classList.contains("active") ? "currentColor" : "none",
	);
}

// Counter animation
function animateCounter(el) {
	const target = parseInt(el.dataset.target, 10);
	const start = performance.now();
	const tick = (now) => {
		const p = Math.min((now - start) / 1400, 1);
		el.textContent = Math.round((1 - Math.pow(1 - p, 3)) * target);
		if (p < 1) requestAnimationFrame(tick);
	};
	requestAnimationFrame(tick);
}

new IntersectionObserver(
	(entries) => {
		entries.forEach((e) => {
			if (e.isIntersecting)
				e.target
					.querySelectorAll("[data-target]")
					.forEach(animateCounter);
		});
	},
	{ threshold: 0.3 },
).observe(document.querySelector(".stats-card"));

// Search
document.getElementById("searchBtn").addEventListener("click", () => {
	const job = document.getElementById("jobInput").value.trim();
	const loc = document.getElementById("locInput").value.trim();
	if (job || loc)
		alert(`Recherche : "${job || "tous"}" — "${loc || "partout"}"`);
});
