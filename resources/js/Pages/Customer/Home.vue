<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom">

                <div class="w-full">
                    <div class="main-jobs">
                        Đây là main job
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

// <script>
// import Filter from "../../../Components/Job/Filter.vue";
// import Notification from "../../../Components/Job/Notification.vue";
// import JobItem from "@/Components/Job/JobItem.vue";
// import Pagination from "@/Components/Pagination.vue";

// export default {
//     components: { Filter, Notification, JobItem, Pagination },
//     props: {
//         tags: Array,
//         hospital_types: Array,
//     },
//     created() {
//         this.fetchData();
//     },
//     data: function () {
//         return {
//             jobs: [],
//             loading: false,
//             total: "",
//             perPage: "",
//             filter: {
//                 page: 1,
//                 limit: 10,
//             },
//         };
//     },
//     methods: {
//         handleCurrentPage(value) {
//             this.filter.page = value;
//             this.fetchData();
//         },
//         async fetchData() {
//             this.loading = true;
//             await this.axios
//                 .get(`jobs`, { params: this.filter })
//                 .then(async (res) => {
//                     this.jobs = res.data;
//                     this.total = res.data.meta.total;
//                     this.perPage = res.data.meta.per_page;
//                 })
//                 .catch(() => {});
//             this.loading = false;
//         },
//     },
// };
// </script>
