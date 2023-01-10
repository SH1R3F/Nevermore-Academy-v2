importScripts("https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyA8FqXh59mrmn-qnM1D96Z11AcdsxDRGic",
    authDomain: "inspiring-modem-370612.firebaseapp.com",
    databaseURL: "https://inspiring-modem-370612.firebaseio.com",
    projectId: "inspiring-modem-370612",
    storageBucket: "inspiring-modem-370612.appspot.com",
    messagingSenderId: "64523082056",
    appId: "1:64523082056:web:584f21319e6e8ae823fb7d",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );

    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});
