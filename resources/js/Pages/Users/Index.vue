<script setup>
import Pagination from "../../Components/Pagination.vue";
defineProps({
    users: Object,
    can: Object,
});
</script>

<template>
    <Head title="Users of the site" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="card-header pb-0">
                            <h6>Users of the site</h6>
                        </div>
                        <div class="px-4 pt-3" v-if="can.create_user">
                            <Link
                                :href="route('users.create')"
                                class="btn btn-primary"
                                >Create new user</Link
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
                                            User
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Role
                                        </th>
                                        <th
                                            class="text-secondary opacity-7"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="user in users.data"
                                        :key="user.id"
                                    >
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img
                                                        :src="
                                                            user.avatar ||
                                                            '/assets/img/logo.webp'
                                                        "
                                                        class="avatar avatar-sm me-3"
                                                        :alt="user.name"
                                                    />
                                                </div>
                                                <div
                                                    class="d-flex flex-column justify-content-center"
                                                >
                                                    <h6 class="mb-0 text-sm">
                                                        {{ user.name }}
                                                    </h6>
                                                    <p
                                                        class="text-xs text-secondary mb-0"
                                                    >
                                                        {{ user.email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ user.role?.name }}
                                        </td>
                                        <td class="align-middle">
                                            <Link
                                                v-if="user.editable"
                                                :href="
                                                    route('users.edit', user.id)
                                                "
                                                class="btn btn-secondary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Edit user"
                                            >
                                                Edit
                                            </Link>
                                            <Link
                                                v-if="user.deleteable"
                                                :href="
                                                    route(
                                                        'users.destroy',
                                                        user.id
                                                    )
                                                "
                                                method="delete"
                                                as="button"
                                                class="btn btn-danger font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Delete user"
                                            >
                                                Delete
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="!users.data.length">
                                        <td colspan="3" class="text-center">
                                            No users found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                <Pagination :links="users.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
