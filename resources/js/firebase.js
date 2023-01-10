import { initializeApp } from "firebase/app";
import { getMessaging } from "firebase/messaging/sw";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyA8FqXh59mrmn-qnM1D96Z11AcdsxDRGic",
    authDomain: "inspiring-modem-370612.firebaseapp.com",
    databaseURL: "https://inspiring-modem-370612.firebaseio.com",
    projectId: "inspiring-modem-370612",
    storageBucket: "inspiring-modem-370612.appspot.com",
    messagingSenderId: "64523082056",
    appId: "1:64523082056:web:584f21319e6e8ae823fb7d",
    // measurementId: "G-measurement-id",
};

const app = initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = getMessaging(app);
