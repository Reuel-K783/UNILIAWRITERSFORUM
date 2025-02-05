// Example data for Chart.js
const ctx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Attended', 'Missed'],
        datasets: [{
            data: [/* Fetch data from PHP */],
            backgroundColor: ['#36A2EB', '#FF6384'],
        }]
    },
    options: {
        responsive: true
    }
});


const dailyTasksChart = new Chart(document.getElementById('dailyTasksChart'), {
    type: 'bar',
    data: {
      labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      datasets: [{
        label: 'Tasks Completed',
        data: [12, 19, 3, 5, 2, 3, 7],
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  
  const expenseChart = new Chart(document.getElementById('expenseChart'), {
    type: 'pie',
    data: {
      labels: ['Food', 'Transport', 'Entertainment', 'Bills'],
      datasets: [{
        label: 'Expenses',
        data: [300, 50, 100, 200],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)'
        ],
        borderWidth: 1
      }]
    }
  });