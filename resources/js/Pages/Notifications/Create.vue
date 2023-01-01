<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    message: "",
    recipients: {
        superadmin: false,
        teacher: false,
        student: false,
    },
    via: {
        mail: false,
        database: false,
        sms: false,
    },
});
</script>
<template>
    <Head title="Push notifications" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="
                            form.post(route('notifications.store'))
                        "
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Push a notification to users</p>
                                <button
                                    class="btn btn-primary btn-sm ms-auto"
                                    :disabled="form.processing"
                                >
                                    Push
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">
                                Notification info
                            </p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="message"
                                            class="form-control-label"
                                            >message</label
                                        >
                                        <input
                                            class="form-control"
                                            id="message"
                                            type="text"
                                            name="message"
                                            v-model="form.message"
                                        />
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
                                            for="message"
                                            class="form-control-label"
                                            >Send to</label
                                        >
                                        <div>
                                            <label for="superadmin">
                                                <input
                                                    type="checkbox"
                                                    id="superadmin"
                                                    v-model="
                                                        form.recipients
                                                            .superadmin
                                                    "
                                                />
                                                Superadmins
                                            </label>
                                            <label for="teacher">
                                                <input
                                                    type="checkbox"
                                                    id="teacher"
                                                    v-model="
                                                        form.recipients.teacher
                                                    "
                                                />
                                                Teachers
                                            </label>
                                            <label for="student">
                                                <input
                                                    type="checkbox"
                                                    id="student"
                                                    v-model="
                                                        form.recipients.student
                                                    "
                                                />
                                                Students
                                            </label>
                                        </div>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.recipients"
                                            >{{ form.errors.recipients }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="message"
                                            class="form-control-label"
                                            >Send via</label
                                        >
                                        <div>
                                            <label for="mail">
                                                <input
                                                    type="checkbox"
                                                    id="mail"
                                                    v-model="form.via.mail"
                                                />
                                                Email
                                            </label>
                                            <label for="database">
                                                <input
                                                    type="checkbox"
                                                    id="database"
                                                    v-model="form.via.database"
                                                />
                                                In-App notification
                                            </label>
                                            <label for="sms">
                                                <input
                                                    type="checkbox"
                                                    id="sms"
                                                    v-model="form.via.sms"
                                                />
                                                SMS
                                            </label>
                                        </div>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.via"
                                            >{{ form.errors.via }}</span
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
