<template>
    <div class="app">
        <div class="app__head">
            <div
                class="flex justify-between items-center m-auto h-24 max-w-screen-2xl"
            >
                <div
                    class="flex grid-content bg-purple cursor-pointer"
                    @click="redirectRoute(route('home'))"
                >
                    <el-image class="h-20" src="/images/logo.png"></el-image>
                    <h1 class="text-red-600 my-6">PHC</h1>
                </div>
                <div class="app__head-menu h-full">
                    <ul
                        id="main-menu"
                        class="flex justify-center items-center h-full"
                    >
                        <li>
                            <el-link
                                class="text-red-900"
                                :underline="false"
                                @click="redirectRoute(route('home'))"
                            >
                                Trang chủ
                            </el-link>
                        </li>
                        <!-- menu phim  -->
                        <li>
                            <el-dropdown
                                @command="handleCommand"
                                trigger="click"
                            >
                                <el-link :underline="false">Phim</el-link>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item command="now_showing">
                                            <div
                                                class="w-36 flex justify-between"
                                            >
                                                <div
                                                    class="flex items-center justify-center"
                                                >
                                                    <span
                                                        class="whitespace-nowrap mt-1-5"
                                                        >Phim đang chiếu</span
                                                    >
                                                </div>
                                                <div class="flex items-center">
                                                    <el-icon
                                                        ><arrow-right
                                                    /></el-icon>
                                                </div>
                                            </div>
                                        </el-dropdown-item>
                                        <hr />
                                        <el-dropdown-item command="coming_soon">
                                            <div
                                                class="w-36 flex justify-between"
                                            >
                                                <div
                                                    class="flex items-center justify-center"
                                                >
                                                    <span
                                                        class="whitespace-nowrap mt-1"
                                                        >Phim sắp chiếu</span
                                                    >
                                                </div>
                                                <div class="flex items-center">
                                                    <el-icon
                                                        ><arrow-right
                                                    /></el-icon>
                                                </div>
                                            </div>
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </li>
                        <li
                            :class="{ 'menu-active': activeMenu(menu) }"
                            v-for="menu in menus"
                            :key="menu.path"
                        >
                            <el-link
                                class="text-red-900"
                                @click="redirectRoute(route(menu.path))"
                                :underline="false"
                            >
                                {{ menu.label }}
                            </el-link>
                        </li>
                    </ul>
                </div>

                <div class="mr-3" v-if="user?.role === 3">
                    <PopupNotification />
                </div>

                <div class="grid-content h-full flex items-center justify-end">
                    <!-- role = 3 : Khach hang dang dang nhap -->
                    <template v-if="user?.role === 3">
                        <div class="app__head-user-name">{{ user.name }}</div>
                        <el-dropdown @command="handleCommand" trigger="click">
                            <span class="el-dropdown-link">
                                <div class="flex justify-center items-center">
                                    <div class="app__head-profile rounded">
                                        <el-avatar
                                            shape="square"
                                            :size="50"
                                            :src="
                                                getImage(user.image) ||
                                                '/uploads/customer.png'
                                            "
                                        />
                                    </div>
                                    <el-icon class="el-icon--right">
                                        <arrow-down />
                                    </el-icon>
                                </div>
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
                                                    >Tài khoản</span
                                                >
                                            </div>
                                            <div class="flex items-center">
                                                <el-icon
                                                    ><arrow-right
                                                /></el-icon>
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
                                                <span
                                                    class="whitespace-nowrap mt-1"
                                                    >Đăng xuất</span
                                                >
                                            </div>
                                            <div class="flex items-center">
                                                <el-icon
                                                    ><arrow-right
                                                /></el-icon>
                                            </div>
                                        </div>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </template>
                        </el-dropdown>
                    </template>
                    <template v-else>
                        <div class="px-6 py-2 rounded border">
                            <el-link
                                @click="redirectRoute(route('customer.login'))"
                                :underline="false"
                                type="primary"
                            >
                                <h3 class="text-red-400">Đăng nhập</h3>
                            </el-link>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="app__main">
            <div class="app__main_container max-w-screen-2xl m-auto">
                <!-- Page Heading -->
                <header class="bg-white shadow" v-if="$slots.header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header"></slot>
                    </div>
                </header>
                <!-- Page Content -->
                <main>
                    <slot></slot>
                </main>
            </div>
            <Footer />
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import AlertNoticeMixin from "@/Mixins/alert-notice";
import { ArrowDown, ArrowRight } from "@element-plus/icons-vue";
import PopupNotification from "@/Components/Notifications/Popup.vue";
import { Inertia } from "@inertiajs/inertia";
import { ElLoading } from "element-plus";
import Footer from "./Footer.vue";

export default defineComponent({
    components: {
        ArrowDown,
        PopupNotification,
        ArrowRight,
        Footer,
    },
    mixins: [AlertNoticeMixin],
    computed: {
        user() {
            return this.$page.props.customer;
        },
    },

    data() {
        return {
            showingNavigationDropdown: false,
            expandMenuMobile: false,
            menus: [
                {
                    label: "Rạp",
                    path: "cinema",
                },
                {
                    label: "Voucher",
                    path: "voucher",
                },
                {
                    label: "Vé của tôi",
                    path: "ticket",
                },
            ],
        };
    },
    methods: {
        redirectRoute(path) {
            const loading = ElLoading.service({
                lock: true,
            });
            setTimeout(() => {
                loading.close();
                Inertia.get(path);
            }, 500);
        },
        isValidHttpUrl(string) {
            let url;
            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }
            return url.protocol === "http:" || url.protocol === "https:";
        },

        getImage(file) {
            if (!file) return;
            if (this.isValidHttpUrl(file)) return file;
            return `/uploads/${file}`;
        },

        handleCommand(command) {
            switch (command) {
                case "logout":
                    this.redirectRoute(route("customer.logout"));
                    break;
                case "profile":
                    this.user.role === 3
                        ? this.redirectRoute(route("profile"))
                        : this.redirectRoute(route("customer.login"));
                    break;
                case "now_showing":
                    this.redirectRoute(route("home", { display: 1 }));
                    break;
                case "coming_soon":
                    this.redirectRoute(
                        route("home", { display: 2, redirect: "customer" })
                    );
                    break;
                default:
                    break;
            }
        },
        activeMenu(menu) {
            return (
                route().current(menu.path) ||
                (menu?.other || []).includes(route().current())
            );
        },
    },
});
</script>

<style scoped>
.app__head {
    background-color: #fff;
    border-bottom: 2px solid #ff7777;
}

.app__head-user-name {
    margin-right: 14px;
}

.app__head-profile {
    height: 50px;
    width: 50px;
    border: 1px solid #cccccc;
}

#main-menu li a {
    text-decoration: none;
    cursor: pointer;
    margin: 0 50px;
    align-items: center;
}

#main-menu li {
    height: 100%;
    display: flex;
    align-items: center;
}

#main-menu li:hover a {
    font-style: normal;
    color: #ff7777;
}

.menu-active {
    font-weight: bold;
}

.menu-active > a {
    color: #ff7777 !important;
}
</style>
<style lang="css">
.el-link--inner {
    font-weight: bold;
    font-size: 18px;
}
</style>
