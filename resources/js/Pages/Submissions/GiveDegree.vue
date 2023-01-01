<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    submission: Object,
});

const form = useForm({
    degree: props.submission.degree,
});
</script>

<template>
    <Head title="Show submission" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="
                            form.put(`/submissions/${submission.id}`)
                        "
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Give degree for submission</p>
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
                                Submission Information
                            </p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="message"
                                            class="text-lg form-control-label"
                                            >Message</label
                                        >
                                        <pre class="text-bolder">
                                            {{ submission.message }}
                                        </pre>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="file"
                                            class="text-lg form-control-label d-block"
                                            >File</label
                                        >
                                        <a
                                            :href="`/storage/${submission.file}`"
                                            class="text-link"
                                            target="_blank"
                                            >Submission file</a
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="degree"
                                            class="text-lg form-control-label d-block"
                                            >DEGREE</label
                                        >
                                        <input
                                            type="number"
                                            name="degree"
                                            id="degree"
                                            class="form-control"
                                            v-model="form.degree"
                                        />
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.degree"
                                            >{{ form.errors.degree }}</span
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
