<script setup>
import Pagination from "../../Components/Pagination.vue";
defineProps({
    roles: Object,
    can: Object,
});
</script>

<template>
    <Head title="Roles of the site" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="card-header pb-0">
                            <h6>Roles of the site</h6>
                        </div>
                        <div class="px-4 pt-3" v-if="can.create_role">
                            <Link href="/roles/create" class="btn btn-primary"
                                >Create new role</Link
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
                                            Role
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Description
                                        </th>
                                        <th
                                            class="text-secondary opacity-7"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="role in roles.data">
                                        <td>
                                            <h6 class="mb-0 text-sm">
                                                {{ role.name }}
                                            </h6>
                                        </td>
                                        <td>
                                            {{ role.description }}
                                        </td>
                                        <td class="align-middle">
                                            <Link
                                                v-if="role.editable"
                                                :href="`/roles/${role.id}/edit`"
                                                class="btn btn-secondary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Edit role"
                                            >
                                                Edit
                                            </Link>

                                            <Link
                                                v-if="role.deleteable"
                                                as="button"
                                                method="delete"
                                                :href="`/roles/${role.id}`"
                                                class="btn btn-danger font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Delete role"
                                            >
                                                Delete
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="!roles.data.length">
                                        <td colspan="3" class="text-center">
                                            No roles found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                <Pagination :links="roles.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
