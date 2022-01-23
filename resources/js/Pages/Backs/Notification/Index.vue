<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">お知らせ一覧</h2>

                <div class="w-full flex relative">
                    <div class="w-3/4 flex items-end">
                        <div class="mr-2">
                            <div class="text-sm text-blackPrimary-300">
                                送信対象
                            </div>
                            <el-select
                                v-model="filter.status"
                                placeholder="検索"
                                @change="onChangeStatus"
                            >
                                <el-option
                                    v-for="item in statusList"
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
                                label="検索"
                                @submit="onSubmitSearch"
                            ></search-input>
                        </div>
                    </div>
                    <div class="w-1/4 flex items-end">
                        <button
                            class="ml-auto btn-primary"
                            @click="onOpenDialog"
                        >
                            +登録
                        </button>
                    </div>
                </div>

                <div class="mt-5">
                    <data-table
                        :fields="fields"
                        :items="notifications.data"
                        :paginate="notifications.meta"
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
                                    row?.status
                                        ? 'bg-lightGreen'
                                        : 'bg-yellowPrimary',
                                ]"
                            >
                                {{ row?.status ? "Delivered" : "Pending" }}
                            </p>
                        </template>
                        <template #receiver="{ row }">
                            <div
                                class="receiver-parent"
                                v-html="renderReceiver(row)"
                            ></div>
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
                                <el-popconfirm
                                    confirm-button-text="Yes"
                                    cancel-button-text="No"
                                    icon-color="red"
                                    title="Are you sure to delete this?"
                                    @confirm="confirmEventDelete(row)"
                                >
                                    <template #reference>
                                        <button class="btn-warning bg-gray-200">
                                            <img
                                                src="/images/svg/trash.svg"
                                                alt=""
                                                class="size-icon"
                                            />
                                        </button>
                                    </template>
                                </el-popconfirm>

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

            <!-- dialog create notification -->
            <div class="dialog-form-notice">
                <el-dialog
                    v-model="dialogVisible"
                    width="60%"
                    :title="
                        selectedItem === null
                            ? 'お知らせ登録'
                            : 'Edit Notification'
                    "
                    :before-close="onCloseDialog"
                >
                    <el-form
                        ref="formData"
                        :model="formData"
                        label-position="top"
                        :rules="rules"
                    >
                        <el-form-item
                            :show-message="$errors.check('receiver_ids')"
                            :inline-message="$errors.check('receiver_ids')"
                            :error="$errors.first('receiver_ids')"
                            prop="receiver_ids"
                        >
                            <div class="flex">
                                <label for=""> Tên tài khoản </label>
                                &nbsp; &nbsp; &nbsp;
                                <div>
                                    <el-checkbox
                                        v-model="formData.isAllHospital"
                                        label="All Hospital"
                                        @change="onChangeAllHospital"
                                    ></el-checkbox>
                                    <el-checkbox
                                        v-model="formData.isAllCaretaker"
                                        label="All Caretaker"
                                        @change="onChangeAllCaretaker"
                                    ></el-checkbox>
                                </div>
                            </div>
                            <el-select
                                v-model="formData.receiver_ids"
                                multiple
                                filterable
                                remote
                                reserve-keyword
                                placeholder="Please enter a keyword"
                                class="SelectSearch w-full"
                            >
                                <el-option
                                    v-for="item in optionReceiver"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                                ></el-option>
                            </el-select>
                        </el-form-item>
                        <el-row :gutter="10">
                            <el-col :md="18">
                                <el-form-item
                                    label="Title"
                                    :inline-message="$errors.check('title')"
                                    :error="$errors.first('title')"
                                    prop="title"
                                >
                                    <el-input
                                        v-model="formData.title"
                                        type="text"
                                    />
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item
                                    label="Date"
                                    :inline-message="$errors.check('date')"
                                    :error="$errors.first('date')"
                                    prop="schedule"
                                >
                                    <el-date-picker
                                        v-model="formData.schedule"
                                        type="datetime"
                                        class="w-full"
                                        placeholder="Pick a day"
                                        format="YYYY/MM/DD HH:mm"
                                        value-format="YYYY-MM-DD HH:mm"
                                        :disabled-date="disabledDate"
                                        :shortcuts="shortcuts"
                                    ></el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-form-item
                            label="Content"
                            :inline-message="$errors.check('content')"
                            :error="$errors.first('content')"
                            prop="content"
                        >
                            <editor
                                api-key="4ef3zvav0qudmex3qwfywihrcyw1nenban69inpf40obfgdh"
                                v-model="formData.content"
                                :init="{
                                    height: 500,
                                    menubar: false,
                                    plugins: [
                                        'fullscreen advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table paste code help wordcount image',
                                    ],
                                    toolbar:
                                        'fullscreen | undo redo | formatselect | bold italic forecolor backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | image',
                                    image_title: true,
                                    automatic_uploads: true,
                                    file_picker_types: 'image',
                                    file_picker_callback: filePicker,
                                    image_description: false,
                                    image_title: false,
                                    fullscreen_native: true,
                                }"
                            />
                        </el-form-item>
                    </el-form>
                    <template #footer>
                        <span class="dialog-footer flex justify-center gap-2.5">
                            <button
                                class="btn-info"
                                type="info"
                                @click="dialogVisible = false"
                            >
                                キャンセル
                            </button>
                            <button class="btn-primary" @click="onSubmit">
                                登録
                            </button>
                        </span>
                    </template>
                </el-dialog>
            </div>

            <div class="dialog-form-notice">
                <el-dialog
                    v-model="dialogVisibleDetail"
                    width="60%"
                    :title="
                        detailSelected.title + ' - ' + detailSelected.schedule
                    "
                >
                    <div
                        v-html="'Delivery To: ' + generateReceiverDetail()"
                    ></div>
                    <hr />
                    <div
                        v-html="detailSelected.content"
                        style="max-height: 600px; overflow: auto"
                    ></div>
                    <template #footer>
                        <span class="dialog-footer flex justify-center gap-2.5">
                            <button
                                class="btn-info"
                                type="info"
                                @click="dialogVisibleDetail = false"
                            >
                                キャンセル
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
import { formatDateTime } from "@/libs/datetime";
import Editor from "@tinymce/tinymce-vue";
import axios from "@/plugins/axios";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { listReceiver } from "@/API/notification.js";
import {
    ROLE_USER,
    ROLE_HOSPITAL,
    NOTIFICATION_TYPE_CARETAKER,
    NOTIFICATION_TYPE_HOSPITAL,
    NOTIFICATION_TYPE_ALL,
} from "@/store/const";
import { ElLoading } from "element-plus";

