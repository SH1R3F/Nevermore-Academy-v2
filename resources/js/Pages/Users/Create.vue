<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    roles: Array,
});

const form = useForm({
    name: "",
    email: "",
    mobile: "",
    image: null,
    password: "",
    password_confirmation: "",
    role: "",
});
</script>
<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form @submit.prevent="form.post('/users')">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Create a new user</p>
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
                                User Information
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
                                            for="email"
                                            class="form-control-label"
                                            >Email</label
                                        >
                                        <input
                                            class="form-control"
                                            id="email"
                                            type="email"
                                            v-model="form.email"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.email"
                                            >{{ form.errors.email }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="mobile"
                                            class="form-control-label"
                                            >Mobile</label
                                        >
                                        <input
                                            class="form-control"
                                            id="mobile"
                                            type="text"
                                            v-model="form.mobile"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.mobile"
                                            >{{ form.errors.mobile }}</span
                                        >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="image"
                                            class="form-control-label"
                                            >Profile picture</label
                                        >
                                        <input
                                            class="form-control"
                                            id="image"
                                            type="file"
                                            name="image"
                                            @input="
                                                form.image =
                                                    $event.target.files[0]
                                            "
                                        />
                                        <progress
                                            v-if="form.progress"
                                            :value="form.progress.percentage"
                                            max="100"
                                        >
                                            {{ form.progress.percentage }}%
                                        </progress>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.image"
                                            >{{ form.errors.image }}</span
                                        >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="password"
                                            class="form-control-label"
                                            >Password</label
                                        >
                                        <input
                                            class="form-control"
                                            id="password"
                                            type="password"
                                            v-model="form.password"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.password"
                                            >{{ form.errors.password }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="password_confirmation"
                                            class="form-control-label"
                                            >Password confirmation</label
                                        >
                                        <input
                                            class="form-control"
                                            id="password_confirmation"
                                            type="password"
                                            v-model="form.password_confirmation"
                                        />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="role"
                                            class="form-control-label"
                                            >Role</label
                                        >
                                        <select
                                            class="form-control"
                                            name="role"
                                            id="role"
                                            v-model="form.role"
                                        >
                                            <option
                                                v-for="role in roles"
                                                :value="role.id"
                                                :selected="
                                                    form.role === role.id
                                                "
                                            >
                                                {{ role.name }}
                                            </option>
                                        </select>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.role"
                                            >{{ form.errors.role }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
