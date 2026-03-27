// Hamburger
document.getElementById("hamburger").addEventListener("click", () => {
	document.getElementById("hamburger").classList.toggle("open");
	document.getElementById("navLinks").classList.toggle("open");
});

// Switch tabs
function switchTab(tab) {
	document
		.getElementById("tabLogin")
		.classList.toggle("active", tab === "login");
	document
		.getElementById("tabRegister")
		.classList.toggle("active", tab === "register");
	document
		.getElementById("panelLogin")
		.classList.toggle("active", tab === "login");
	document
		.getElementById("panelRegister")
		.classList.toggle("active", tab === "register");
}

// Toggle password visibility
function togglePw(inputId, btn) {
	const input = document.getElementById(inputId);
	const show = input.type === "password";
	input.type = show ? "text" : "password";
	btn.querySelector("svg").style.opacity = show ? ".4" : "1";
}

// Role selector
function selectRole(btn) {
	document
		.querySelectorAll(".role-btn")
		.forEach((b) => b.classList.remove("active"));
	btn.classList.add("active");
}

// Password strength
function checkStrength(pw) {
	let score = 0;
	if (pw.length >= 8) score++;
	if (/[A-Z]/.test(pw)) score++;
	if (/[0-9]/.test(pw)) score++;
	if (/[^A-Za-z0-9]/.test(pw)) score++;

	const colors = ["", "#e89080", "#f0b429", "#6bbfb0", "#3d8a7a"];
	const labels = ["", "Faible", "Moyen", "Bon", "Fort"];
	for (let i = 1; i <= 4; i++) {
		document.getElementById("s" + i).style.background =
			i <= score ? colors[score] : "#ebebeb";
	}
	document.getElementById("strengthLabel").textContent = pw.length
		? labels[score]
		: "";
	document.getElementById("strengthLabel").style.color = colors[score];
}

// Login handler
function handleLogin() {
	const email = document.getElementById("loginEmail").value.trim();
	const pw = document.getElementById("loginPw").value;
	const alert = document.getElementById("loginAlert");

	if (!email || !pw) {
		document.getElementById("loginAlertMsg").textContent =
			"Veuillez remplir tous les champs.";
		alert.classList.add("show");
		return;
	}
	// Simulate success
	alert.classList.remove("show");
	window.location.href = "dashboard.html";
}

// Register handler
function handleRegister() {
	const pw = document.getElementById("regPw").value;
	const confirm = document.getElementById("regPwConfirm").value;
	const mismatch = document.getElementById("pwMismatch");

	if (pw !== confirm) {
		mismatch.classList.add("show");
		document.getElementById("regPwConfirm").classList.add("error");
		return;
	}
	mismatch.classList.remove("show");
	document.getElementById("regPwConfirm").classList.remove("error");
	// Simulate success → redirect to dashboard
	window.location.href = "dashboard.html";
}

// Enter key submit
document.addEventListener("keydown", (e) => {
	if (e.key === "Enter") {
		if (document.getElementById("panelLogin").classList.contains("active"))
			handleLogin();
		else handleRegister();
	}
});