export default {
    name: "Notification",
    components: {
        AdminLayout,
        SearchInput,
        DataTable,
        Editor,
    },
    props: {
        notifications: {
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectedItem: null,
            loading: false,
            dialogVisible: false,
            dialogVisibleDetail: false,
            hospitals: [],
            statusList: [
                {
                    value: "",
                    label: "全て",
                },
                {
                    value: 1,
                    label: "Delivered",
                },
                {
                    value: 0,
                    label: "Pending",
                },
            ],
            formData: this.$inertia.form({
                receiver_ids: [],
                title: "",
                schedule: "",
                content: "",
                isAllHospital: false,
                isAllCaretaker: false,
            }),
            fields: [
                {
                    key: "title",
                    label: "タイトル",
                },

                {
                    key: "receiver",
                    label: "受信者",
                    width: 250,
                },
                {
                    key: "schedule",
                    label: "配信日時",
                    width: 200,
                },
                {
                    key: "status",
                    label: "ステータス",
                    width: 180,
                },
                {
                    key: "actions",
                    label: "アクション",
                    width: 250,
                },
            ],
            list: [],
            options: [],
            receivers: [],
            shortcuts: [
                {
                    text: "Today",
                    value: new Date(),
                },
                {
                    text: "Yesterday",
                    value: () => {
                        const date = new Date();
                        date.setTime(date.getTime() - 3600 * 1000 * 24);
                        return date;
                    },
                },
                {
                    text: "A week ago",
                    value: () => {
                        const date = new Date();
                        date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                        return date;
                    },
                },
            ],
            rules: {
                title: [
                    {
                        required: true,
                        message: "Please input",
                        trigger: "blur",
                    },
                ],
                content: [
                    {
                        required: true,
                        message: "Please input",
                        trigger: "blur",
                    },
                ],
                receiver_ids: [
                    {
                        validator: (rule, value, callback) => {
                            if (
                                value.length === 0 &&
                                !this.formData.isAllHospital &&
                                !this.formData.isAllCaretaker
                            ) {
                                callback(new Error("Please input"));
                            }
                            callback();
                        },
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
                status: this.filtersBE?.status?.toInt(),
                title: this.filtersBE?.title || "",
            };
        },
        optionReceiver() {
            if (this.formData.isAllHospital && this.formData.isAllCaretaker) {
                return [];
            }

            if (!this.formData.isAllHospital && !this.formData.isAllCaretaker) {
                return this.options;
            }

            let arr = [];
            for (const item of this.options) {
                if (this.formData.isAllHospital && item.role === ROLE_USER) {
                    arr.push(item);
                } else if (
                    this.formData.isAllCaretaker &&
                    item.role === ROLE_HOSPITAL
                ) {
                    arr.push(item);
                }
            }

            return arr;
        },
        detailSelected() {
            if (this.selectedItem === null) {
                return {};
            }
            return this.notifications.data.find(
                (item) => item.id === this.selectedItem
            );
        },
    },
    methods: {
        inertia() {
            Inertia.get(
                route("back.notifications", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },
        onSubmitSearch() {
            this.filter.page = 1;
            this.inertia();
        },
        onChangeStatus() {
            this.filter.page = 1;
            this.inertia();
        },
        disabledDate(time) {
            let d = new Date();
            return time.getTime() < d.setDate(d.getDate() - 1);
        },
        async onOpenDialog() {
            this.formData.reset();
            this.selectedItem = null;
            this.loading = true;
            await this.getReceivers("");
            this.dialogVisible = !this.dialogVisible;
            this.loading = false;
        },
        onCloseDialog() {
            this.dialogVisible = !this.dialogVisible;
        },
        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },
        async getReceivers(name) {
            if (this.options.length > 0) return;
            const {
                data: { status, data },
            } = await listReceiver({ name: name });

            if (status === 200) {
                this.options = [...data];
            }
        },
        formatDateTime,
        createNotification() {
            Inertia.post(route("back.notifications.store"), this.formData, {
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
                        this.createNotification();
                    } else {
                        this.editNotification();
                    }
                }
            });
        },
        filePicker(cb, value, meta) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");

            input.onchange = async function () {
                var file = this.files[0];

                const formData = new FormData();
                formData.append("image", file);

                const {
                    data: { status, url },
                } = await axios.post("/admin/upload-image", formData);

                if (status === 200) {
                    cb(url, {
                        title: file.name,
                    });
                }
            };

            input.click();
        },
        getUserSelectedByRole(role) {
            let arr = [];
            for (const item of this.formData.receiver_ids) {
                const user = this.options.find((i) => i.id === item);
                if (user?.role === role) {
                    arr.push(item);
                }
            }
            return arr;
        },
        onChangeAllHospital(val) {
            if (val) {
                this.formData.receiver_ids = [
                    ...this.getUserSelectedByRole(ROLE_USER),
                ];
            }
        },
        onChangeAllCaretaker(val) {
            if (val) {
                this.formData.receiver_ids = [
                    ...this.getUserSelectedByRole(ROLE_HOSPITAL),
                ];
            }
        },
        renderReceiver(row) {
            if (
                typeof row === "undefined" ||
                Object.entries(row).length === 0
            ) {
                return;
            }

            const notificationManager = row.notification_manager;

            if (notificationManager?.length === 1) {
                const { type, user } = notificationManager.last();
                if (type === null) {
                    return user?.name;
                } else if (type === NOTIFICATION_TYPE_ALL) {
                    return "<span class='font-bold'>All</span>";
                } else if (type === NOTIFICATION_TYPE_HOSPITAL) {
                    return "<span class='font-bold'>All Hospital</span>";
                } else if (type === NOTIFICATION_TYPE_CARETAKER) {
                    return "<span class='font-bold'>All Caretaker</span>";
                }
            }

            for (const item of notificationManager) {
                if (
                    [
                        NOTIFICATION_TYPE_CARETAKER,
                        NOTIFICATION_TYPE_HOSPITAL,
                    ].includes(item.type)
                ) {
                    return "<span class='font-bold'>Other</span>";
                }
            }

            return `<span class="receiver-count ${
                notificationManager.length <= 5
                    ? "receiver-green"
                    : "receiver-orange"
            }">+${notificationManager.length}</span>`;
        },
        confirmEventDelete({ id }) {
            Inertia.delete(route("back.notifications.delete", { id }), {
                onBefore,
                onFinish,
                preserveScroll: true,
                onError: (e) => console.log(e),
            });
        },
        detail({ id }) {
            this.dialogVisibleDetail = true;
            this.selectedItem = id;
        },
        generateReceiverDetail() {
            const notificationManager =
                this.detailSelected.notification_manager;
            if (typeof notificationManager === "undefined") return;
            let xhtml = ``;
            for (const [index, item] of Object.entries(notificationManager)) {
                if (item.type === NOTIFICATION_TYPE_ALL) {
                    xhtml += "<span class='font-bold'>All</span>";
                } else if (item.type === NOTIFICATION_TYPE_HOSPITAL) {
                    xhtml += "<span class='font-bold'>All Hospital</span>";
                } else if (item.type === NOTIFICATION_TYPE_CARETAKER) {
                    xhtml += "<span class='font-bold'>All Caretaker</span>";
                } else {
                    xhtml += item?.user?.name;
                }
                xhtml +=
                    parseInt(index) !== notificationManager.length - 1
                        ? ", "
                        : "";
            }
            return xhtml;
        },
        async edit({ id, content, title, schedule, notification_manager }) {
            this.selectedItem = id;
            let loadingService = ElLoading.service({ fullscreen: true });
            await this.getReceivers("");
            loadingService.close();

            this.formData.content = content;
            this.formData.title = title;
            this.formData.schedule = schedule;

            for (const item of notification_manager || []) {
                if (item.type === NOTIFICATION_TYPE_CARETAKER) {
                    this.formData.isAllCaretaker = true;
                } else if (item.type === NOTIFICATION_TYPE_HOSPITAL) {
                    this.formData.isAllHospital = true;
                } else if (item.type === NOTIFICATION_TYPE_ALL) {
                    this.formData.isAllCaretaker = true;
                    this.formData.isAllHospital = true;
                } else {
                    this.formData.receiver_ids.push(item.user.id);
                }
            }

            this.dialogVisible = true;
        },
        editNotification() {
            Inertia.post(
                route("back.notifications.update", { id: this.selectedItem }),
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
    },
};
</script>

<style>
.SelectSearch [type="text"]:focus {
    box-shadow: none;
}

.dialog-form-notice .el-overlay {
    z-index: 10 !important;
}

.receiver-parent {
    height: 40px;
    display: flex;
    align-items: center;
}

.receiver-count {
    display: block;
    border: 1px solid #cccccc;
    border-radius: 50%;
    padding: 3px;
    min-width: 33px;
    text-align: center;
}

.receiver-orange {
    border-color: #fca442;
}

.receiver-green {
    border-color: #a5c242;
}

.size-icon {
    height: 23px;
}
</style>
