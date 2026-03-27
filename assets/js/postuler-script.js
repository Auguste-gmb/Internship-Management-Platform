// Hamburger
document.getElementById("hamburger").addEventListener("click", () => {
	document.getElementById("hamburger").classList.toggle("open");
	document.getElementById("navLinks").classList.toggle("open");
});

// Wish-list
let wished = false;
function toggleWish() {
	wished = !wished;
	const btn = document.getElementById("wishBtn");
	const lbl = document.getElementById("wishLabel");
	btn.classList.toggle("active", wished);
	btn.querySelector("svg").setAttribute("fill", wished ? "white" : "none");
	lbl.textContent = wished
		? "Retiré de la wish-list"
		: "Ajouter à la wish-list";
}

// File upload
function handleFile(input) {
	const file = input.files[0];
	if (!file) return;
	document.getElementById("fileName").textContent = file.name;
	document.getElementById("fileSize").textContent =
		(file.size / 1024 / 1024).toFixed(2) + " Mo";
	document.getElementById("filePreview").classList.add("show");
	checkForm();
}
function removeFile() {
	document.getElementById("cvInput").value = "";
	document.getElementById("filePreview").classList.remove("show");
	checkForm();
}

// Drag & drop
const zone = document.getElementById("uploadZone");
zone.addEventListener("dragover", (e) => {
	e.preventDefault();
	zone.style.borderColor = "var(--mint-dark)";
	zone.style.background = "var(--mint-bg)";
});
zone.addEventListener("dragleave", () => {
	zone.style.borderColor = "";
	zone.style.background = "";
});
zone.addEventListener("drop", (e) => {
	e.preventDefault();
	zone.style.borderColor = "";
	zone.style.background = "";
	const file = e.dataTransfer.files[0];
	if (file) {
		document.getElementById("cvInput").files = e.dataTransfer.files;
		handleFile(document.getElementById("cvInput"));
	}
});

// Char counter
function countChars(id, countId, max) {
	const len = document.getElementById(id).value.length;
	const el = document.getElementById(countId);
	el.textContent = len + " / " + max;
	el.classList.toggle("warn", len > max * 0.9);
	checkForm();
}

// Enable submit
function checkForm() {
	const hasFile = document.getElementById("cvInput").files.length > 0;
	const hasLM = document.getElementById("lm").value.trim().length >= 10;
	const hasConsent = document.getElementById("consent").checked;
	document.getElementById("submitBtn").disabled = !(
		hasFile &&
		hasLM &&
		hasConsent
	);
}

// Submit
function submitForm() {
	document.getElementById("successOverlay").classList.add("show");
}
document
	.getElementById("successOverlay")
	.addEventListener("click", function (e) {
		if (e.target === this) this.classList.remove("show");
	});
