// JSON DATA
const data = {
	"Offer waiting": 45,
	"Offer refuse": 40,
	"Offer accepted": 1,
};

// Couleurs automatiques
const colors = ["#EDF6F9", "#FFDDD2", "#83C5BE"];

const chartContainer = document.querySelector(".chart-container");
const legendContainer = document.getElementById("legend");
const totalLabel = document.getElementById("totalLabel");

// Calcul total
const total = Object.values(data).reduce((a, b) => a + b, 0);
totalLabel.textContent = total;

let cumulativePercent = 0;
let gradientParts = [];
let colorIndex = 0;

for (let key in data) {
	const value = data[key];
	const percent = (value / total) * 100;

	const start = cumulativePercent;
	const end = cumulativePercent + percent;

	const color = colors[colorIndex % colors.length];

	gradientParts.push(`${color} ${start}% ${end}%`);

	/*
	// Création légende
	const legendItem = document.createElement("div");
	legendItem.classList.add("legend-item");

	const colorBox = document.createElement("div");
	colorBox.classList.add("legend-color");
	colorBox.style.background = color;

	const text = document.createTextNode(`${key} - ${value}`);

	legendItem.appendChild(colorBox);
	legendItem.appendChild(text);
	legendContainer.appendChild(legendItem);
    */

	cumulativePercent += percent;
	colorIndex++;
}

// Application du conic-gradient dynamique
chartContainer.style.background = `conic-gradient(${gradientParts.join(",")})`;
