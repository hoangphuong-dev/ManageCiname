<template>
  <div class="app">
    <div class="app__head">
      <div
        class="flex justify-between items-center m-auto h-24 max-w-screen-2xl"
      >
        <div class="flex grid-content bg-purple cursor-pointer" @click="home()">
          <el-image class="h-20" src="/images/logo.png"></el-image>
          <h1 class="text-red-600 m-4">PHC</h1>
        </div>
        <div class="app__head-menu h-full">
          <ul id="main-menu" class="flex justify-center items-center h-full">
            <li>
              <el-link
                class="text-red-900"
                :href="route('home')"
                :underline="false"
              >
                Trang chủ
              </el-link>
            </li>

            <!-- menu phim  -->
            <li>
              <el-dropdown @command="handleCommand" trigger="click">
                <el-link :underline="false">Phim</el-link>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item command="now_showing">
                      <div class="w-36 flex justify-between">
                        <div class="flex items-center justify-center">
                          <span class="whitespace-nowrap mt-1-5"
                            >Phim đang chiếu</span
                          >
                        </div>
                        <div class="flex items-center">
                          <el-icon><arrow-right /></el-icon>
                        </div>
                      </div>
                    </el-dropdown-item>
                    <hr />
                    <el-dropdown-item command="coming_soon">
                      <div class="w-36 flex justify-between">
                        <div class="flex items-center justify-center">
                          <span class="whitespace-nowrap mt-1"
                            >Phim sắp chiếu</span
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
            </li>
            <li
              :class="{ 'menu-active': activeMenu(menu) }"
              v-for="menu in menus"
              :key="menu.path"
            >
              <el-link
                class="text-red-900"
                :href="route(menu.path)"
                :underline="false"
              >
                {{ menu.label }}
              </el-link>
            </li>
          </ul>
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
                      :src="getImage(user.image) || '/uploads/customer.png'"
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
                      <div class="flex items-center justify-center">
                        <span class="whitespace-nowrap mt-1-5">Tài khoản</span>
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
                      <div class="flex items-center justify-center">
                        <span class="whitespace-nowrap mt-1">Đăng xuất</span>
                      </div>
                      <div class="flex items-center">
                        <el-icon><arrow-right /></el-icon>
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
                :href="route('customer.login')"
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
      <!-- footer -->
      <div class="w-full bg-red-100 h-60 pt-6">
        <div class="w-5/6 flex m-auto">
          <div class="w-1/3 mr-4 p-2" v-for="item in 3" :key="item">
            <h2>LIÊN HỆ</h2>
            <h4 class="py-2">CÔNG TY CỔ PHẦN PHC MEDIA</h4>
            <h6 class="py-2">
              Địa chỉ trụ sở:17 Tạ Quang Bửu - Hai Bà Trưng - Hà Nội
            </h6>
            <h6 class="py-2">Hotline: 0934 632 682</h6>
            <h6 class="py-2">Email: phuonght@phc.vn</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import AlertNoticeMixin from "@/Mixins/alert-notice";
import { ArrowDown, ArrowRight } from "@element-plus/icons-vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default defineComponent({
  components: {
    ArrowDown,
    ArrowRight,
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
          path: "home",
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
    home() {
      Inertia.get(route("home"), { onBefore, onFinish });
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
      console.log(file);
      if (!file) return;
      if (this.isValidHttpUrl(file)) return file;
      return `/uploads/${file}`;
    },

    handleCommand(command) {
      switch (command) {
        case "logout":
          window.location.href = route("customer.logout");
          break;
        case "profile":
          window.location.href =
            this.user.role === 3 ? route("profile") : route("customer.login");
          break;
        case "now_showing":
          window.location.href = route("now_showing");
          break;
        case "coming_soon":
          window.location.href = route("comming_soon");
          break;

        default:
          break;
      }
    },
    onMenuClick(menu) {
      window.location.href = menu.path;
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