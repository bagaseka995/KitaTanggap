// firebase-messaging.js

// Firebase configuration
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_PROJECT_ID.appspot.com",
    messagingSenderId: "YOUR_MESSAGING_SENDER_ID",
    appId: "YOUR_APP_ID"
};

// Initialize Firebase if not already initialized
if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
}

const messaging = firebase.messaging();

// Setup Service Worker
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
    .then((registration) => {
        messaging.useServiceWorker(registration);
        
        // Request permission
        requestNotificationPermission();
    })
    .catch((err) => {
        console.error('Service worker registration failed:', err);
    });
}

function requestNotificationPermission() {
    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            console.log('Notification permission granted.');
            getToken();
        } else {
            console.warn('Unable to get permission to notify.');
        }
    });
}

function getToken() {
    messaging.getToken({ vapidKey: 'YOUR_PUBLIC_VAPID_KEY_HERE' })
    .then((currentToken) => {
        if (currentToken) {
            console.log('FCM Token:', currentToken);
            sendTokenToServer(currentToken);
        } else {
            console.log('No registration token available. Request permission to generate one.');
        }
    })
    .catch((err) => {
        console.error('An error occurred while retrieving token. ', err);
    });
}

function sendTokenToServer(token) {
    // Check if the user is authenticated (usually check a meta tag or just try to send)
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    fetch('/api/fcm/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            // Assuming the app uses Sanctum for SPA auth, credentials include cookies
            // Otherwise, an Authorization header with Bearer token is needed.
        },
        // 'credentials': 'include', if using Sanctum stateful auth
        body: JSON.stringify({ fcm_token: token })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Token successfully sent to server:', data);
    })
    .catch(error => {
        console.error('Error sending token to server:', error);
    });
}

messaging.onMessage((payload) => {
    console.log('[firebase-messaging.js] Received foreground message ', payload);
    // You can display a custom UI alert here
    alert(`Peringatan Dini: ${payload.notification.title}\n${payload.notification.body}`);
});
