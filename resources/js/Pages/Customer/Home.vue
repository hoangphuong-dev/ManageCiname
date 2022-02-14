<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom">
                <div class="w-full">
                    <div class="main-jobs">
                        <!-- slider -->
                        <div class="w-full">
                            <div class="w-4/5 m-auto border-white h-44" >
                                <vue-slider v-model="value" />
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-1/2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
// import Filter from "../../../Components/Job/Filter.vue";
// import Notification from "../../../Components/Job/Notification.vue";
// import JobItem from "@/Components/Job/JobItem.vue";
// import Pagination from "@/Components/Pagination.vue";
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'
export default {
    components: {VueSlider },
    props: {
        tags: Array,
        hospital_types: Array,
    },
    created() {
        // this.fetchData();
    },
    data: function () {
        return {
            value: 0,
            slider: [1,2,3,4,5,5],
            loading: false,
            total: "",
            perPage: "",
            filter: {
                page: 1,
                limit: 10,
            },
        };
    },
    methods: {
        handleCurrentPage(value) {
            this.filter.page = value;
            this.fetchData();
        },
        async fetchData() {
            this.loading = true;
            await this.axios
                .get(`jobs`, { params: this.filter })
                .then(async (res) => {
                    this.jobs = res.data;
                    this.total = res.data.meta.total;
                    this.perPage = res.data.meta.per_page;
                })
                .catch(() => {});
            this.loading = false;
        },
    },
};
</script>
