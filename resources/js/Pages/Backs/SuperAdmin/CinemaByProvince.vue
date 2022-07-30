<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-500">Khu vuc {{ province?.name }}</h2>
                <div class="w-full flex relative">
                    <div class="w-3/4 flex items-end">
                        <SearchInput
                            :filter="filter"
                            v-model="filter.name"
                            label="Tìm kiếm"
                            @submit="onFilter"
                        />
                    </div>
                    <div class="w-1/4 flex items-end">
                        <button
                            class="ml-auto btn-primary bg-red-400"
                            @click="onOpenDialog"
                        >
                            +Thêm rạp
                        </button>
                    </div>
                </div>

                <div class="mt-5">
                    <data-table
                        :fields="fields"
                        :items="cinemas.data"
                        :paginate="cinemas.meta"
                        :current-page="filter.page || 1"
                        disable-table-info
                        footer-center
                        paginate-background
                        @page="handleCurrentPage"
                    >
                        <template #hotline="{ row }">
                            <div>{{ row?.user.phone }}</div>
                        </template>
                        <template #manage="{ row }">
                            <div>{{ row?.user.name }}</div>
                        </template>

                        <template #created_at="{ row }">
                            {{ formatDateTime(row?.created_at) }}
                        </template>

                        <template #actions="{ row }">
                            <div v-if="row" class="flex items-center">
                                <button
                                    v-if="!row.status"
                                    class="btn-warning bg-gray-200"
                                    @click="edit(row)"
                                >
                                    <img
                                        src="/images/edit.svg"
                                        class="size-icon"
                                        alt=""
                                    />
                                </button>
                                &nbsp;
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
                                    class="btn-warning bg-green-600"
                                    @click="
                                        loginProxy(row?.user?.id, province?.id)
                                    "
                                >
                                    Đăng nhập ủy quyền
                                </button>
                            </div>
                        </template>
                    </data-table>
                </div>
            </div>

            <el-dialog
                :title="
                    selectedItem === null ? 'Thêm rạp' : 'Sửa thông tin rạp'
                "
                v-model="dialogFormVisible"
            >
                <el-form
                    ref="formData"
                    :model="formData"
                    label-position="top"
                    :rules="rules"
                >
                    <div class="flex w-full">
                        <div class="w-1/2 mr-4">
                            <!-- Tên admin -->
                            <el-form-item label="Tên người quản lý" prop="name">
                                <el-input
                                    v-model="formData.name"
                                    autocomplete="off"
                                    placeholder="Nhập tên"
                                ></el-input>
                            </el-form-item>

                            <!-- Số điện thoại -->
                            <el-form-item label="Số điện thoại" prop="phone">
                                <el-input
                                    v-model="formData.phone"
                                    autocomplete="off"
                                    placeholder="Nhập số điện thoại"
                                ></el-input>
                            </el-form-item>

                            <!-- Email -->
                            <div v-if="selectedItem == null">
                                <el-form-item label="Email" prop="email">
                                    <el-input
                                        v-model="formData.email"
                                        autocomplete="off"
                                        placeholder="Nhập email"
                                    ></el-input>
                                </el-form-item>
                            </div>
                        </div>

                        <div class="w-1/2">
                            <!-- Tên rạp -->
                            <el-form-item label="Tên rạp" prop="cinema_name">
                                <el-input
                                    v-model="formData.cinema_name"
                                    autocomplete="off"
                                    placeholder="Nhập tên rạp"
                                ></el-input>
                            </el-form-item>

                            <!-- Địa chỉ -->
                            <el-form-item label="Địa chỉ" prop="address">
                                <el-input
                                    v-model="formData.address"
                                    autocomplete="off"
                                    placeholder="Nhập email"
                                ></el-input>
                            </el-form-item>
                        </div>
                    </div>

                    <!-- submit -->
                    <div class="text-right">
                        <span class="dialog-footer">
                            <el-button @click="dialogFormVisible = false"
                                >Hủy</el-button
                            >
                            <el-button type="primary" @click="onSubmit">
                                <span v-if="selectedItem === null">Thêm</span>
                                <span v-else>Cập nhật</span>
                            </el-button>
                        </span>
                    </div>
                </el-form>
            </el-dialog>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { formatDateTime } from "@/libs/datetime";
