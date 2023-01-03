<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    article: Object,
});

console.log();

const form = useForm({
    image: null,
    title_ar: props.article.data.translations[0].title,
    title_en: props.article.data.translations[1].title,
    content_ar: props.article.data.translations[0].content,
    content_en: props.article.data.translations[1].content,
    tags: props.article.data.tags,
    _method: "PUT",
});
</script>

<template>
    <Head :title="__('Edit article')" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form
                        @submit.prevent="
                            form.post(route('articles.update', article.data.id))
                        "
                    >
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">
                                    {{ __("Edit article") }}
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
                                            for="image"
                                            class="form-control-label"
                                            >{{ __("Photo") }}</label
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
                                            for="content"
                                            class="form-control-label"
                                            >{{ __("content") }} ({{
                                                __("In Arabic")
                                            }})</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="content"
                                            type="text"
                                            v-model="form.content_ar"
                                        ></textarea>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.content_ar"
                                            >{{ form.errors.content_ar }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="content"
                                            class="form-control-label"
                                            >{{ __("content") }} ({{
                                                __("In English")
                                            }})</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="content"
                                            type="text"
                                            v-model="form.content_en"
                                        ></textarea>
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.content_en"
                                            >{{ form.errors.content_en }}</span
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="tags"
                                            class="form-control-label"
                                            >{{ __("Tags") }}</label
                                        >
                                        <input
                                            class="form-control"
                                            id="tags"
                                            type="text"
                                            v-model="form.tags"
                                        />
                                        <a href="#" class="text-muted"
                                            >Comma separated tags</a
                                        >
                                        <span
                                            class="text-danger text-sm"
                                            v-if="form.errors.tags"
                                            >{{ form.errors.tags }}</span
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
