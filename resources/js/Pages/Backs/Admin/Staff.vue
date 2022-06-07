<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5">Quản lý nhân viên</h2>
                <div class="w-full flex relative">
                    <div class="w-3/4 flex items-end">
                        <div class="mr-2">
                            <div class="text-sm text-blackPrimary-300">
                                Trạng thái
                            </div>
                            <el-select
                                v-model="filter.status"
                                placeholder="Trạng thái"
                                @change="onChangeFilterStatus"
                            >
                                <el-option
                                    v-for="item in statusList"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="mr-2">
                            <div class="text-sm text-blackPrimary-300">
                                Loại công việc
                            </div>
                            <el-select
                                v-model="filter.status"
                                placeholder="Loại công việc"
                                @change="onChangeTypeOfWork"
                            >
                                <el-option
                                    v-for="item in typeOfWork"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="search">
                            <search-input
                                :filter="filter"
                                v-model="filter.title"
                                label="Tìm kiếm"
                                @submit="onSubmitSearch"
                            ></search-input>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <data-table
                        :fields="fields"
                        :items="blogs.data"
                        :paginate="blogs.meta"
                        :current-page="filter.page || 1"
                        disable-table-info
                        footer-center
                        paginate-background
                        @page="handleCurrentPage"
                    >
                        <template #start_date="{ row }">
                            {{ formatDateTime(row?.created_at) }}
                        </template>

                        <template #status="{ row }">
                            {{ showPageDisplay(row?.status) }}
                        </template>

                        <template #actions="{ row }">
                            <div v-if="row" class="flex items-center">
                                <button
                                    class="btn-warning bg-gray-200"
                                    @click="confirmEventDelete(row)"
                                >
                                    <img
                                        src="/images/svg/trash.svg"
                                        alt=""
                                        class="size-icon"
                                    />
                                </button>

                                &nbsp;
                                <button
                                    class="btn-warning"
                                    @click="detail(row)"
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
import { formatDateTime } from "@/libs/datetime";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { STAFF_NOT_APPROVED, STAFF_WORKING, STAFF_RESIGN } from "@/store/const";

export default {
    name: "Staff",
    components: {
        AdminLayout,
        SearchInput,
        DataTable,
    },
    props: {
        blogs: {
            type: Object,
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            loading: false,
            statusList: [
                {
                    value: STAFF_NOT_APPROVED,
                    label: "Chờ duyệt",
                },
                {
                    value: STAFF_WORKING,
                    label: "Đang làm việc",
                },
                {
                    value: STAFF_RESIGN,
                    label: "Nghỉ việc",
                },
            ],
            typeOfWork: [
                {
                    value: 0,
                    label: "Partime",
                },
                {
                    value: 1,
                    label: "Fulltime",
                },
            ],

            fields: [
                { key: "image", label: "Ảnh" },
                { key: "name", label: "Tên nhân viên", width: 150 },
                { key: "email", label: "Email", width: 300 },
                { key: "phone", label: "Số điện thoại" },
                { key: "status", label: "Trạng thái" },
                { key: "type_of_work", label: "Loại công việc" },
                { key: "actions", label: "Thao tác" },
            ],
        };
    },
    computed: {
        filter() {
            const status = this.filtersBE?.status?.toInt();
            const type_of_work = this.filtersBE?.type_of_work?.toInt();
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 10,
                status:
                    status == null || typeof status === "undefined"
                        ? ""
                        : status,
                type_of_work:
                    type_of_work == null || typeof type_of_work === "undefined"
                        ? ""
                        : type_of_work,
                title: this.filtersBE?.title || "",
            };
        },
    },

    methods: {
        inertia() {
            Inertia.get(
                route("admin.staff.index", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },
        onSubmitSearch() {
            this.filter.page = 1;
            this.inertia();
        },
        onChangeTypeOfWork() {
            this.filter.page = 1;
            this.inertia();
        },
        onChangeFilterStatus() {
            this.filter.page = 1;
            this.inertia();
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },

        formatDateTime,

        confirmEventDelete({ id }) {
            this.$confirm(
                `Are you sure you want to delete this blog ?`,
                "警告",
                {
                    confirmButtonText: "はい",
                    cancelButtonText: "いいえ",
                    type: "warning",
                }
            ).then(async () => {
                Inertia.delete(route("back.blog.delete", { id }), {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                });
            });
        },

        showPageDisplay(page_display) {
            let text = "";
            switch (page_display) {
                case STAFF_NOT_APPROVED: {
                    text = "Chờ duyệt";
                    break;
                }
                case STAFF_WORKING: {
                    text = "Đang làm việc";
                    break;
                }
                case STAFF_RESIGN: {
                    text = "Nghỉ việc";
                    break;
                }
                default: {
                    text = "Undefined";
                }
            }
            return text;
        },
    },
};
</script>
