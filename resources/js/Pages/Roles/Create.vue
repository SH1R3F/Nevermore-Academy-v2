<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    permissions: Object,
});

const form = useForm({
    name: "",
    description: "",
    permissions: {},
});
</script>

<template>
    <Head title="Create new role" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form @submit.prevent="form.post(route('roles.store'))">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Create a new role</p>
                                <button
                                    class="btn btn-primary btn-sm ms-auto"
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">
                                Role Information
                            </p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="name"
                                            class="form-control-label"
                                            >Name</label
                                        >
                                        <input
                                            class="form-control"
                                            id="name"
                                            type="text"
                                            v-model="form.name"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.name"
                                            >{{ form.errors.name }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="description"
                                            class="form-control-label"
                                            >Description</label
                                        >
                                        <input
                                            class="form-control"
                                            id="description"
                                            type="text"
                                            v-model="form.description"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.description"
                                            >{{ form.errors.description }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        >
                                            permission
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
                                    <tr v-for="permission in permissions">
                                        <td>
                                            <h6 class="mb-0 text-sm">
                                                <label
                                                    for="{{ permission.slug }}"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        v-model="
                                                            form.permissions[
                                                                permission.slug
                                                            ]
                                                        "
                                                        id="{{ permission.slug }}"
                                                    />
                                                    {{ permission.slug }}
                                                </label>
                                            </h6>
                                        </td>
                                        <td>
                                            {{ permission.description }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
