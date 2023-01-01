<script setup>
defineProps({
    submission: Object,
    assignment: Object,
});
</script>

<template>
    <Head :title="`Your submission for assignment ${assignment.title}`" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-5">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Your submission for assignment <b>{{ assignment.title }}</b></p>
                    </div>
                    <p class="mb-0">Assignment deadline:
                        <span class="text-bolder">{{ assignment.deadline }}</span>
                    </p>

                    <hr>

                    <p class="mb-0">Your submission message:
                        <pre class="text-bolder">{{ submission.message }}</pre>
                    </p>
                    <p class="mb-0">Your submission file:
                        <a :href="`/storage/${submission.file}`" target="_blank">Click here</a>
                    </p>

                    <h1 class="mb-0">Your degree is: <b>{{ submission.degree || 'Not degreed yet' }}</b>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</template>
