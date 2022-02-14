<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom">
                <Filter
                    :hospital_types="hospital_types"
                    :tags="tags"
                    :filter="filter"
                    :hospital_info="hospital_info"
                    @handleFilter="fetchData"
                />
                <Notification />
                <div
                    class="custom-paginate-box flex justify-center items-center w-full mb-8"
                    v-if="Number(total) > Number(perPage)"
                >
                    <h3 class="page-size">
                        全 {{ Number(total) }} 件 ({{
                            (filter.page - 1) * Number(perPage) + 1
                        }}～{{
                            filter.page * Number(perPage) < Number(total)
                                ? filter.page * Number(perPage)
                                : Number(total)
                        }}件を表示)
                    </h3>
                    <pagination
                        v-model="filter.page"
                        @current-change="handleCurrentPage"
                        :page-size="Number(perPage)"
                        :total="Number(total)"
                    />
                </div>

                <div class="w-full">
                    <div class="main-jobs">
                        <job-item
                            v-for="(job, indexJob) in jobs.data"
                            :job="job"
                            :key="indexJob"
                        />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import Filter from "../../../Components/Job/Filter.vue";
import Notification from "../../../Components/Job/Notification.vue";
import JobItem from "@/Components/Job/JobItem.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: { Filter, Notification, JobItem, Pagination },
    props: {
        tags: Array,
        hospital_types: Array,
    },
    created() {
        this.fetchData();
    },
    data: function () {
        return {
            jobs: [],
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
