<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    user: Object,
    roles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    mobile: props.user.mobile,
    password: props.user.password,
    image: null,
    password_confirmation: props.user.password_confirmation,
    role: props.user.role_id,
    _method: "PUT",
});
</script>

<template>
    <Head :title="`Edit user ${user.name}`" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form @submit.prevent="form.post(`/users/${user.id}`)">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">
                                    Edit user <b>{{ user.name }}</b>
                                </p>
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
                                        <span class="text-muted text-sm"
                                            >Leave empty if you don't want to
                                            change it</span
                                        >
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
                                            name="password_confirmation"
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
                                            v-model="form.role"
                                            id="role"
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
            <div class="col-md-4">
                <div class="card card-profile">
                    <img
                        src="/assets/img/nevermore.webp"
                        alt="Nevermore academy"
                        class="card-img-top"
                    />
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <a href="javascript:;">
                                    <img
                                        :src="
                                            user.avatar ||
                                            '/assets/img/logo.webp'
                                        "
                                        class="rounded-circle img-fluid border border-2 border-white"
                                    />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-center mt-4">
                            <h5>
                                {{ form.name }}
                            </h5>
                            <div class="h6 font-weight-300 text-muted">
                                {{
                                    roles.find((role) => role.id === form.role)
                                        .name
                                }}
                            </div>
                            <div class="h6 mt-4">
                                {{ form.mobile }}
                            </div>
                            <div>
                                {{ form.email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
