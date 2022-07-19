<template>
    <div>
        <el-popover
            placement="bottom-end"
            :width="400"
            trigger="click"
            v-model:visible="isShowNotification"
        >
            <template #reference>
                <div class="icon-notice flex relative">
                    <el-image
                        class="cursor-pointer w-8 lg:w-10 logo-global hover-animation"
                        src="/images/noti.svg"
                    ></el-image>
                    <span
                        class="absolute notification-count cursor-pointer"
                        v-if="notificationCount > 0"
                    >
                        {{ notificationCount > 9 ? "9+" : notificationCount }}
                    </span>
                </div>
            </template>

            <!-- danh sach thong bao -->
            <div class="height-500">
                <div class="header flex justify-between items-center h-7">
                    <div class="p-4 font-bold">Danh sách thông báo</div>
                </div>
                <hr />
                <div
                    class="notification overflow-y-auto custom-scroll"
                    style="height: 400px"
                    v-loading="isLoading"
                    @scroll="onScroll"
                    id="bx-nt"
                >
                    <ul v-if="data.length > 0">
                        <li
                            class="flex cursor-pointer border-cs notice justify-between px-1 min-h-[55px]"
                            v-for="(item, index) in data"
                            :key="index"
                            @click="showNotice(item.id, index)"
                        >
                            <div class="flex flex-1 overflow-hidden">
                                <img
                                    width="60"
                                    height="50"
                                    src="/images/logo.png"
                                />
                                <div class="w-2 h-1"></div>
                                <div
                                    class="content flex-1"
                                    style="width: calc(100% - 52px)"
                                >
                                    <p
                                        class="text-black pt-1 break-all"
                                        :class="{
                                            'font-bold': item.read_at === null,
                                        }"
                                        v-html="xss(item?.data?.title)"
                                    ></p>
                                    <p v-html="xss(item?.data?.content)"></p>

                                    <p>{{ showTime(item.created_at) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-4">
                                <span
                                    class="dot"
                                    v-if="item.read_at === null"
                                ></span>
                            </div>
                        </li>
                    </ul>
                    <el-empty
                        v-else
                        description="Không có thông báo"
                        class="mt-2"
                    ></el-empty>
                </div>
            </div>
            <!-- ket thuc danh sach thong bao  -->
        </el-popover>
    </div>
</template>

<script>
import { getAllNotification, markRead } from "@/API/notification.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import xss from "@/Helpers/xss";
import { showTime } from "@/libs/datetime.js";
export default {
    data() {
        return {
            isShowNotification: false,
            isLoading: true,
            isLoadingMore: false,
            isAllowLoadMore: true,
            notifications: [],
            data: [],
            notificationCount: 0,
        };
    },
    mounted() {
        this.notificationCount = this.$page.props?.unreadNotifications || 0;
    },

    methods: {
        showTime,
        xss,
        onMountedFunc() {
            this.page = 1;
            this.isAllowLoadMore = true;
            this.isLoading = true;
            this.data = [];
            this.loadMore();
        },

        async loadMore() {
            await getAllNotification(this.page)
                .then((res) => {
                    this.data = res.status === 200 ? res.data.data : [];
                    this.isLoading = false;
                    this.isLoadingMore = false;
                    if (this.data.length < res.per_page) {
                        this.isAllowLoadMore = false;
                    }
                })
                .catch(() => {});
        },

        async showNotice(id, index) {
            const { type } = this.data[index];
            if (type === "App\\Notifications\\RegisterStaff") {
                if (this.data[index].read_at === null) {
                    await markRead(id).then((res) => {
                        this.notificationCount > 0 && this.notificationCount--;
                    });
                }
                return Inertia.get(
                    route("admin.staff.index"),
                    { email: this.data[index].data.email },
                    { onBefore, onFinish, preserveScroll: true }
                );
            } else {
                // return Inertia.get(
                //   "https://www.youtube.com/watch?v=Tj7YO60CG-g",
                //   {},
                //   {
                //     preserveScroll: true,
                //     onBefore,
                //     onFinish,
                //   }
                // );
            }
            this.isShowNotification = false;
        },
    },

    watch: {
        isShowNotification(val) {
            if (val) {
                this.onMountedFunc();
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

.notification-count {
    width: 20px;
    height: 20px;
    background: #bf3d8f;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 100px;
    color: white;
    font-size: 12px;
    font-weight: bold;
    top: 0;
    right: -6px;
}
</style>

<style>
.el-popper__arrow {
    left: 92% !important;
}
.dialog-cs .el-dialog__body {
    border-top: 1px solid #9da0a554;
}
.el-popover-custom {
    padding: 0 !important;
}
.custom-notice-detail .el-icon.el-dialog__close {
    font-size: 25px;
    margin-right: -10px;
    color: white;
}

.custom-notice-detail .el-dialog__body {
    padding: 0 10px;
}

.custom-notice-detail .el-dialog__header {
    padding-bottom: 20px !important;
    background: #bf3d8f;
}
.highlight-name {
    color: #bf3d8f;
}
</style>
