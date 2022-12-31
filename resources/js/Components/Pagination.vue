<script setup>
defineProps({
    links: Array,
});
</script>

<template>
    <div>
        <component
            v-for="link in links"
            :key="link.label"
            :href="link.url"
            :is="link.url ? 'Link' : 'span'"
            v-html="link.label"
            class="mx-1 btn btn-primary btn-sm"
            :class="{ 'btn-success': link.active }"
        >
        </component>
    </div>
</template>
