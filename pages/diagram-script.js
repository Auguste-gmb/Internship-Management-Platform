// JSON DATA
const data = {
	"Offer waiting": 5,
	"Offer refuse": 28,
	"Offer accepted": 0,
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

	cumulativePercent += percent;
	colorIndex++;
}

// Application du conic-gradient dynamique
chartContainer.style.background = `conic-gradient(${gradientParts.join(",")})`;
