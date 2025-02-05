<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KAVWENJE</title>
    <link rel="stylesheet" href="style.css" />
    
    <style>
body {  
  font-family: Arial, sans-serif;  
  margin: 0;  
  padding: 0;  
  background-color: #f4f4f4;  
}  

header {  
  background-color: #333;  
  color: white;  
  padding: 1rem;  
  text-align: center;  
}  

.card-section {  
  margin: 1rem;  
}  

/* Flexbox Layout for Better Responsiveness */  
.card {  
  display: flex; /* Use flex for layout */  
  flex-direction: row; /* Default layout direction */  
  background: white;  
  border-radius: 8px;  
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  
  overflow: hidden;  
  transition: transform 0.3s ease, box-shadow 0.3s ease;  
  animation: fadeIn 0.5s ease; /* Moved animation here for better organization */  
}  

.card:hover {  
  transform: translateY(-5px);  
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);  
}  

.form-container {  
  flex: 1; /* Allow form-container to take available space */  
  padding: 1rem;  
}  

.data-container {  
  flex: 1; /* Allow data-container to take available space */  
  padding: 1rem;  
  overflow-y: auto;  
  max-height: 200px;  
}  

ul {  
  list-style-type: none;  
  padding: 0;  
  margin: 0;  
}  

li {  
  padding: 0.5rem;  
  border-bottom: 1px solid #ddd;  
  transition: background-color 0.3s ease;  
}  

li:hover {  
  background-color: #f9f9f9;  
}  
/* Add these responsive styles */
@media (max-width: 768px) {
  /* General mobile adjustments */
  .card {
    margin: 10px 0;
    padding: 10px;
  }

  /* Form elements mobile optimization */
  input, select, textarea, button {
    width: 100% !important;
    box-sizing: border-box;
  }

  /* Timetable specific fixes */
  #activity-list li {
    padding: 8px;
    font-size: 0.9em;
  }

  .activity-time {
    display: block;
    margin-bottom: 5px;
  }

  /* Graph container adjustments */
  .graphs-card {
    flex-direction: column;
  }

  .graphs-card .data-container {
    width: 100% !important;
    margin: 10px 0;
  }

  /* Daily schedule adjustments */
  #task-list li {
    word-break: break-word;
    padding: 8px 0;
  }

  /* Clothing arrangement fixes */
  #clothing-list li {
    font-size: 0.9em;
  }

  /* Form container spacing */
  .form-container {
    padding: 10px;
  }
}

/* Add these graph-specific styles */
.graphs-card {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.graphs-card .data-container {
  width: 48%;
  min-width: 300px;
  margin: 1%;
}

/* Timetable specific improvements */
#activity-list {
  padding: 0;
}

#activity-list li {
  background: #f8f9fa;
  margin: 8px 0;
  padding: 12px;
  border-radius: 6px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.activity-time {
  font-weight: bold;
  margin-right: 15px;
}

/* Ensure charts are responsive */
canvas {
  max-width: 100%;
  height: auto !important;
}
.floating-button {
  position: fixed;
  right: 20px;
  background-color: #007bff; 
  color: white;
  border: none;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  font-size: 16px;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none; 
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.floating-button:hover {
  background-color: #0056b3;
  transform: scale(1.1);
}

/* Adjust button positions */
.floating-button:nth-child(1) { bottom: 100px; } /* First button */
.floating-button:nth-child(2) { bottom: 170px; } /* Second button */
.floating-button:nth-child(3) { bottom: 240px; } /* Third button */

    </style>
    <script>
  document.querySelector('.floating-button').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default link behavior
    window.location.href = 'math.php'; // Redirect to math.php
  });
</script>
<!-- Add this in the head section -->
<script>
// Request notification permission
function requestNotificationPermission() {
  if (Notification.permission !== 'granted') {
    Notification.requestPermission().then(permission => {
      if (permission === 'granted') {
        console.log('Notification permission granted');
      }
    });
  }
}

// Initialize service worker
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('sw.js')
    .then(registration => {
      console.log('ServiceWorker registration successful');
    })
    .catch(err => {
      console.log('ServiceWorker registration failed: ', err);
    });
}

// Function to schedule notification
function scheduleNotification(title, body, time) {
  if (Notification.permission === 'granted') {
    const now = new Date().getTime();
    const scheduleTime = new Date(time).getTime();
    const timeout = scheduleTime - now;

    if (timeout > 0) {
      setTimeout(() => {
        new Notification(title, {
          body: body,
          icon: '/icon.png' // Add your notification icon
        });
      }, timeout);
    }
  }
}

// Modified addTask function with notifications
function addTask() {
  const task = document.getElementById('task').value;
  const time = document.getElementById('time').value;
  
  if (task && time) {
    const taskList = document.getElementById('task-list');
    const li = document.createElement('li');
    li.textContent = `${task} at ${time}`;
    taskList.appendChild(li);

    // Schedule notification
    const [hours, minutes] = time.split(':');
    const notificationTime = new Date();
    notificationTime.setHours(hours);
    notificationTime.setMinutes(minutes);
    
    scheduleNotification('Task Reminder', task, notificationTime);
    
    // Store in localStorage
    const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
    tasks.push({ task, time });
    localStorage.setItem('tasks', JSON.stringify(tasks));

    document.getElementById('task').value = '';
    document.getElementById('time').value = '';
  }
}

