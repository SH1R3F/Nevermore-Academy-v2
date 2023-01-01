<script setup>
import Guest from "../../Layouts/Guest.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    name: "",
    email: "",
    mobile: "",
    password: "",
    password_confirmation: "",
    image: null,
});
</script>
<script>
export default { layout: Guest };
</script>

<template>
    <Head title="Register" />
    <div
        class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="
            background-image: url('/assets/img/nevermore.webp');
            background-position: center;
        "
    >
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">{{ __("Welcome!") }}</h1>
                    <p class="text-lead text-white">
                        {{
                            __(
                                "Nevermore is a safe haven for our students to learn and grow no matter who they are."
                            )
                        }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <form @submit.prevent="form.post(route('register'))">
                            <div class="mb-3">
                                <input
                                    name="name"
                                    type="text"
                                    class="form-control"
                                    :placeholder="__('Name')"
                                    v-model="form.name"
                                />
                                <span
                                    class="text-danger text-sm"
                                    v-if="form.errors.name"
                                    >{{ form.errors.name }}</span
                                >
                            </div>
                            <div class="mb-3">
                                <input
                                    name="email"
                                    type="email"
                                    class="form-control"
                                    :placeholder="__('Email')"
                                    aria-label="Email"
                                    v-model="form.email"
                                />
                                <span
                                    class="text-danger text-sm"
                                    v-if="form.errors.email"
                                    >{{ form.errors.email }}</span
                                >
                            </div>
                            <div class="mb-3">
                                <input
                                    name="mobile"
                                    type="text"
                                    class="form-control"
                                    :placeholder="__('Mobile; eg: 01234567890')"
                                    aria-label="Mobile"
                                    v-model="form.mobile"
                                />
                                <span
                                    class="text-danger text-sm"
                                    v-if="form.errors.mobile"
                                    >{{ form.errors.mobile }}</span
                                >
                            </div>
                            <div class="mb-3">
                                <input
                                    name="password"
                                    type="password"
                                    class="form-control"
                                    :placeholder="__('Password')"
                                    aria-label="Password"
                                    v-model="form.password"
                                />
                                <span
                                    class="text-danger text-sm"
                                    v-if="form.errors.password"
                                    >{{ form.errors.password }}</span
                                >
                            </div>
                            <div class="mb-3">
                                <input
                                    name="password_confirmation"
                                    type="password"
                                    class="form-control"
                                    :placeholder="__('Confirm password')"
                                    aria-label="Password"
                                    v-model="form.password_confirmation"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="image"
                                    >{{ __("Profile picture") }}
                                </label>
                                <input
                                    name="image"
                                    id="image"
                                    type="file"
                                    class="form-control"
                                    @input="form.image = $event.target.files[0]"
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
                            <div class="text-center">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="btn bg-gradient-dark w-100 my-4 mb-2"
                                >
                                    {{ __("Sign up") }}
                                </button>
                            </div>
                            <p class="text-sm mt-3 mb-0">
                                {{ __("Already have an account?") }}
                                <Link
                                    :href="route('login')"
                                    class="text-dark font-weight-bolder"
                                    >{{ __("Login") }}</Link
                                >
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
