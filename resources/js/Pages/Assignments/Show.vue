<script setup>
defineProps({
    assignment: Object,
    can: Object,
});
</script>

<template>
    <Head :title="__('Assignment :title', { title: assignment.title })" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-5">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">
                            {{
                                __("Assignment :title", {
                                    title: assignment.title,
                                })
                            }}
                        </p>
                        <Link
                            v-if="can.update_assignment"
                            :href="route('assignments.edit', assignment.id)"
                            class="btn btn-primary btn-sm ms-auto"
                            >{{ __("Edit") }}</Link
                        >
                    </div>

                    <p class="mb-0">{{ __("Required Information") }}:</p>
                    <pre class="text-bolder">{{ assignment.requirement }}</pre>

                    <p class="mb-0">
                        {{ __("Deadline") }}:
                        <span class="text-bolder">{{
                            assignment.deadline
                        }}</span>
                    </p>

                    <hr />

                    <p class="mb-0">
                        {{ __("Total submissions") }}:
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
                                        >{{ __("Degree") }}:
                                        {{ submission.degree }}</span
                                    >
                                    <Link
                                        :href="
                                            route(
                                                'submissions.edit',
                                                submission.id
                                            )
                                        "
                                        class="btn btn-default btn-sm"
                                        >{{ __("Show submission") }}</Link
                                    >
                                </div>
                                <div v-else>
                                    <Link
                                        v-if="submission.editable"
                                        :href="
                                            route(
                                                'submissions.edit',
                                                submission.id
                                            )
                                        "
                                        class="btn btn-primary btn-sm ms-auto"
                                        >{{ __("Give degree") }}</Link
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
