<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom">
                <el-row :gutter="10" class="mb-8">
                    <el-col :md="{ span: 6 }">
                        <div class="flex items-center">
                            <el-input
                                class="h-10"
                                :placeholder="'Search'"
                                v-model="search"
                            ></el-input>

                            <button
                                class="btn-primary h-10 -ml-1 z-10"
                                @click.prevent="onSearch()"
                            >
                                <img src="/images/svg/search.svg" alt="" />
                            </button>
                        </div>
                    </el-col>
                    <el-col :md="{ span: 18 }">
                        <div
                            class="custom-paginate-box flex justify-end items-center w-full"
                            v-if="totalPage > perPage"
                        >
                            <page-info
                                :total-page="totalPage"
                                :current-page="currentPage"
                                :per-page="perPage"
                            />
                            <pagination
                                v-model="currentPage"
                                @current-change="onPageChanged"
                                :page-size="perPage"
                                :total="totalPage"
                            />
                        </div>
                    </el-col>
                </el-row>

                <div class="w-full">
                    <div class="main-jobs" v-if="jobData.length > 0">
                        <job-item
                            v-for="(job, indexJob) in jobData"
                            :job="job"
                            :key="indexJob"
                        />
                    </div>
                    <div v-else>
                        <el-empty description="No Data"></el-empty>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import JobItem from "@/Components/Job/JobItem.vue";
import { ref, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import Pagination from "@/Components/Pagination.vue";
import PageInfo from "@/Components/Control/PageInfo.vue";

export default {
    name: "FavoritePage",
    components: { JobItem, Pagination, PageInfo },
    props: {
        jobs: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: true,
        },
    },
    setup({ filters, jobs }) {
        const search = ref(filters.search);
        const currentPage = ref(filters.page?.toInt() || 1);
        const jobData = reactive(
            jobs.data.map((item) => {
                return {
                    ...item,
                    isFavorite: true,
                };
            })
        );

        const totalPage = ref(jobs.meta.total);
        const perPage = ref(jobs.meta.per_page);

        const inertia = (page) => {
            Inertia.get(
                route("caretaker.job.favorite", {
                    page,
                    search: search.value,
                }),
                {},
                {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                }
            );
        };

        const onPageChanged = (val) => {
            inertia(val);
        };

        const onSearch = (_) => {
            inertia(1);
        };

        return {
            search,
            currentPage,
            jobData,
            totalPage,
            perPage,
            onPageChanged,
            onSearch,
        };
    },
};
</script>