export default {
    name: "SeatType",
    components: {
        AdminLayout,
        SearchInput,
        DataTable,
    },
    props: {
        filtersBE: { type: Object, required: true },
        province: { type: Object, required: true },
        cinemas: { type: Object, required: true },
    },
    data() {
        return {
            selectedItem: null,
            dialogFormVisible: false,

            formData: this.$inertia.form({
                name: "",
                phone: "",
                email: "",
                cinema_name: "",
                address: "",
                province_id: this.province.id,
            }),

            fields: [
                { key: "name", label: "Tên rạp", width: 250 },
                { key: "number_room", label: "Số phòng" },
                { key: "hotline", label: "Hotline", width: 250 },
                { key: "manage", label: "Người quản lý", width: 250 },
                { key: "actions", label: "Thao tác", width: 400 },
            ],

            rules: {
                name: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "blur",
                    },
                ],
                phone: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "change",
                    },
                    {
                        validator: function (err, value, callback) {
                            let val = value.replace(/\s+/g, " ");
                            if (
                                !(val.length >= 9 && val.length <= 12) ||
                                value.includes(" ")
                            ) {
                                return callback(
                                    "Số điện thoại không đúng định dạng"
                                );
                            }
                            callback();
                        },
                        trigger: "change",
                    },
                ],
                email: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "blur",
                    },
                    {
                        type: "email",
                        message: "Email không đúng định dạng",
                        trigger: "change",
                    },
                ],
                cinema_name: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "blur",
                    },
                ],
                address: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "blur",
                    },
                ],
            },
        };
    },
    computed: {
        filter() {
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 10,
                name: this.filtersBE?.name || "",
            };
        },
    },

    methods: {
        formatDateTime,
        inertia() {
            Inertia.get(
                route("superadmin.cinema.province", 1),
                { ...this.filter },
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        onOpenDialog() {
            this.formData.reset();
            this.selectedItem = null;
            this.dialogFormVisible = !this.dialogFormVisible;
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },

        createCinema() {
            Inertia.post(route("superadmin.cinemas.store"), this.formData, {
                onBefore,
                onFinish,
                preserveScroll: true,
                onError: (e) => console.log(e),
                onSuccess: (_) => {
                    this.formData.reset();
                    this.dialogFormVisible = !this.dialogFormVisible;
                },
            });
        },

        async onSubmit() {
            this.$refs.formData.validate((valid) => {
                if (valid) {
                    if (this.selectedItem === null) {
                        this.createSeatType();
                    } else {
                        this.editSeatType();
                    }
                }
            });
        },

        edit(item) {
            this.dialogFormVisible = true;
            this.selectedItem = item.id;
            this.formData.user_id = item.user.id;
            this.formData.name = item.user.name;
            this.formData.phone = item.user.phone;
            this.formData.email = item.user.email;
            this.formData.cinema_name = item.name;
            this.formData.address = item.address;
        },

        editCinema() {
            Inertia.post(
                route("superadmin.cinemas.edit", { id: this.selectedItem }),
                this.formData,
                {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                    onSuccess: (_) => {
                        this.formData.reset();
                        this.dialogFormVisible = !this.dialogFormVisible;
                        this.selectedItem = null;
                    },
                }
            );
        },

        async onSubmit() {
            this.$refs["formData"].validate((valid) => {
                if (valid) {
                    if (this.selectedItem === null) {
                        this.createCinema();
                    } else {
                        this.editCinema();
                    }
                }
            });
        },

        detail(id) {
            Inertia.get(
                route("superadmin.cinemas.show", { id: id }),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        onFilter() {
            this.filter.page = 1;
            this.inertia();
        },

        confirmEventDelete({ id }) {
            this.$confirm(
                `Bạn có chắc xóa hết tất cả dữ liệu của rạp này ?`,
                "Cảnh báo",
                {
                    confirmButtonText: "Chắc chắn",
                    cancelButtonText: "Hủy",
                    type: "warning",
                }
            ).then(async () => {
                Inertia.delete(route("superadmin.cinemas.delete", { id }), {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                });
            });
        },

        loginProxy(id, province_id) {
            window.location.href = route("superadmin.cinema.impersonate", [
                id,
                province_id,
            ]);
        },
    },
};
</script>
