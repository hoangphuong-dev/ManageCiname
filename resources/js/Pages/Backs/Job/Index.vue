<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5 text-lightGreen">求人一覧</h2>

                <div class="w-full flex relative items-end justify-between">
                    <div class="w-full lg:w-auto mr-2">
                        <el-date-picker
                            v-model="daterange"
                            type="daterange"
                            range-separator="-"
                            start-placeholder="Start date"
                            end-placeholder="End date"
                            style="width: 250px"
                            @change="onChangeDateSelect"
                            format="YYYY/MM/DD"
                            value-format="YYYY-MM-DD"
                        >
                        </el-date-picker>
                    </div>
                    <div class="search">
                        <search-input
                            :filter="filter"
                            label="検索"
                        ></search-input>
                    </div>
                </div>

                <div class="mt-5">
                    <data-table
                        :fields="fields"
                        :items="jobs.data"
                        :paginate="jobs.meta"
                        :current-page="filter.page || 1"
                        disable-table-info
                        footer-center
                        paginate-background
                        enable-select-box
                        @page="handleCurrentPage"
                    >
                        <template #actions="{ row }">
                            <div v-if="row" class="flex items-center">
                                <button
                                    class="ml-4 py-2 px-4 rounded btn-warning"
                                    @click="gotoDetail(row)"
                                >
                                    詳細
                                </button>
                            </div>
                        </template>
                    </data-table>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import {
    HOSPITAL_STATUS_DEACTIVE,
    HOSPITAL_STATUS_DONE,
    HOSPITAL_STATUS_PENDING,
} from "@/store/const.js";
import { formatDateTime } from "@/libs/datetime";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
    name: "HospitalList",
    components: {
        AdminLayout,
        SearchInput,
        DataTable,
    },
    props: {
        listHospital: {
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },
    computed: {
        jobs() {
            return this.listHospital;
        },
        filter() {
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 10,
                name: this.filtersBE?.name || "",
                daterange: this.filtersBE?.daterange || "",
            };
        },
    },
    data() {
        return {
            daterange: "",
            statusList: [
                {
                    value: "",
                    label: "全て",
                },
                {
                    value: HOSPITAL_STATUS_DONE,
                    label: "使用中",
                },
                {
                    value: HOSPITAL_STATUS_PENDING,
                    label: "承認待ち",
                },
                {
                    value: HOSPITAL_STATUS_DEACTIVE,
                    label: "中止",
                },
            ],
            HOSPITAL_STATUS_DEACTIVE: HOSPITAL_STATUS_DEACTIVE,
            HOSPITAL_STATUS_DONE: HOSPITAL_STATUS_DONE,
            HOSPITAL_STATUS_PENDING: HOSPITAL_STATUS_PENDING,
            fields: [
                {
                    key: "name",
                    label: "病院名",
                },
                {
                    key: "jobCount",
                    label: "求人数",
                    width: 150,
                },
                {
                    key: "jobSuccess",
                    label: "承認件数",
                    width: 150,
                },
                {
                    key: "jobReject",
                    label: "不承認件数",
                    width: 150,
                },
                {
                    key: "jobPending",
                    label: "承認待ち件数",
                    width: 150,
                },
                {
                    key: "actions",
                    label: "",
                    width: 100,
                },
            ],
        };
    },
    created() {
        this.daterange = this.filtersBE.daterange || "";
    },
    methods: {
        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },
        gotoDetail({ id }) {
            Inertia.get(
                route("back.hospital-analytic.list", {
                    id,
                }),
                {},
                { onBefore, onFinish }
            );
        },
        formatDateTime,
        onChangeStatus() {
            this.inertia();
        },
        inertia() {
            Inertia.get(
                route("back.hospital-analytic", {
                    ...this.filter,
                    daterange: this.daterange,
                }),
                {},
                {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                }
            );
        },
        onChangeDateSelect() {
            this.filter.daterange = this.daterange;
            this.inertia();
        },
    },
};
</script>
