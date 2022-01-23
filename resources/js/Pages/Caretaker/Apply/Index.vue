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
                                :onPageChanged="onPageChanged"
                                :page-size="perPage"
                                :total="totalPage"
                            />
                        </div>
                    </el-col>
                </el-row>
                <div class="w-full">
                    <div class="main-jobs">
                        <el-tabs
                            v-model="activeName"
                            @tab-click="handleClick"
                            class="tab-custom"
                        >
                            <el-tab-pane
                                label="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Đang ứng tuyển&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                name="first"
                            >
                                <table-item :job-reactive="jobReactive"/>
                            </el-tab-pane>
                            <el-tab-pane label="Đã ứng tuyển" name="second">
                                <table-item :job-reactive="jobReactive"/>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { ref, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import TableItem from "./Table.vue";
import Pagination from "@/Components/Pagination.vue";
import PageInfo from "@/Components/Control/PageInfo.vue";

export default {
    name: "JobApplyPage",
    components: {
        TableItem,
        Pagination,
        PageInfo
    },
    props: {
        active: {
            type: String,
            required: true,
        },
        jobs: {
            required: true,
        },
        filters: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        const jobs = props.jobs;
        const filters = props.filters;

        const search = ref(filters.search);
        const currentPage = ref(filters.page?.toInt() || 1);
        const totalPage = ref(jobs.meta.total);
        const perPage = ref(jobs.meta.per_page);

        const mapJob = jobs.data.map((item) => {
            let job_apply = item.job_apply;

            if(Array.isArray(job_apply)) {
                job_apply = item.job_apply.find(
                    (i) => i.times === item.times
                );
            }

            return {
                ...item,
                job_apply,
                last_update:
                    job_apply?.job_post_apply?.last()?.updated_at || "",
            };
        });

        let jobReactive = reactive(mapJob);

        const activeName = ref(props.active);

        const getRoute = page => {
            const routeName = activeName.value === 'first' ? "caretaker.get.job.apply" : "caretaker.get.job.applied";
            return route(routeName, {
                page,
                search: search.value,
            })
        }
        const handleClick = (tab) => {
            tab = tab.index.toInt();
            switch (tab) {
                case 0:
                    return inertia(1);
                case 1:
                    return inertia(1);
            }
        };

        const inertia = (page) => {
            Inertia.get(
                getRoute(page),
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
            activeName,
            jobReactive,
            currentPage,
            totalPage,
            perPage,
            handleClick,
            onSearch,
            onPageChanged
        };
    },
};
</script>
<style>
.main-jobs {
    background-color: white;
}
.tab-body {
    padding: 0 20px 20px 20px;
}

.tab-custom .is-active {
    color: #a5c242 !important;
    font-weight: bold !important;
}

.tab-custom .el-tabs__item:hover {
    color: #a5c242 !important;
}

.tab-custom .el-tabs__active-bar {
    background-color: #a5c242 !important;
}

.border-b-1 {
    border-bottom-width: 1px;
}

.max-width-500 {
    max-width: 500px;
}

.min-width-1000 {
    min-width: 1000px;
}
</style>
