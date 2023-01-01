<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    assignment: Object,
});

const form = useForm({
    title: props.assignment.title,
    requirement: props.assignment.requirement,
    deadline: props.assignment.deadline,
});
</script>

<template>
    <Head :title="`Edit assignment ${assignment.title}`" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="
                            form.put(`/assignments/{assignment.id}`)
                        "
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">
                                    Edit assignment
                                    <b>{{ assignment.title }}</b>
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
                                            class="form-control"
                                            id="deadline"
                                            type="date"
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
