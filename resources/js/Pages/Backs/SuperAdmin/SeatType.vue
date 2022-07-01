<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-500">Danh sách thể loại ghế</h2>
                <div class="w-full flex relative">
                    <div class="w-3/4 flex items-end">
                        <div class="search">
                            <search-input
                                :filter="filter"
                                v-model="filter.name"
                                label="Nhập tên thể loại"
                                @submit="onSubmitSearch"
                            ></search-input>
                        </div>
                    </div>
                    <div class="w-1/4 flex items-end">
                        <button
                            class="ml-auto btn-primary bg-red-400"
                            @click="onOpenDialog"
                        >
                            +Tạo mới
                        </button>
                    </div>
                </div>

                <div class="mt-5">
                    <data-table
                        :fields="fields"
                        :items="seatTypes.data"
                        :paginate="seatTypes.meta"
                        :current-page="filter.page || 1"
                        disable-table-info
                        footer-center
                        paginate-background
                        @page="handleCurrentPage"
                    >
                        <template #image="{ row }">
                            <div>
                                <el-image
                                    class="mr-5 cursor-pointer h-32"
                                    :src="getImage(row?.image)"
                                ></el-image>
                            </div>
                        </template>

                        <template #created_at="{ row }">
                            {{ formatDateTime(row?.created_at) }}
                        </template>

                        <template #actions="{ row }">
                            <div v-if="row" class="flex items-center">
                                <template v-if="!row.status">
                                    <button
                                        class="btn-warning bg-gray-200"
                                        @click="edit(row)"
                                    >
                                        <img
                                            src="/images/svg/edit.svg"
                                            class="size-icon"
                                            alt=""
                                        />
                                    </button>
                                    &nbsp;
                                </template>
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
                            </div>
                        </template>
                    </data-table>
                </div>
            </div>

            <!-- dialog create notification -->
            <div class="dialog-form-notice">
                <el-dialog
                    v-model="dialogVisible"
                    width="60%"
                    :title="
                        selectedItem === null
                            ? 'Thêm thể  loại'
                            : 'Sửa thể loại'
                    "
                >
                    <el-form
                        ref="formData"
                        :model="formData"
                        label-position="top"
                        :rules="rules"
                    >
                        <div class="w-full flex">
                            <div class="w-1/3">
                                <el-form-item
                                    label="Ảnh loại ghế"
                                    prop="image"
                                    ref="file"
                                >
                                    <div
                                        class="md:w-1/8 lg:w-2/10 mb-2 md:block flex justify-center"
                                    >
                                        <div
                                            class="w-64 h-40 flex justify-center items-center border rounded hover:cursor-pointer"
                                            @click="$refs.inputUpload.click()"
                                        >
                                            <div
                                                class="xl:flex flex-col justify-center items-center"
                                                v-if="!imagePreview"
                                            >
                                                <div
                                                    class="flex justify-center mb-1"
                                                ></div>
                                                <p class="text-red-400">
                                                    ＋Chọn ảnh
                                                </p>
                                            </div>
                                            <img
                                                v-else
                                                :src="imagePreview"
                                                class="rounded w-full h-full object-cover"
                                            />
                                            <input
                                                class="hidden"
                                                ref="inputUpload"
                                                type="file"
                                                @change="
                                                    handleFileChange($event)
                                                "
                                            />
                                        </div>
                                    </div>
                                </el-form-item>
                            </div>
                        </div>

                        <el-form-item
                            label="Tên thể loại"
                            :inline-message="$errors.check('name')"
                            prop="name"
                        >
                            <el-input v-model="formData.name" type="text" />
                        </el-form-item>
                        <el-form-item
                            label="Giá tiền"
                            :inline-message="$errors.check('price')"
                            prop="price"
                        >
                            <el-input v-model="formData.price" type="text" />
                        </el-form-item>
                    </el-form>
                    <template #footer>
                        <span class="dialog-footer flex justify-center gap-2.5">
                            <button
                                class="btn-info"
                                type="info"
                                @click="dialogVisible = false"
                            >
                                Hủy
                            </button>
                            <button
                                class="btn-primary bg-red-400"
                                @click="onSubmit"
                            >
                                {{ selectedItem === null ? "Thêm" : "Sửa" }}
                            </button>
                        </span>
                    </template>
                </el-dialog>
            </div>
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
        seatTypes: {
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
            imagePreview: "",
            selectedItem: null,
            loading: false,
            dialogVisible: false,

            formData: this.$inertia.form({
                name: "",
                price: "",
                image: "",
            }),

            fields: [
                { key: "image", label: "Ảnh" },
                { key: "name", label: "Loại ghế", width: 350 },
                { key: "price", label: "Giá tiền", width: 150 },
                { key: "created_at", label: "Ngày tạo", width: 200 },
                { key: "actions", label: "Hành động", width: 150 },
            ],
            rules: {
                image: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "blur",
                    },
                ],
                name: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "blur",
                    },
                ],
                price: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "change",
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
        formatDateTime: formatDateTime,
        inertia() {
            Inertia.get(
                route("superadmin.seat_type.index", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },
        onSubmitSearch() {
            this.filter.page = 1;
            this.inertia();
        },

        onOpenDialog() {
            this.formData.reset();
            if (this.$refs.formData) {
                this.$refs.formData.clearValidate();
            }
            this.selectedItem = null;
            this.imagePreview = "";
            this.dialogVisible = !this.dialogVisible;
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },

        createSeatType() {
            Inertia.post(route("superadmin.seat_type.store"), this.formData, {
                onBefore,
                onFinish,
                preserveScroll: true,
                onError: (e) => console.log(e),
                onSuccess: (_) => {
                    this.formData.reset();
                    this.dialogVisible = !this.dialogVisible;
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

        confirmEventDelete({ id }) {
            this.$confirm(`Bạn có chắc chắn muốn xóa ?`, "Cảnh báo", {
                confirmButtonText: "Chắc chắn",
                cancelButtonText: "Hủy",
                type: "warning",
            }).then(async () => {
                Inertia.delete(route("superadmin.seat_type.delete", { id }), {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                });
            });
        },

        edit(row) {
            this.imagePreview = this.getImage(row?.image);
            this.selectedItem = row?.id;
            this.formData.name = row?.name;
            this.formData.image = row?.image;
            this.formData.price = row?.price;
            this.dialogVisible = true;
        },

        editSeatType() {
            Inertia.post(
                route("superadmin.seat_type.update", {
                    id: this.selectedItem,
                }),
                this.formData,
                {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                    onSuccess: (_) => {
                        this.formData.reset();
                        this.dialogVisible = !this.dialogVisible;
                        this.selectedItem = null;
                    },
                }
            );
        },

        handleFileChange(e) {
            const files = e.target.files || e.dataTransfer.files;
            if (files.length) {
                const image = files[0];
                if (!image.name.match(/.(jpg|jpeg|png)$/i)) {
                    return this.$message.error("Lỗi định dạng file");
                }

                let reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                this.formData.image = image;
                reader.readAsDataURL(image);
            }
        },
    },
};
</script>
