const ctx = document.getElementById("grafico");
console.log(arrayNotas);
new Chart(ctx, {
  type: "bar",
  data: {
    labels: arrayNotas,
    datasets: [
      {
        label: "# of Votes",
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
      },
    },
    
  },
});
