<template>
    <div class="MenuAdmin h-screen flex overflow-hidden">
        <el-aside class="AsideMenu bg-white flex-shrink-0">
            <div class="h-16 justify-items-center border-b-2">
                <a href="/" class="flex">
                    <img class="h-14" src="/images/logo.png" />
                    <h1 class="text-red-600 my-3">PHC</h1>
                </a>
            </div>

            <div class="menu-vertical">
                <div
                    v-for="menu in menus"
                    :key="menu.path"
                    class="MenuItem min-h-64 py-3 flex text-2xl hover:cursor-pointer"
                    :class="{ IsActive: activeMenu(menu) }"
                    @click="onMenuClick(menu)"
                >
                    <div class="flex items-center">
                        <img
                            class="w-6 h-6 mr-4 ml-2 IconMenuItem"
                            :src="'/images/' + menu.icon + '.svg'"
                        />
                        <div class="text-base">{{ menu.label }}</div>
                    </div>
                </div>
            </div>
        </el-aside>

        <el-container>
            <el-header
                class="h-16 border border-gray-200 flex items-center bg-white"
            >
                <div class="ml-auto flex items-center mr-5">
                    <div class="mr-3">
                        <button
                            v-if="$page?.props?.auth?.impersonate"
                            @click="leaveImpersonate()"
                            class="bg-orange-600 text-white px-3.5 py-2 m-auto button-shadow rounded text-2sm mr-3 flex items-center"
                        >
                            <span class="mr-1 text-white whitespace-nowrap"
                                >Đăng xuất ủy quyền</span
                            >
                            <el-icon :size="20"><switch-button /></el-icon>
                        </button>
                    </div>
                    <div class="mr-3">
                        <!-- popup nitification   -->
                        <PopupNotification />
                    </div>
                    <h3>{{ user?.name || "" }}</h3>
                    <el-dropdown trigger="click" @command="handleCommand">
                        <span
                            class="el-dropdown-link flex items-center justify-center"
                        >
                            <el-image
                                class="rounded-full w-10 h-10 ml-2 border"
                                :src="user?.avatar || ''"
                            >
                                <template #error>
                                    <div class="mt-3 ml-2 font-black">
                                        {{
                                            user?.name
                                                ?.substring(0, 2)
                                                .toUpperCase()
                                        }}
                                    </div>
                                </template> </el-image
                            ><el-icon class="el-icon--right"
                                ><arrow-down
                            /></el-icon>
                        </span>

                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item
                                    command="profile"
                                    class="custom-drop-user-first"
                                >
                                    <div class="w-36 flex justify-between">
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <span
                                                class="whitespace-nowrap mt-1-5"
                                                >Hồ sơ</span
                                            >
                                        </div>
                                        <div class="flex items-center">
                                            <el-icon><arrow-right /></el-icon>
                                        </div>
                                    </div>
                                </el-dropdown-item>
                                <hr />
                                <el-dropdown-item
                                    command="logout"
                                    class="custom-drop-user-second"
                                >
                                    <div class="w-36 flex justify-between">
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <span class="whitespace-nowrap mt-1"
                                                >Đăng xuất</span
                                            >
                                        </div>
                                        <div class="flex items-center">
                                            <el-icon><arrow-right /></el-icon>
                                        </div>
                                    </div>
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </div>
            </el-header>
            <el-main class="bg-gray-100 relative">
                <slot name="main"></slot>
            </el-main>
        </el-container>
    </div>
</template>

<script>
import { Menu } from "@element-plus/icons";
import AlertNoticeMixin from "@/Mixins/alert-notice";
import { ArrowDown, ArrowRight, Right, Watch } from "@element-plus/icons-vue";
import PopupNotification from "@/Components/Notifications/Popup.vue";
import { ElLoading } from "element-plus";

