<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-3 text-lightGreen">求人一覧</h2>

                <el-breadcrumb separator="/" class="mb-2 breadcrumb-cs">
                    <el-breadcrumb-item
                        @click="
                            onClickBreadcrumb(route('back.hospital-analytic'))
                        "
                        :to="{ path: route('back.hospital-analytic') }"
                        >求人管理</el-breadcrumb-item
                    >
                    <el-breadcrumb-item>本田クリニック</el-breadcrumb-item>
                </el-breadcrumb>

                <div class="w-full flex relative items-end justify-between">
                    <div class="w-full lg:w-auto mr-2 flex items-center">
                        <div>
                            <label class="text-gray-500 text-sm"
                                >ステータス</label
                            >
                            <br />
                            <el-select
                                @change="onChangeStatus"
                                v-model="filter.status"
                                placeholder="Select"
                                style="width: 120px"
                            >
                                <el-option
                                    v-for="item in statusList"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                ></el-option>
                            </el-select>
                        </div>
                        &nbsp;
                        <div>
                            <label for=""></label>
                            <br />
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
                    </div>
                    <div class="search">
                        <search-input
                            :filter="filter"
                            label="検索"
                            v-model="filter.name"
                            @submit="onSubmitSearch"
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
                        <template #status="{ row }">
                            <p
                                class="py-2 px-5 w-max min-w-132 rounded-100 text-white text-center"
                                :class="[
                                    row?.status === JOB_STATUS_PUBLIC
                                        ? 'bg-lightGreen'
                                        : row?.status === JOB_STATUS_PENDING
                                        ? 'bg-redPrimary'
                                        : 'bg-yellowPrimary',
                                ]"
                            >
                                {{ row?.status_name }}
                            </p>
                        </template>
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
    JOB_STATUS_WAITING,
    JOB_STATUS_PUBLIC,
    JOB_STATUS_UPDATING,
    JOB_STATUS_PENDING,
} from "@/store/const.js";
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
        jobsData: {
            required: true,
        },
        hospitalId: {
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },
    computed: {
        jobs() {
            return this.jobsData;
        },
        filter() {
            let status = this.filtersBE?.status?.toInt();
            status =
                typeof status === "undefined"
                    ? ""
                    : status === JOB_STATUS_WAITING
                    ? status + 99
                    : status;

            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 10,
                status: status,
                name: this.filtersBE?.name || "",
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
                    value: JOB_STATUS_PUBLIC,
                    label: "公開中",
                },
                {
                    value: JOB_STATUS_WAITING + 99,
                    label: "承認待ち",
                },
                {
                    value: JOB_STATUS_PENDING,
                    label: "保留",
                },
                {
                    value: JOB_STATUS_UPDATING,
                    label: "Updating",
                },
            ],
            JOB_STATUS_WAITING,
            JOB_STATUS_PUBLIC,
            JOB_STATUS_UPDATING,
            JOB_STATUS_PENDING,
            fields: [
                { key: "name", label: "求人名" },
                { key: "created_at", label: "登録日", width: 150 },
                { key: "updated_at", label: "承認日", width: 150 },
                { key: "status", label: "ステータス", width: 150 },
                { key: "actions", label: "", width: 100 },
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
                route("back.hospital-analytic.detail", {
                    id,
                    hospital_id: this.hospitalId,
                }),
                {},
                { onBefore, onFinish }
            );
        },
        onChangeStatus() {
            this.inertia();
        },
        onSubmitSearch() {
            this.inertia();
        },
        onChangeDateSelect() {
            this.filter.daterange = this.daterange;
            this.inertia();
        },
        onClickBreadcrumb(url) {
            Inertia.get(
                url,
                {},
                {
                    onBefore,
                    onFinish,
                }
            );
        },
        inertia() {
            Inertia.get(
                route("back.hospital-analytic.list", {
                    id: this.hospitalId,
                    ...this.filter,
                    daterange: this.daterange,
                    status:
                        this.filter.status === JOB_STATUS_WAITING + 99
                            ? JOB_STATUS_WAITING
                            : this.filter.status,
                }),
                {},
                {
                    onBefore,
                    onFinish,
                    preserveScroll: true
                }
            );
        },
    },
};
</script>
<style>
.breadcrumb-cs .is-link {
    color: #606266 !important;
    font-weight: normal !important;
}

.breadcrumb-cs .el-breadcrumb__inner:not(.is-link) {
    font-weight: bold !important;
    color: #a5c242 !important;
}
</style>
