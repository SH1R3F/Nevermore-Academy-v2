<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    title_ar: "",
    title_en: "",
    requirement_ar: "",
    requirement_en: "",
    deadline: "",
});
</script>

<template>
    <Head :title="__('Create a new assignment')" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="form.post(route('assignments.store'))"
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">
                                    {{ __("Create a new assignment") }}
                                </p>
                                <button
                                    class="btn btn-primary btn-sm ms-auto"
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ __("Save") }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">
                                {{ __("Required Information") }}
                            </p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="title"
                                            class="form-control-label"
                                            >{{ __("Title") }} ({{
                                                __("In Arabic")
                                            }})</label
                                        >
                                        <input
                                            class="form-control"
                                            id="title"
                                            type="text"
                                            v-model="form.title_ar"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.title_ar"
                                            >{{ form.errors.title_ar }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="title"
                                            class="form-control-label"
                                            >{{ __("Title") }} ({{
                                                __("In English")
                                            }})</label
                                        >
                                        <input
                                            class="form-control"
                                            id="title"
                                            type="text"
                                            v-model="form.title_en"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.title_en"
                                            >{{ form.errors.title_en }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="requirement"
                                            class="form-control-label"
                                            >{{ __("Requirement") }} ({{
                                                __("In Arabic")
                                            }})</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="requirement"
                                            type="text"
                                            v-model="form.requirement_ar"
                                        ></textarea>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.requirement_ar"
                                            >{{
                                                form.errors.requirement_ar
                                            }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="requirement"
                                            class="form-control-label"
                                            >{{ __("Requirement") }} ({{
                                                __("In English")
                                            }})</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="requirement"
                                            type="text"
                                            v-model="form.requirement_en"
                                        ></textarea>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.requirement_en"
                                            >{{
                                                form.errors.requirement_en
                                            }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="deadline"
                                            class="form-control-label"
                                            >{{ __("Deadline") }}</label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="deadline"
                                            name="deadline"
                                            v-model="form.deadline"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.deadline"
                                            >{{ form.errors.deadline }}</span
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
