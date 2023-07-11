// importScripts('https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js');
// importScripts('https://www.gstatic.com/firebasejs/9.22.1/firebase-messaging.js');

// firebase.initializeApp({
//   apiKey: "AIzaSyBCgMdI7nz_rqBP1lOn6q2BLp0ZKxikFS0",
//   authDomain: "ambilin-d55fc.firebaseapp.com",
//   projectId: "ambilin-d55fc",
//   storageBucket: "ambilin-d55fc.appspot.com",
//   messagingSenderId: "601300765463",
//   appId: "1:601300765463:web:68f0c29aa4df1da43d0552",
//   measurementId: "G-EJ8P5GS4GQ"
// });

// const messaging = firebase.messaging();
// messaging.setBackgroundMessageHandler(function(payload) {
//   console.log(
//       "[firebase-messaging-sw.js] Received background message ",
//       payload,
//   );

//   const notificationTitle = "Background Message Title";
//   const notificationOptions = {
//       body: "Background Message body.",
//       icon: "/itwonders-web-logo.png",
//   };

//   return self.registration.showNotification(
//       notificationTitle,
//       notificationOptions,
//   );

// });

/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts("https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js");

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
  apiKey: "AIzaSyBCgMdI7nz_rqBP1lOn6q2BLp0ZKxikFS0",
  authDomain: "ambilin-d55fc.firebaseapp.com",
  projectId: "ambilin-d55fc",
  storageBucket: "ambilin-d55fc.appspot.com",
  messagingSenderId: "601300765463",
  appId: "1:601300765463:web:68f0c29aa4df1da43d0552",
  measurementId: "G-EJ8P5GS4GQ",
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
  console.log(
    "[firebase-messaging-sw.js] Received background message ",
    payload
  );
  // Customize notification here
  const notificationTitle = "Background Message Title";
  const notificationOptions = {
    body: "Background Message body.",
    icon: "/firebase-logo.png",
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions
  );
});

// self.addEventListener("push", (event) => {
//   console.log(event);
//   let response = event.data && event.data.text();
//   let title = JSON.parse(response).notification.title;
//   let body = JSON.parse(response).notification.body;
//   let icon = JSON.parse(response).notification.image;
//   let image = JSON.parse(response).notification.image;

//   event.waitUntil(
//     self.registration.showNotification(title, {
//       body,
//       icon,
//       image,
//       data: { url: "https://ambilin.com/ambilinapps/dashboard" },
//     })
//   );
// });

// self.addEventListener("notificationclick", function (event) {
//   event.notification.close();
//   event.waitUntil(clients.openWindow(event.notification.data.url));
// });
