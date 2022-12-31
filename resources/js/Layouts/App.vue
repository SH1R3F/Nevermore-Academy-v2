<script setup>
import Aside from "../Components/Layouts/Aside.vue";
import Navbar from "../Components/Layouts/Navbar.vue";
</script>

<template>
    <Head title="Nevermore academy" />
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
