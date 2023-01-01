<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    title: "",
    requirement: "",
    deadline: "",
});
</script>

<template>
    <Head title="Create a new assignment" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="form.post(route('assignments.store'))"
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Create a new assignment</p>
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
                                Assignment Information
                            </p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="title"
                                            class="form-control-label"
                                            >Title</label
                                        >
                                        <input
                                            class="form-control"
                                            id="title"
                                            type="text"
                                            v-model="form.title"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.title"
                                            >{{ form.errors.title }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="requirement"
                                            class="form-control-label"
                                            >Requirement</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="requirement"
                                            type="text"
                                            v-model="form.requirement"
                                        ></textarea>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.requirement"
                                            >{{ form.errors.requirement }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="deadline"
                                            class="form-control-label"
                                            >Deadline</label
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
