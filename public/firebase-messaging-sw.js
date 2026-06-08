importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js');

// Default config (the actual config should be the same as the client)
// We will rely on Firebase's standard initialization here, but it's often passed dynamically.
// For the service worker to receive background messages, it needs firebase.initializeApp().
// Note: It's best practice to hardcode the config here or use URL parameters, 
// since the service worker runs in a separate thread.
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_PROJECT_ID.appspot.com",
    messagingSenderId: "YOUR_MESSAGING_SENDER_ID",
    appId: "YOUR_APP_ID"
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/favicon.ico', // Update with your own icon
    data: payload.data,
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('notificationclick', function(event) {
    console.log('[firebase-messaging-sw.js] Notification click Received.', event);
    
    event.notification.close();
    
    // This looks to see if the current is already open and focuses if it is
    event.waitUntil(
        clients.matchAll({
            type: "window"
        }).then(function(clientList) {
            let click_action = '/';
            if (event.notification.data && event.notification.data.click_action) {
                click_action = event.notification.data.click_action;
            }

            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if (client.url.indexOf(click_action) !== -1 && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(click_action);
            }
        })
    );
});
