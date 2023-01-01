<script setup>
import Pagination from "../../Components/Pagination.vue";
defineProps({
    assignments: Object,
});
</script>
<template>
    <Head title="Assignments" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="card-header pb-0">
                            <h6>Assignments</h6>
                        </div>
                        <div class="px-4 pt-3">
                            <Link
                                :href="route('assignments.create')"
                                class="btn btn-primary"
                                >Create new assignment</Link
                            >
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
                                            Assignment title
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Requirements
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
                                            class="text-secondary opacity-7"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="assignment in assignments.data">
                                        <td style="white-space: normal">
                                            <h6 class="mb-0 text-sm">
                                                {{ assignment.title }}
                                            </h6>
                                        </td>
                                        <td style="white-space: normal">
                                            {{ assignment.requirement }}
                                        </td>
                                        <td>
                                            {{ assignment.teacher.name }}
                                        </td>
                                        <td>
                                            {{ assignment.deadline }}
                                        </td>
                                        <td class="align-middle">
                                            <Link
                                                v-if="assignment.submitable"
                                                :href="
                                                    route(
                                                        'submissions.create',
                                                        assignment.id
                                                    )
                                                "
                                                class="btn btn-primary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Submit assignment"
                                            >
                                                Submit
                                            </Link>
                                            <Link
                                                v-if="assignment.viewable"
                                                :href="
                                                    route(
                                                        'assignments.show',
                                                        assignment.id
                                                    )
                                                "
                                                class="btn btn-primary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Show assignment"
                                            >
                                                Show
                                            </Link>
                                            <Link
                                                v-if="assignment.editable"
                                                :href="
                                                    route(
                                                        'assignments.edit',
                                                        assignment.id
                                                    )
                                                "
                                                class="btn btn-secondary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Edit assignment"
                                            >
                                                Edit
                                            </Link>
                                            <Link
                                                v-if="assignment.deleteable"
                                                :href="
                                                    route(
                                                        'assignments.destroy',
                                                        assignment.id
                                                    )
                                                "
                                                method="delete"
                                                as="button"
                                                class="btn btn-danger font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Delete assignment"
                                            >
                                                Delete
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="!assignments.data.length">
                                        <td colspan="3" class="text-center">
                                            No assignments found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                <Pagination :links="assignments.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
