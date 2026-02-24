document.addEventListener('DOMContentLoaded', function() {
  const canvas = document.getElementById('myChart');
  if (!canvas) {
    console.warn('Canvas myChart não encontrado no DOM.');
    return;
  }
  if (typeof Chart === 'undefined') {
    console.warn('Chart.js não carregado.');
    return;
  }
  
  const ctx = canvas.getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: diasSemana,
      datasets: [{
        label: 'Atividades por Dia',
        data: qtdAtividades,
        backgroundColor: '#5c5edc',
        borderColor: '#3a3ccc',
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
      },
     scales: {
        y: {
            beginAtZero: true,
            suggestedMax: 10,
            ticks: {
                stepSize: 1,  
                callback: function(value) {
                    return Number.isInteger(value) ? value : null; 
                }
            },
            title: { display: true, text: 'Quantidade de Atividades' }
        },
        x: {
            title: { display: true, text: 'Dias da Semana' }
        }   
    }

    }
  });
});
