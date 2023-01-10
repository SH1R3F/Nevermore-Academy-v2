<script setup>
import Aside from "../Components/Layouts/Aside.vue";
import Navbar from "../Components/Layouts/Navbar.vue";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
import axios from "axios";

const messaging = getMessaging();
getToken(messaging, {
    vapidKey:
        "BN19sbYah0kywjaqKS86Mf5P13ASILekdLI0qoZsub03pah-1PMW7XP0oYqZGsNUjwY-e9rV_IGXa43-IzBA3YI",
})
    .then((currentToken) => {
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            axios.post(route("save-device-token"), {
                token: currentToken,
            });
        } else {
            // Show permission request UI
            console.log(
                "No registration token available. Request permission to generate one."
            );
            // ...
        }
    })
    .catch((err) => {
        console.log("An error occurred while retrieving token. ", err);
        // ...
    });

onMessage(messaging, (payload) => {
    // Should get some ui work
    alert("New notification. ", payload.notification.body);
    // ...
});
</script>

<template>
    <Head :title="__('Nevermore academy')" />
    <div>
        <div class="min-height-300 bg-primary position-absolute w-100"></div>

        <Aside />

        <main
            class="main-content position-relative border-radius-lg min-vh-100"
        >
            <Navbar />
            <slot />
        </main>
    </div>
</template>
