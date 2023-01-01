<script setup>
defineProps({
    assignment: Object,
    can: Object,
});
</script>

<template>
    <Head :title="`Assignment ${assignment.title}`" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-5">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">
                            Assignment <b>{{ assignment.title }}</b>
                        </p>
                        <Link
                            v-if="can.update_assignment"
                            :href="`/assignments/${assignment.id}/edit`"
                            class="btn btn-primary btn-sm ms-auto"
                            >Edit</Link
                        >
                    </div>

                    <p class="mb-0">Assignment requirement:</p>
                    <pre class="text-bolder">{{ assignment.requirement }}</pre>

                    <p class="mb-0">
                        Assignment deadline:
                        <span class="text-bolder">{{
                            assignment.deadline
                        }}</span>
                    </p>

                    <hr />

                    <p class="mb-0">
                        Total submissions:
                        <span class="text-bolder">
                            {{
                                assignment.submissions_count ||
                                "No submissions yet"
                            }}
                        </span>
                    </p>

                    <ul>
                        <li
                            class="w-50"
                            v-for="submission in assignment.submissions"
                        >
                            <div
                                class="d-flex align-items-center justify-content-between"
                            >
                                <p class="mb-0">
                                    <b>{{ submission.student.name }}</b>
                                </p>
                                <div v-if="submission.degree">
                                    <span class="text-bolder"
                                        >Degree: {{ submission.degree }}</span
                                    >
                                    <Link
                                        :href="`/submissions/${submission.id}`"
                                        class="btn btn-default btn-sm"
                                        >Show submission</Link
                                    >
                                </div>
                                <div v-else>
                                    <Link
                                        v-if="submission.editable"
                                        :href="`/submissions/${submission.id}`"
                                        class="btn btn-primary btn-sm ms-auto"
                                        >Give degree</Link
                                    >
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
