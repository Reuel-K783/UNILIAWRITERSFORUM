// script.js
document.addEventListener('DOMContentLoaded', () => {
    // JavaScript logic to handle schedules and plans
});
document.addEventListener('DOMContentLoaded', () => {
    loadTasks();

    // Add Task Function
    window.addTask = function() {
        const taskName = document.getElementById('task').value;
        const taskTime = document.getElementById('time').value;

        if (taskName === '' || taskTime === '') {
            alert("Please enter both task and time");
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "add_task.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                loadTasks();
            }
        };
        xhr.send(`task_name=${taskName}&task_time=${taskTime}`);
    };

    // Load Tasks Function
    function loadTasks() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "get_tasks.php", true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const tasks = JSON.parse(xhr.responseText);
                let taskList = document.getElementById('task-list');
                taskList.innerHTML = '';
                tasks.forEach(task => {
                    const li = document.createElement('li');
                    li.textContent = `${task.task_name} at ${task.task_time}`;
                    taskList.appendChild(li);
                });
            }
        };
        xhr.send();
    }
});



// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadPlans();

    window.addPlan = function() {
        const planName = document.getElementById('plan').value;
        const planType = document.getElementById('plan-type').value;
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const details = document.getElementById('plan-details').value;

        const formData = new FormData();
        formData.append('plan_name', planName);
        formData.append('plan_type', planType);
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);
        formData.append('details', details);

        fetch('add_plans.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadPlans();
        })
        .catch(error => console.error('Error:', error));
    };

    function loadPlans() {
        fetch('get_plans.php')
        .then(response => response.json())
        .then(plans => {
            const planList = document.getElementById('plan-list');
            planList.innerHTML = '';
            plans.forEach(plan => {
                const li = document.createElement('li');
                li.textContent = `${plan.plan_name} (${plan.plan_type}) from ${plan.start_date} to ${plan.end_date}`;
                planList.appendChild(li);
            });
        })
        .catch(error => console.error('Error:', error));
    }
});


// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadTransactions();

    window.addTransaction = function() {
        const amount = document.getElementById('amount').value;
        const transactionType = document.getElementById('transaction-type').value;
        const category = document.getElementById('category').value;
        const transactionDate = document.getElementById('transaction-date').value;
        const notes = document.getElementById('transaction-notes').value;

        const formData = new FormData();
        formData.append('amount', amount);
        formData.append('transaction_type', transactionType);
        formData.append('category', category);
        formData.append('transaction_date', transactionDate);
        formData.append('notes', notes);

        fetch('add_transactions.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadTransactions();
        })
        .catch(error => console.error('Error:', error));
    };

    function loadTransactions() {
        fetch('get_transactions.php')
        .then(response => response.json())
        .then(transactions => {
            const transactionList = document.getElementById('transaction-list');
            transactionList.innerHTML = '';
            transactions.forEach(transaction => {
                const li = document.createElement('li');
                li.textContent = `${transaction.transaction_date}: ${transaction.category} - ${transaction.transaction_type} $${transaction.amount}`;
                transactionList.appendChild(li);
            });
        })
        .catch(error => console.error('Error:', error));
    }
});


// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadActivities();

    window.addActivity = function() {
        const activityName = document.getElementById('activity').value;
        const activityType = document.getElementById('activity-type').value;
        const activityTime = document.getElementById('activity-time').value;
        const dayOfWeek = document.getElementById('day-of-week').value;

        const formData = new FormData();
        formData.append('activity_name', activityName);
        formData.append('activity_type', activityType);
        formData.append('activity_time', activityTime);
        formData.append('day_of_week', dayOfWeek);

        fetch('add_activity.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadActivities();
        })
        .catch(error => console.error('Error:', error));
    };

    function loadActivities() {
        fetch('get_activities.php')
        .then(response => response.json())
        .then(activities => {
            const activityList = document.getElementById('activity-list');
            activityList.innerHTML = '';
            activities.forEach(activity => {
                const li = document.createElement('li');
                li.textContent = `${activity.day_of_week}: ${activity.activity_name} (${activity.activity_type}) at ${activity.activity_time}`;
                activityList.appendChild(li);
            });
        })
        .catch(error => console.error('Error:', error));
    }
});



// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadClothing();

    window.addClothing = function() {
        const clothingToday = document.getElementById('clothing-today').value;
        const clothingTomorrow = document.getElementById('clothing-tomorrow').value;
        const today = new Date().toISOString().split('T')[0];
        const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0];

        const formDataToday = new FormData();
        formDataToday.append('clothing_item', clothingToday);
        formDataToday.append('date', today);

        const formDataTomorrow = new FormData();
        formDataTomorrow.append('clothing_item', clothingTomorrow);
        formDataTomorrow.append('date', tomorrow);

        Promise.all([
            fetch('add_clothing.php', { method: 'POST', body: formDataToday }),
            fetch('add_clothing.php', { method: 'POST', body: formDataTomorrow })
        ])
        .then(responses => Promise.all(responses.map(res => res.text())))
        .then(data => {
            alert('Clothing arrangements saved');
            loadClothing();
        })
        .catch(error => console.error('Error:', error));
    };

    function loadClothing() {
        fetch('get_clothing.php')
        .then(response => response.json())
        .then(clothingArrangements => {
            const clothingList = document.getElementById('clothing-list');
            clothingList.innerHTML = '';
            clothingArrangements.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.date}: ${item.clothing_item}`;
                clothingList.appendChild(li);
            });
        })
        .catch(error => console.error('Error:', error));
    }
});




// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadTasks();
    
    function loadTasks() {
        // Fetch tasks from the server
        fetch('get_tasks.php')
            .then(response => response.json())
            .then(tasks => {
                const taskDurations = tasks.map(task => ({
                    label: task.task_name,
                    duration: getTaskDuration(task.task_time)
                }));

                const data = {
                    labels: taskDurations.map(task => task.label),
                    datasets: [{
                        data: taskDurations.map(task => task.duration),
                        backgroundColor: taskDurations.map((_, index) => `hsl(${index * 36}, 70%, 50%)`)
                    }]
                };

                renderPieChart(data);
            })
            .catch(error => console.error('Error fetching tasks:', error));
    }

    function getTaskDuration(taskTime) {
        // Assuming taskTime is in "HH:MM" format, convert to minutes
        const [hours, minutes] = taskTime.split(':').map(Number);
        return hours * 60 + minutes;
    }

    function renderPieChart(data) {
        const ctx = document.getElementById('dailyTasksChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const totalMinutes = context.raw;
                                const hours = Math.floor(totalMinutes / 60);
                                const minutes = totalMinutes % 60;
                                return `${context.label}: ${hours}h ${minutes}m`;
                            }
                        }
                    }
                }
            }
        });
    }
});




// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadExpenses();
    
    function loadExpenses() {
        // Fetch transactions from the server
        fetch('get_transactions.php')
            .then(response => response.json())
            .then(transactions => {
                const expenses = transactions
                    .filter(transaction => transaction.transaction_type === 'expense')
                    .reduce((acc, transaction) => {
                        acc[transaction.category] = (acc[transaction.category] || 0) + parseFloat(transaction.amount);
                        return acc;
                    }, {});

                const sortedExpenses = Object.entries(expenses).sort((a, b) => b[1] - a[1]);

                const data = {
                    labels: sortedExpenses.map(item => item[0]),
                    datasets: [{
                        label: 'Expenses',
                        data: sortedExpenses.map(item => item[1]),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                };

                renderBarChart(data);
            })
            .catch(error => console.error('Error fetching transactions:', error));
    }

    function renderBarChart(data) {
        const ctx = document.getElementById('expenseChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Category'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` $${context.raw.toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
    }
});



// Example JavaScript for adding tasks, transactions, etc.
// In a real application, you might fetch data from a server via AJAX/fetch