export default {
    name: "AdminLayout",
    components: {
        Menu,
        ArrowDown,
        ArrowRight,
        Right,
        Watch,
        PopupNotification,
    },
    mixins: [AlertNoticeMixin],
    computed: {
        user() {
            if (this.$page.props.user?.role !== 3) {
                return this.$page.props.user;
            }
            return null;
        },

        menus() {
            if (this.user?.role === 0) {
                return this.menuSuper;
            } else if (this.user?.role === 2) {
                return this.menuStaff;
            } else if (this.user?.role === 4) {
                return this.menuAdmin;
            }
        },
    },
    data() {
        return {
            menuSuper: [
                {
                    label: "Trang chủ",
                    icon: "home",
                    path: "superadmin.home",
                },
                {
                    label: "Quản lý phim",
                    icon: "movie",
                    path: "superadmin.movie.index",
                },
                {
                    label: "Hệ thống rạp",
                    icon: "cinema",
                    path: "superadmin.cinema.master",
                },
                {
                    label: "Quản lý loại ghế",
                    icon: "seat",
                    path: "superadmin.seat_type.index",
                },
            ],
            menuAdmin: [
                {
                    label: "Trang chủ",
                    icon: "home",
                    path: "admin.home",
                },
                {
                    label: "Quản lý rạp",
                    icon: "bill",
                    path: "admin.cinemas.show",
                },
                {
                    label: "Quản lý hóa đơn",
                    icon: "bill",
                    path: "admin.bill.index",
                },
                {
                    label: "Quản lý nhân viên",
                    icon: "staff",
                    path: "admin.staff.index",
                },
            ],
            menuStaff: [
                {
                    label: "Trang chủ",
                    icon: "home",
                    path: "staff.home",
                },
                {
                    label: "Phim đang chiếu",
                    icon: "movie",
                    path: "staff.movie.now-showing",
                    param: {
                        display: 1,
                    },
                },
                {
                    label: "Phim sắp chiếu",
                    icon: "movie",
                    path: "staff.movie.comming-soon",
                    param: {
                        display: 2,
                        redirect: "customer",
                    },
                },
            ],
        };
    },
    methods: {
        onMenuClick(menu) {
            const loading = ElLoading.service({
                lock: true,
            });
            setTimeout(() => {
                loading.close();
                this.$inertia.visit(route(menu.path), menu?.param);
            }, 500);
        },
        activeMenu(menu) {
            return (
                route().current(menu.path) ||
                (menu?.other || []).includes(route().current())
            );
        },

        leaveImpersonate() {
            console.log(8888, this.$page.props.user);
        },

        handleCommand(command) {
            switch (command) {
                case "logout":
                    let key = "";
                    if (this.user.role === 0) {
                        key = route("superadmin.logout_super");
                    } else if (this.user.role == 4) {
                        key = route("admin.logout_admin");
                    } else {
                        key = route("staff.logout");
                    }
                    window.location.href = key;
                    break;
                default:
                    break;
            }
        },
    },
};
</script>
<style>
.MenuAdmin .AsideMenu {
    width: 16.25rem;
    border-right: 1px solid #d8d8d8;
}
@media only screen and (max-width: 1024px) {
    .MenuAdmin .AsideMenu {
        width: 0;
    }
}
.MenuAdmin .AsideMenuExpand {
    width: 100%;
}
.MenuAdmin .el-header {
    padding: 0 !important;
    height: 4rem;
}
.MenuAdmin .IconMenuItem {
    width: 27px;
    height: 27px;
}
.MenuAdmin .MenuItem.IsActive {
    background: #ff7777;
    color: white;
    font-weight: 700;
}
.MenuAdmin .MenuItem.IsActive .IconMenuItem {
    filter: brightness(0) invert(1);
}
.MenuAdmin .el-main {
    --el-main-padding: auto;
}
.MenuAdmin .el-dialog {
    border-radius: 0.5rem;
}
.MenuAdmin .el-dialog__header {
    border-radius: 0.5rem 0.5rem 0px 0px;
    background: #ff7777;
    color: white;
    font-size: 1.25rem;
    line-height: 1.25rem;
    font-weight: 700;
    text-align: center;
}
.MenuAdmin .el-form-item__label {
    font-size: 0.875rem;
    line-height: 0.875rem;
}
.MenuAdmin .el-date-editor.el-input,
.el-date-editor.el-input__inner {
    width: 100%;
    color: var(--el-aside-width);
}
</style>