// Initialize on page load
window.addEventListener('load', () => {
  requestNotificationPermission();
  
  // Load existing tasks
  const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
  tasks.forEach(task => {
    const li = document.createElement('li');
    li.textContent = `${task.task} at ${task.time}`;
    document.getElementById('task-list').appendChild(li);
  });
});
</script>

  </head>
  <body>
    <header>
      <h1>KAVWENJE</h1>
    </header>
   
    <main>
      <!-- Floating Buttons -->
<a href="spending.php" class="floating-button">Spender</a>
<a href="income.php" class="floating-button">Income</a>


      <!-- Daily Schedule Section -->
      <section id="daily-schedule" class="card-section">
        <h2>Daily Schedule</h2>
        <div class="card">
          <div class="form-container">
            <form id="schedule-form">
              <input type="text" id="task" placeholder="Enter Task" /><br /><br />
              <input type="time" id="time" /><br /><br />
              <button type="button" onclick="addTask()">Add Task</button>
            </form>
          </div>
          <div class="data-container">
            <ul id="task-list"></ul>
          </div>
        </div>
      </section>
<!-- Floating Button -->

      <!-- Money Management Section -->
      <section id="money-management" class="card-section">
        <h2>Money Management</h2>
        <div class="card">
          <div class="form-container">
            <form id="money-form">
              <input type="number" id="amount" placeholder="Amount" /><br /><br />
              <select id="transaction-type">
                <option value="income">Income</option>
                <option value="expense">Expense</option>
              </select><br /><br />
              <input type="text" id="category" placeholder="Category" /><br /><br />
              <input type="date" id="transaction-date" /><br /><br />
              <textarea id="transaction-notes" placeholder="Notes"></textarea
              ><br /><br />
              <button type="button" onclick="addTransaction()">Add Transaction</button>
            </form>
          </div>
          <div class="data-container">
            <ul id="transaction-list"></ul>
          </div>
        </div>
      </section>

      <!-- Long and Short Term Plans Section -->
      <section id="long-short-term-plans" class="card-section">
        <h2>Long and Short Term Plans</h2>
        <div class="card">
          <div class="form-container">
            <form id="plans-form">
              <input type="text" id="plan" placeholder="Enter Plan" /><br /><br />
              <select id="plan-type">
                <option value="long-term">Long Term</option>
                <option value="short-term">Short Term</option>
              </select><br /><br />
              <input type="date" id="start-date" placeholder="Start Date" /><br /><br />
              <input type="date" id="end-date" placeholder="End Date" /><br /><br />
              <textarea id="plan-details" placeholder="Details"></textarea
              ><br /><br />
              <button type="button" onclick="addPlan()">Add Plan</button>
            </form>
          </div>
          <div class="data-container">
            <ul id="plan-list"></ul>
          </div>
        </div>
      </section>

      <!-- Timetables Section -->
      <section id="timetables" class="card-section">
        <h2>Timetables</h2>
        <div class="card">
          <div class="form-container">
            <form id="timetable-form">
              <input type="text" id="activity" placeholder="Enter Activity" /><br /><br />
              <select id="activity-type">
                <option value="school">School</option>
                <option value="reading">Reading</option>
                <option value="discussion">Discussion</option>
                <option value="family_time">Family Time</option>
                <option value="friends_time">Friends Time</option>
              </select><br /><br />
              <input type="time" id="activity-time" /><br /><br />
              <select id="day-of-week">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
              </select><br /><br />
              <button type="button" onclick="addActivity()">Add Activity</button>
            </form>
          </div>
          <div class="data-container">
            <!-- You can use PHP or fetch API to load timetable data here -->
            <?php include 'fetch_timetables.php'; ?>
            <ul id="activity-list"></ul>
          </div>
        </div>
      </section>

      <!-- Clothing Arrangement Section -->
      <section id="clothing-arrangement" class="card-section">
        <h2>Clothing Arrangement</h2>
        <div class="card">
          <div class="form-container">
            <form id="clothing-form">
              <input type="text" id="clothing-today" placeholder="Today's Clothing" /><br /><br />
              <input type="text" id="clothing-tomorrow" placeholder="Tomorrow's Clothing" /><br /><br />
              <button type="button" onclick="addClothing()">Add Clothing</button>
            </form>
          </div>
          <div class="data-container">
            <ul id="clothing-list"></ul>
          </div>
        </div>
      </section>

      <!-- Graphs Section -->
      <section id="graphs" class="card-section">
        <h2>Graphs</h2>
        <div class="card graphs-card">
          <div class="data-container">
            <canvas id="dailyTasksChart"></canvas>
          </div>
          <div class="data-container">
            <canvas id="expenseChart"></canvas>
          </div>
        </div>
      </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
  </body>
</html>
