<script setup>
const props = defineProps({
    article: Object,
});
</script>

<template>
    <Head :title="__('Article')" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-5">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">
                            {{ __("Article") }}
                        </p>
                    </div>
                    <h3>{{ article.data.title }}</h3>
                    <img :src="article.data.image" width="300" />
                    <hr />
                    <p v-html="article.data.content"></p>
                    <hr />
                    tags: {{ article.data.tags }}
                </div>
            </div>
        </div>
    </div>
</template>
