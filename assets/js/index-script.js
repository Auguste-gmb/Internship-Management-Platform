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

document.getElementById("hamburger").addEventListener("click", () => {
	document.getElementById("hamburger").classList.toggle("open");
	document.getElementById("navLinks").classList.toggle("open");
});

function fillSearch(btn) {
	document.getElementById("jobInput").value = btn.textContent.trim();
}

function animateCounter(el) {
	const target = +el.dataset.target;
	const duration = 1400;
	const start = performance.now();
	function step(now) {
		const p = Math.min((now - start) / duration, 1);
		const ease = 1 - Math.pow(1 - p, 3);
		el.textContent = Math.floor(ease * target);
		if (p < 1) requestAnimationFrame(step);
		else el.textContent = target;
	}
	requestAnimationFrame(step);
}

const counters = document.querySelectorAll(".stat-number[data-target]");
const obs = new IntersectionObserver(
	(entries) => {
		if (entries[0].isIntersecting) {
			counters.forEach(animateCounter);
			obs.disconnect();
		}
	},
	{ threshold: 0.3 },
);
if (counters.length) obs.observe(counters[0].closest(".stats-card"));

window.addEventListener(
	"scroll",
	() => {
		const a = document.getElementById("scrollArrow");
		if (a) a.style.opacity = window.scrollY > 60 ? "0" : "1";
	},
	{ passive: true },
);

function toggleWish(btn) {
	btn.classList.toggle("active");
	const svg = btn.querySelector("svg");
	svg.setAttribute(
		"fill",
		btn.classList.contains("active") ? "currentColor" : "none",
	);
}
