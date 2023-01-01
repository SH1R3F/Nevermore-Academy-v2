<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    assignment: Object,
});

const form = useForm({
    message: "",
    file: null,
});
</script>

<template>
    <Head title="Submit to an assignment" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="
                            form.post(route('submissions.store', assignment.id))
                        "
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">
                                    Submit to assignment:
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
                            <p class="text-uppercase text-sm">Submission</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="message"
                                            class="form-control-label"
                                            >Message</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="message"
                                            type="text"
                                            v-model="form.message"
                                        ></textarea>

                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.message"
                                            >{{ form.errors.message }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="file"
                                            class="form-control-label"
                                            >File</label
                                        >
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="file"
                                            @input="
                                                form.file =
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
                                            v-if="form.errors.file"
                                            >{{ form.errors.file }}</span
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
