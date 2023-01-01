<script setup>
import Pagination from "../../Components/Pagination.vue";
defineProps({
    submissions: Object,
});
</script>

<template>
    <Head title="My submission" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="card-header pb-0">
                            <h6>My submission</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        >
                                            Assignment
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Teacher
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Deadline
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Submission date
                                        </th>
                                        <th
                                            class="text-secondary opacity-7"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="submission in submissions.data">
                                        <td style="white-space: normal">
                                            <h6 class="mb-0 text-sm">
                                                {{
                                                    submission.assignment.title
                                                }}
                                            </h6>
                                        </td>
                                        <td style="white-space: normal">
                                            {{
                                                submission.assignment.teacher
                                                    .name
                                            }}
                                        </td>
                                        <td>
                                            {{ submission.assignment.deadline }}
                                        </td>
                                        <td>
                                            {{ submission.created_at }}
                                        </td>
                                        <td class="align-middle">
                                            <Link
                                                v-if="submission.viewable"
                                                :href="
                                                    route(
                                                        'submissions.show',
                                                        submission.assignment.id
                                                    )
                                                "
                                                class="btn btn-primary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Show assignment"
                                            >
                                                Show submission
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="!submissions.data.length">
                                        <td colspan="5" class="text-center">
                                            You don't have any submissions yet
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                <Pagination :links="submissions.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
