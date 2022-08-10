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
                    <div class="w-1/4">
                        <DateFilter
                            :title="'Ngày đăng ký'"
                            :type="'date_register'"
                            :typeDate="'daterange'"
                            :modelSelect="filter.range"
                            @onchangeFilter="onFilter"
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
                            <div
                                :class="{
                                    'text-yellow-500': row?.status === 1,
                                    'text-green-600': row?.status === 2,
                                    'text-red-500': row?.status === 3,
                                }"
                                class="p-2 text-center font-bold rounded-md"
                            >
                                {{ showStatus(row?.status) }}
                            </div>
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
                                        src="/images/trash.svg"
                                        alt=""
                                        class="size-icon"
                                    />
                                </button>

                                &nbsp;
                                <button
                                    v-if="row?.status != 3"
                                    class="btn-warning"
                                    @click="updateStatus(row, row?.status)"
                                >
                                    Đổi trạng thái
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
import DateFilter from "@/Components/Element/DateFilter.vue";
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
        DateFilter,
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
                { key: "name", label: "Tên nhân viên", width: 250 },
                { key: "email", label: "Email", width: 300 },
                { key: "phone", label: "Số điện thoại", width: 200 },
                { key: "type_of_work", label: "Loại công việc", width: 130 },
                { key: "created_at", label: "Ngày đăng ký", width: 150 },
                { key: "status", label: "Trạng thái", width: 130 },
                { key: "actions", label: "Thao tác", width: 250 },
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
                range: this.filtersBE?.range || [],
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
                `Bạn có chắc xóa hết tất cả dữ liệu của nhân viên này ?`,
                "Cảnh báo",
                {
                    confirmButtonText: "Chắc chắn",
                    cancelButtonText: "Hủy",
                    type: "warning",
                }
            ).then(async () => {
                Inertia.delete(route("admin.staff.delete", { id }), {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                });
            });
        },

        async updateStatus(row, status) {
            if (status === Staff.STAFF_RESIGN) return;
            let text = "";
            status == Staff.STAFF_NOT_APPROVED
                ? (text = "đang làm việc")
                : (text = "nghỉ việc");
            this.$confirm(
                `Thay đổi trạng thái nhân viên thành ` + text + " ?",
                "Cảnh báo",
                {
                    confirmButtonText: "Chắc chắn",
                    cancelButtonText: "Hủy",
                    type: "warning",
                }
            ).then(async () => {
                Inertia.put(
                    route("admin.staff.update-status", row?.id),
                    { status },
                    {
                        onBefore,
                        onFinish,
                        preserveScroll: true,
                        onError: (e) => console.log(e),
                    }
                );
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
            } else if (type === "date_register") {
                this.filter.range = value;
            }
            this.filter.page = 1;
            this.inertia();
        },
    },
};
</script>
