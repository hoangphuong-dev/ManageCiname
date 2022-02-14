<template>
  <div class="app">
    <div class="app__head" :class="{ 'h-screen': expandMenuMobile }">
      <div class="flex justify-between items-center m-auto h-24 max-w-screen-2xl">
        <div class="hidden lg:flex grid-content bg-purple">
          <el-link href="/" :underline="false" class="h-20" style="width: 158px">
            <el-image class="h-20" src="images/logo.png"></el-image>
          </el-link>
        </div>
        <div class="app__head-menu h-full">
          <ul id="main-menu" class="hidden lg:flex justify-center items-center h-full">
            <li
              :class="{ 'menu-active': activeMenu(menu) }"
              v-for="menu in menus"
              :key="menu.path"
            >
              <a :href="route(menu.path)">{{ menu.label }}</a>
            </li>
          </ul>
        </div>
        <div class="grid-content h-full flex items-center justify-end">
          <template v-if="user !== null">
            <div class="app__head-notification">
              <!-- <PopupNotification /> -->
            </div>
            <div class="app__head-user-name">{{ user.name }}</div>

            <el-dropdown @command="handleCommand" trigger="click">
              <span class="el-dropdown-link">
                <div class="flex justify-center items-center">
                  <div class="app__head-profile rounded">
                    <img
                      class="w-full h-full rounded"
                      :src="getImage(user.avatar) || '/images/avatar/default.png'"
                      alt=""
                    />
                  </div>
                  <el-icon class="el-icon--right">
                    <arrow-down />
                  </el-icon>
                </div>
              </span>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item command="profile" class="custom-drop-user-first">
                    <div class="w-36 flex justify-between">
                      <div class="flex items-center justify-center">
                        <img width="12" src="/images/svg/user.svg" alt="" />
                        &nbsp;&nbsp;
                        <span class="whitespace-nowrap mt-1-5">共通設定</span>
                      </div>
                      <div class="flex items-center">
                        <el-icon><arrow-right /></el-icon>
                      </div>
                    </div>
                  </el-dropdown-item>
                  <hr />
                  <el-dropdown-item command="logout" class="custom-drop-user-second">
                    <div class="w-36 flex justify-between">
                      <div class="flex items-center justify-center">
                        <img width="12" src="/images/svg/logout.svg" alt="" />
                        &nbsp;&nbsp;
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
            <div class="mr-4 px-6 py-2 rounded border">
              <el-link :href="route('show_login')" :underline="false" type="primary">
                <h3 class="text-yellowPrimary">Đăng nhập</h3>
              </el-link>
            </div>
          </template>
        </div>
      </div>
    </div>

    <div class="app__main" :class="ClassMain">
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
      <div class="footer w-full bg-yellow-100 h-60">
        <h1 class="text-center">FFFFF</h1>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import AlertNoticeMixin from "@/Mixins/alert-notice";
import { ArrowDown, ArrowRight } from "@element-plus/icons-vue";
import PopupNotification from "@/Components/Notifications/Popup.vue";

export default defineComponent({
  props: {
    title: String,
    ClassMain: String,
  },
  components: {
    ArrowDown,
    ArrowRight,
    PopupNotification,
  },
  mixins: [AlertNoticeMixin],
  computed: {
    user() {
      return this.$page.props.user;
    },
  },
  data() {
    return {
      showingNavigationDropdown: false,
      expandMenuMobile: false,
      menus: [
        {
          label: "Phim",
          path: "hospital.notification",
        },
        {
          label: "Vé của tôi",
          path: "hospital.index",
        },
        {
          label: "Thành viên",
          path: "hospital.jobs.list",
        },
      ],
    };
  },
  methods: {
    handleCommand(command) {
      switch (command) {
        case "logout":
          window.location.href =
            this.user.role === 1 ? route("hospital.logout") : route("caretaker.logout");
          break;
        case "profile":
          window.location.href =
            this.user.role === 1 ? route("hospital.profile") : route("caretaker.profile");
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
        route().current(menu.path) || (menu?.other || []).includes(route().current())
      );
    },
  },
});
</script>

<style>
body {
  background: #e5e5e5;
}
</style>
<style scoped>
.app__head {
  background-color: #fff;
  border-bottom: 2px solid #3d3d3d;
}

.app__head-notification {
  margin-right: 41px;
}

.app__head-user-name {
  margin-right: 14px;
}

.app__head-profile {
  height: 64px;
  width: 64px;
  border: 1px solid #cccccc;
}

.el-menu__custom--horizontal {
  border: none;
  height: 100%;
}

.el-menu__custom--horizontal > li {
  height: 100%;
}

#main-menu li a {
  color: #3d3d3d;
  text-decoration: none;
  cursor: pointer;
  margin: 0 20px;
  height: 100%;
  display: flex;
  align-items: center;
}

#main-menu li {
  height: 100%;
  display: flex;
  align-items: center;
}

#main-menu :not(.menu-active) a:hover {
  border-bottom: 2px solid #a5c242;
}

#main-menu li:hover a {
  font-style: normal;
  font-weight: bold;
  color: #a5c242;
}

.menu-active {
  font-weight: bold;
  border-bottom: 2px solid #a5c242;
}

.menu-active > a {
  color: #a5c242 !important;
}

.mt-1-5 {
  margin-top: 6px;
}

.custom-drop-user-second {
  margin-top: 10px;
}

.custom-drop-user-first {
  margin-bottom: 10px;
}
</style>
