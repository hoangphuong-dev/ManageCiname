<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5">Quản lý nhân viên</h2>
                <div class="w-full flex relative">
                    <div class="w-3/4 flex items-end">
                        <SelectFilter
                            :type="'status'"
                            :modelSelect="filter.status"
                            :listOption="statusList"
                            @onchangeFilter="onFilter"
                        />
                        <SelectFilter
                            :type="'type_of_work'"
                            :modelSelect="filter.type_of_work"
                            :listOption="typeOfWork"
                            @onchangeFilter="onFilter"
                        />
                        <SearchInput
                            :filter="filter"
                            v-model="filter.name"
                            label="Tìm kiếm"
                            @submit="onFilter"
                        />
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
                        <template #created_at="{ row }">
                            {{ formatDateTime(row?.created_at) }}
                        </template>
                        <template #status="{ row }">
                            {{ showStatus(row?.status) }}
                        </template>
                        <template #type_of_work="{ row }">
                            {{ showTypeOfWork(row?.type_of_work) }}
                        </template>
                        <template #image="{ row }">
                            <el-avatar
                                shape="square"
                                :size="70"
                                :src="
                                    getImage(row?.image) ||
                                    '/uploads/customer.png'
                                "
                            />
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
import SelectFilter from "@/Components/Element/SelectFilter.vue";
import DataTable from "@/Components/DataTable.vue";
import { formatDateTime } from "@/libs/datetime";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import * as Staff from "@/store/const";

export default {
    name: "Staff",
    components: {
        AdminLayout,
        SearchInput,
        SelectFilter,
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
                { id: Staff.STAFF_NOT_APPROVED, name: "Chờ duyệt" },
                { id: Staff.STAFF_WORKING, name: "Đang làm việc" },
                { id: Staff.STAFF_RESIGN, name: "Nghỉ việc" },
            ],
            typeOfWork: [
                { id: 1, name: "Fulltime" },
                { id: 2, name: "Partime" },
            ],

            fields: [
                { key: "image", label: "Ảnh" },
                { key: "name", label: "Tên nhân viên", width: 150 },
                { key: "email", label: "Email", width: 300 },
                { key: "phone", label: "Số điện thoại" },
                { key: "status", label: "Trạng thái" },
                { key: "type_of_work", label: "Loại công việc" },
                { key: "created_at", label: "Ngày đăng ký" },
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
                limit: this.filtersBE.limit?.toInt() || 12,
                name: this.filtersBE?.name || "",
                status:
                    status == null || typeof status === "undefined"
                        ? null
                        : status,
                type_of_work:
                    type_of_work == null || typeof type_of_work === "undefined"
                        ? null
                        : type_of_work,
            };
        },
    },

    methods: {
        formatDateTime,
        inertia() {
            Inertia.get(
                route("admin.staff.index", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },

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

        showStatus(page_display) {
            let text = "";
            switch (page_display) {
                case Staff.STAFF_NOT_APPROVED: {
                    text = "Chờ duyệt";
                    break;
                }
                case Staff.STAFF_WORKING: {
                    text = "Đang làm việc";
                    break;
                }
                case Staff.STAFF_RESIGN: {
                    text = "Nghỉ việc";
                    break;
                }
                default: {
                    text = "Undefined";
                }
            }
            return text;
        },

        showTypeOfWork(type) {
            let text = "";
            switch (type) {
                case Staff.STAFF_FULL_TIME: {
                    text = "Fulltime";
                    break;
                }
                case Staff.STAFF_PART_TIME: {
                    text = "Parttime";
                    break;
                }
                default: {
                    text = "Undefined";
                }
            }
            return text;
        },

        onFilter(value, type) {
            if (type === "type_of_work") {
                this.filter.type_of_work = value;
            } else if (type === "status") {
                this.filter.status = value;
            }
            this.filter.page = 1;
            this.inertia();
        },
    },
};
</script>
