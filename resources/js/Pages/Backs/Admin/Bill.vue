<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Quản lý hóa đơn</h2>
                <ViewBill :bills="bills" :filtersBE="filtersBE"/>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ViewBill from "@/Components/ViewBill.vue";

export default {
    name: "BillAdmin",
    props: {
        bills: {
            type: Object,
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },
    components: {
        AdminLayout,
        ViewBill,
    },
    data() {
        return {
            loading: false,
        };
    },
    methods: {},
};
</script>
