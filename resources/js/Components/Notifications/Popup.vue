<template>
    <div class="el-popover-custom">
        <el-popover
            placement="bottom-end"
            :width="400"
            trigger="click"
            v-model:visible="isShowNotification"
        >
            <template #reference>
                <el-image
                    style="width: 35px;"
                    class="cursor-pointer"
                    src="/images/svg/noti.svg"
                ></el-image>
            </template>
            <div class="height-500">
                <div class="header flex justify-between items-center h-7">
                    <div class="p-4">Notification</div>
                    <div></div>
                </div>
                <hr />
                <div
                    class="notification overflow-y-auto custom-scroll"
                    @scroll="onScroll"
                    style="height: 472px"
                    v-loading="isLoading"
                    id="bx-nt"
                >
                    <ul v-if="data.length > 0">
                        <li
                            class="flex cursor-pointer border-cs notice justify-between px-1"
                            v-for="(item, index) in data"
                            :key="index"
                            @click="showNotice(item.id, index)"
                        >
                            <div class="flex w-full">
                                <img width="62" height="62" src="/images/svg/anfi-icon.svg" alt="" />
                                <div class="w-2 h-1"></div>
                                <div class="content">
                                    <p
                                        class="text-black pt-1"
                                        :class="{
                                            'font-bold': item.isRead == 0,
                                        }"
                                    >
                                        {{ item.title }}
                                    </p>
                                    <p>{{ showTime(item.created_at) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center pr-1">
                                <span
                                    class="dot"
                                    v-if="item.isRead == 0"
                                ></span>
                            </div>
                        </li>
                        <div
                            v-if="isLoadingMore"
                            class="flex justify-center my-3"
                        >
                            <el-icon><loading class="loading-ico" /></el-icon>
                        </div>
                    </ul>
                    <el-empty
                        v-else
                        description="You don't have notification !"
                        class="mt-2"
                    ></el-empty>
                </div>
            </div>
        </el-popover>
        <div class="dialog-form-notice dialog-cs">
            <el-dialog
                v-model="dialogVisibleDetail"
                width="60%"
                :title="detailSelected?.title"
            >
                <div
                    v-html="detailSelected?.content"
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
    </div>
</template>

<script>
import axios from "@/plugins/axios";
import { Loading } from "@element-plus/icons-vue";
import { timeAgo } from "@/Helpers/time";

export default {
    components: {
        Loading,
    },
    data() {
        return {
            isShowNotification: false,
            isLoading: true,
            isLoadingMore: false,
            isAllowLoadMore: true,
            dialogVisibleDetail: false,
            page: 1,
            data: [],
            noticeSelected: null,
        };
    },
    computed: {
        detailSelected() {
            if (this.noticeSelected === null) {
                return {};
            }

            return this.data.find((item) => item.id === this.noticeSelected);
        },
    },
    methods: {
        onMounted() {
            this.page = 1;
            this.isAllowLoadMore = true;
            this.data = [];
            this.loadMore();
        },
        onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
            if (scrollTop + clientHeight >= scrollHeight) {
                if (this.isAllowLoadMore) {
                    this.isLoadingMore = true;

                    this.$nextTick(() => {
                        document.getElementById("bx-nt").scrollTop = 1000;
                    });

                    this.page++;
                    this.loadMore();
                }
            }
        },
        async loadMore() {
            const { data } = await axios.get(
                "/common/notification?page=" + this.page,
                this.query
            );
            this.data = [...this.data, ...data.data];
            this.isLoading = false;
            this.isLoadingMore = false;

            if (data.data.length < data.per_page) {
                this.isAllowLoadMore = false;
            }
        },
        showTime(dateTime) {
            return timeAgo(Date.parse(dateTime));
        },
        async showNotice(id, index) {
            this.isShowNotification = false;
            this.noticeSelected = id;
            this.dialogVisibleDetail = true;

            await axios.get(`/common/notification/mark-read/${id}`);
            this.data[index].isRead = 1;
        },
    },
    watch: {
        isShowNotification(val) {
            if (val) {
                this.onMounted();
            }
        },
    },
};
</script>
<style scoped>
.height-500 {
    height: 500px;
}
.border-cs {
    border-bottom: 1px solid #80808047;
}
.loading-ico {
    font-size: 40px;
    animation: rotating 2s linear infinite;
}

@keyframes rotating {
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

.custom-scroll::-webkit-scrollbar {
    width: 4px;
}

.custom-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background: #888;
}

.custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.notice:hover {
    background-color: #80808012;
}
.dot {
    width: 8px;
    height: 8px;
    background: red;
    display: block;
    border-radius: 50%;
}
</style>

<style>
.dialog-cs .el-dialog__body {
    border-top: 1px solid #9da0a554;
}
.el-popover{
    padding: 0 !important;
}
</style>