// Add Task for Daily Schedule
function addTask() {
    const taskInput = document.getElementById('task');
    const timeInput = document.getElementById('time');
    const taskList = document.getElementById('task-list');
  
    if(taskInput.value.trim() === "" || timeInput.value === "") {
      alert("Please fill in both task and time.");
      return;
    }
  
    // Create a new list item with a card-like appearance
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${taskInput.value}</strong> at ${timeInput.value}`;
  
    taskList.appendChild(li);
    taskInput.value = "";
    timeInput.value = "";
  }
  
  // Add Transaction for Money Management
  function addTransaction() {
    const amount = document.getElementById('amount').value;
    const type = document.getElementById('transaction-type').value;
    const category = document.getElementById('category').value;
    const date = document.getElementById('transaction-date').value;
    const notes = document.getElementById('transaction-notes').value;
    const transactionList = document.getElementById('transaction-list');
  
    if(amount === "" || category.trim() === "" || date === "") {
      alert("Please complete all required fields.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${type.toUpperCase()}</strong> of $${amount} in ${category} on ${date} <br> ${notes}`;
    transactionList.appendChild(li);
  }
  
  // Add Plan for Long and Short Term Plans
  function addPlan() {
    const plan = document.getElementById('plan').value;
    const planType = document.getElementById('plan-type').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const details = document.getElementById('plan-details').value;
    const planList = document.getElementById('plan-list');
  
    if(plan.trim() === "" || startDate === "" || endDate === "") {
      alert("Please fill in the plan and dates.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${planType.toUpperCase()} PLAN:</strong> ${plan}<br>From ${startDate} to ${endDate}<br>${details}`;
    planList.appendChild(li);
  }
  
 
  // Add Clothing for Clothing Arrangement
  function addClothing() {
    const today = document.getElementById('clothing-today').value;
    const tomorrow = document.getElementById('clothing-tomorrow').value;
    const clothingList = document.getElementById('clothing-list');
  
    if(today.trim() === "" || tomorrow.trim() === "") {
      alert("Please enter clothing for both today and tomorrow.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>Today:</strong> ${today} <br> <strong>Tomorrow:</strong> ${tomorrow}`;
    clothingList.appendChild(li);
  }
  let activities = [];
// Example JavaScript for adding tasks, transactions, etc.
// In a real application, you might fetch data from a server via AJAX/fetch

// Add Task for Daily Schedule
function addTask() {
    const taskInput = document.getElementById('task');
    const timeInput = document.getElementById('time');
    const taskList = document.getElementById('task-list');
  
    if(taskInput.value.trim() === "" || timeInput.value === "") {
      alert("Please fill in both task and time.");
      return;
    }
  
    // Create a new list item with a card-like appearance
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${taskInput.value}</strong> at ${timeInput.value}`;
  
    taskList.appendChild(li);
    taskInput.value = "";
    timeInput.value = "";
  }
  
  // Add Transaction for Money Management
  function addTransaction() {
    const amount = document.getElementById('amount').value;
    const type = document.getElementById('transaction-type').value;
    const category = document.getElementById('category').value;
    const date = document.getElementById('transaction-date').value;
    const notes = document.getElementById('transaction-notes').value;
    const transactionList = document.getElementById('transaction-list');
  
    if(amount === "" || category.trim() === "" || date === "") {
      alert("Please complete all required fields.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${type.toUpperCase()}</strong> of $${amount} in ${category} on ${date} <br> ${notes}`;
    transactionList.appendChild(li);
  }
  
  // Add Plan for Long and Short Term Plans
  function addPlan() {
    const plan = document.getElementById('plan').value;
    const planType = document.getElementById('plan-type').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const details = document.getElementById('plan-details').value;
    const planList = document.getElementById('plan-list');
  
    if(plan.trim() === "" || startDate === "" || endDate === "") {
      alert("Please fill in the plan and dates.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${planType.toUpperCase()} PLAN:</strong> ${plan}<br>From ${startDate} to ${endDate}<br>${details}`;
    planList.appendChild(li);
  }
  
  // Add Activity for Timetables
  function addActivity() {
    const activity = document.getElementById('activity').value;
    const activityType = document.getElementById('activity-type').value;
    const activityTime = document.getElementById('activity-time').value;
    const day = document.getElementById('day-of-week').value;
    const activityList = document.getElementById('activity-list');
  
    if(activity.trim() === "" || activityTime === "") {
      alert("Please provide activity details and time.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>${activity}</strong> (${activityType}) at ${activityTime} on ${day}`;
    activityList.appendChild(li);
  }
  
  // Add Clothing for Clothing Arrangement
  function addClothing() {
    const today = document.getElementById('clothing-today').value;
    const tomorrow = document.getElementById('clothing-tomorrow').value;
    const clothingList = document.getElementById('clothing-list');
  
    if(today.trim() === "" || tomorrow.trim() === "") {
      alert("Please enter clothing for both today and tomorrow.");
      return;
    }
  
    const li = document.createElement('li');
    li.classList.add('card-item');
    li.innerHTML = `<strong>Today:</strong> ${today} <br> <strong>Tomorrow:</strong> ${tomorrow}`;
    clothingList.appendChild(li);
  }
  






  function addTask() {
    const task = document.getElementById('task').value;
    const time = document.getElementById('time').value;
  
    if (task && time) {
      const taskList = document.getElementById('task-list');
      const li = document.createElement('li');
      li.textContent = `${task} at ${time}`;
      taskList.appendChild(li);
  
      // Clear the form
      document.getElementById('task').value = '';
      document.getElementById('time').value = '';
    }
  }
  
  function addTransaction() {
    const amount = document.getElementById('amount').value;
    const type = document.getElementById('transaction-type').value;
    const category = document.getElementById('category').value;
    const date = document.getElementById('transaction-date').value;
    const notes = document.getElementById('transaction-notes').value;
  
    if (amount && type && category && date) {
      const transactionList = document.getElementById('transaction-list');
      const li = document.createElement('li');
      li.textContent = `${type}: $${amount} (${category}) on ${date} - ${notes}`;
      transactionList.appendChild(li);
  
      // Clear the form
      document.getElementById('amount').value = '';
      document.getElementById('category').value = '';
      document.getElementById('transaction-date').value = '';
      document.getElementById('transaction-notes').value = '';
    }
  }
  
  function addPlan() {
    const plan = document.getElementById('plan').value;
    const planType = document.getElementById('plan-type').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const details = document.getElementById('plan-details').value;
  
    if (plan && planType && startDate && endDate) {
      const planList = document.getElementById('plan-list');
      const li = document.createElement('li');
      li.textContent = `${planType} Plan: ${plan} from ${startDate} to ${endDate} - ${details}`;
      planList.appendChild(li);
  
      // Clear the form
      document.getElementById('plan').value = '';
      document.getElementById('start-date').value = '';
      document.getElementById('end-date').value = '';
      document.getElementById('plan-details').value = '';
    }
  }
  
  function addActivity() {
    const activity = document.getElementById('activity').value;
    const activityType = document.getElementById('activity-type').value;
    const activityTime = document.getElementById('activity-time').value;
    const dayOfWeek = document.getElementById('day-of-week').value;
  
    if (activity && activityType && activityTime && dayOfWeek) {
      const activityList = document.getElementById('activity-list');
      const li = document.createElement('li');
      li.textContent = `${dayOfWeek}: ${activity} (${activityType}) at ${activityTime}`;
      activityList.appendChild(li);
  
      // Clear the form
      document.getElementById('activity').value = '';
      document.getElementById('activity-time').value = '';
    }
  }
  
  function addClothing() {
    const today = document.getElementById('clothing-today').value;
    const tomorrow = document.getElementById('clothing-tomorrow').value;
  
    if (today && tomorrow) {
      const clothingList = document.getElementById('clothing-list');
      const li = document.createElement('li');
      li.textContent = `Today: ${today}, Tomorrow: ${tomorrow}`;
      clothingList.appendChild(li);
  
      // Clear the form
      document.getElementById('clothing-today').value = '';
      document.getElementById('clothing-tomorrow').value = '';
    }
  }