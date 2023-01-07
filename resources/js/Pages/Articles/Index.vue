<script setup>
import Pagination from "../../Components/Pagination.vue";
const props = defineProps({
    articles: Object,
});
</script>
<template>
    <Head title="Articles" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="card-header pb-0">
                            <h6>{{ __("Articles") }}</h6>
                        </div>
                        <div class="px-4 pt-3">
                            <a
                                :href="route('articles.export')"
                                class="btn btn-light"
                                >{{ __("Export") }}</a
                            >
                            <Link
                                v-if="articles.creatable"
                                :href="route('articles.create')"
                                class="btn btn-primary"
                                >{{ __("Create a new article") }}</Link
                            >
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        >
                                            {{ __("Title") }}
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            {{ __("Author") }}
                                        </th>
                                        <th
                                            class="text-secondary opacity-7"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="article in articles.data"
                                        :key="article.id"
                                    >
                                        <td style="white-space: normal">
                                            <h6 class="mb-0 text-sm">
                                                {{ article.title }}
                                            </h6>
                                        </td>
                                        <td>
                                            {{ article.author.name }}
                                        </td>

                                        <td class="align-middle">
                                            <Link
                                                v-if="article.viewable"
                                                :href="
                                                    route(
                                                        'articles.show',
                                                        article.id
                                                    )
                                                "
                                                class="btn btn-primary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Show article"
                                            >
                                                {{ __("Show") }}
                                            </Link>
                                            <Link
                                                v-if="article.editable"
                                                :href="
                                                    route(
                                                        'articles.edit',
                                                        article.id
                                                    )
                                                "
                                                class="btn btn-secondary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Edit article"
                                            >
                                                {{ __("Edit") }}
                                            </Link>
                                            <Link
                                                v-if="article.deleteable"
                                                :href="
                                                    route(
                                                        'articles.destroy',
                                                        article.id
                                                    )
                                                "
                                                method="delete"
                                                as="button"
                                                class="btn btn-danger font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip"
                                                data-original-title="Delete article"
                                            >
                                                {{ __("Delete") }}
                                            </Link>
                                        </td>
                                    </tr>
                                    <tr v-if="!articles.data.length">
                                        <td colspan="3" class="text-center">
                                            {{ __("No articles found") }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                <Pagination :links="articles.meta.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
