// sw.js - Service Worker
self.addEventListener('push', event => {
    const data = event.data.json();
    self.registration.showNotification(data.title, {
      body: data.body,
      icon: '/icon.png'
    });
  });
  
  self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(
      clients.matchAll({ type: 'window' }).then(clientList => {
        for (const client of clientList) {
          if (client.url === '/' && 'focus' in client) return client.focus();
        }
        if (clients.openWindow) return clients.openWindow('/');
      })
    );
});



function addActivity() {
    // ... existing code ...
    
    // Schedule class notification
    const [hours, minutes] = activityTime.split(':');
    const notificationTime = new Date();
    notificationTime.setHours(hours);
    notificationTime.setMinutes(minutes);
    
    scheduleNotification('Class Reminder', activity, notificationTime);
  }