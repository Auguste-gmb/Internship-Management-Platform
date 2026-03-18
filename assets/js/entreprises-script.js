document.getElementById("hamburger").addEventListener("click", () => {
	document.getElementById("hamburger").classList.toggle("open");
	document.getElementById("navLinks").classList.toggle("open");
});
document.getElementById("filterToggle").addEventListener("click", () => {
	document.getElementById("sidebar").classList.toggle("open");
});
function filterCards() {
	const q = document.getElementById("searchInput").value.toLowerCase();
	const cards = document.querySelectorAll(".company-card");
	let visible = 0;
	cards.forEach((card) => {
		const name = card
			.querySelector(".company-card-name")
			.textContent.toLowerCase();
		const sector = card
			.querySelector(".company-sector")
			.textContent.toLowerCase();
		const match = name.includes(q) || sector.includes(q);
		card.style.display = match ? "" : "none";
		if (match) visible++;
	});
	document.getElementById("resultsCount").innerHTML =
		`<strong>${visible} entreprise${visible > 1 ? "s" : ""}</strong> trouvée${visible > 1 ? "s" : ""}`;
}
function clearGroup(btn) {
	btn.closest(".filter-card")
		.querySelectorAll('input[type="checkbox"]')
		.forEach((cb) => (cb.checked = false));
}
document.querySelectorAll(".page-btn:not(.arrow)").forEach((btn) => {
	btn.addEventListener("click", () => {
		document
			.querySelectorAll(".page-btn")
			.forEach((b) => b.classList.remove("active"));
		btn.classList.add("active");
	});
});
