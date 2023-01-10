<script setup>
const props = defineProps({
    branches: Object,
    location: String,
});
</script>

<template>
    <Head title="Users of the site" />
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <div class="card-header pb-0">
                            <h6>Branches of the academy ordered by distance</h6>
                        </div>
                    </div>
                    <div class="h3 text-white alert alert-info text-center">
                        Your location is: {{ location }}
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        >
                                            Branch
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        >
                                            Location
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="branch in branches"
                                        :key="branch.id"
                                    >
                                        <td>
                                            {{ branch.name }}
                                        </td>
                                        <td>
                                            {{ branch.location.point }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
