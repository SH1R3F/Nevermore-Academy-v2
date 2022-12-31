<script setup>
import Guest from "../../Layouts/Guest.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    email: "superadmin@nevermore.dev",
    password: "password",
    remember: false,
});
</script>
<script>
export default { layout: Guest };
</script>

<template>
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto"
                    >
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">
                                    Enter your email and password to sign in
                                </p>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="form.post('/login')">
                                    <div class="mb-3">
                                        <input
                                            name="email"
                                            type="email"
                                            class="form-control form-control-lg"
                                            placeholder="Email"
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
                                            name="password"
                                            type="password"
                                            class="form-control form-control-lg"
                                            placeholder="Password"
                                            aria-label="Password"
                                            v-model="form.password"
                                        />
                                    </div>
                                    <div class="form-check form-switch">
                                        <input
                                            name="remember"
                                            class="form-check-input"
                                            type="checkbox"
                                            id="rememberMe"
                                            v-model="form.remember"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="rememberMe"
                                            >Remember me</label
                                        >
                                    </div>
                                    <div class="text-center">
                                        <button
                                            type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0"
                                            :disabled="form.processing"
                                        >
                                            Sign in
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div
                                class="card-footer text-center pt-0 px-lg-2 px-1"
                            >
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account?
                                    <a
                                        href="#"
                                        class="text-primary text-gradient font-weight-bold"
                                        >Sign up</a
                                    >
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column"
                    >
                        <div
                            class="position-relative bg-gradient-dark h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="
                                background-image: url('/assets/img/nevermore.webp');
                                background-size: cover;
                            "
                        >
                            <span
                                class="mask bg-gradient-dark opacity-6"
                            ></span>
                            <h4
                                class="mt-5 text-white font-weight-bolder position-relative"
                            >
                                "Academic institution that nurtures outcasts"
                            </h4>
                            <p class="text-white position-relative">
                                Nevermore is a safe haven for our students to
                                learn and grow no matter who they are.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
