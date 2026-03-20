// Hamburger nav
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");
hamburger.addEventListener("click", () => {
	hamburger.classList.toggle("open");
	navLinks.classList.toggle("open");
});

// Filter sidebar toggle (mobile)
document.getElementById("filterToggle").addEventListener("click", () => {
	document.getElementById("sidebar").classList.toggle("open");
});

// Wish-list
function toggleWish(btn) {
	btn.classList.toggle("active");
	const svg = btn.querySelector("svg");
	svg.setAttribute(
		"fill",
		btn.classList.contains("active") ? "currentColor" : "none",
	);
}

// Range salary
function updateRange(val) {
	document.getElementById("rangeVal").textContent =
		parseInt(val).toLocaleString("fr-FR") + " €/mois";
}

// Chips
function removeChip(chip) {
	chip.remove();
}

function clearFilter(groupId) {
	document
		.querySelectorAll("#" + groupId + ' input[type="checkbox"]')
		.forEach((cb) => (cb.checked = false));
	updateChips();
}

function updateChips() {
	// rebuild chips from checked boxes
	const container = document.getElementById("activeFilters");
	container.innerHTML = "";
	document.querySelectorAll(".filter-options input:checked").forEach((cb) => {
		const label = cb
			.closest(".filter-option")
			.querySelector(".filter-label");
		const text = label.childNodes[0].textContent.trim();
		const chip = document.createElement("button");
		chip.className = "chip";
		chip.innerHTML = text + ' <span class="chip-x">×</span>';
		chip.onclick = function () {
			cb.checked = false;
			chip.remove();
		};
		container.appendChild(chip);
	});
}

function applyFilters() {
	updateChips();
}

// Pagination
document.querySelectorAll(".page-btn:not(.arrow)").forEach((btn) => {
	btn.addEventListener("click", () => {
		document
			.querySelectorAll(".page-btn")
			.forEach((b) => b.classList.remove("active"));
		btn.classList.add("active");
	});
});
