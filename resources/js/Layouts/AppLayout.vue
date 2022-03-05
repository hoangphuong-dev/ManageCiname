<template>
  <div class="app">
    <div class="app__head">
      <div
        class="flex justify-between items-center m-auto h-24 max-w-screen-2xl"
      >
        <div class="flex grid-content bg-purple">
          <el-image class="h-20" src="images/logo.png"></el-image>
          <h1 class="text-red-600 m-4">PHC</h1>
        </div>
        <div class="app__head-menu h-full">
          <ul id="main-menu" class="flex justify-center items-center h-full">
            <li
              :class="{ 'menu-active': activeMenu(menu) }"
              v-for="menu in menus"
              :key="menu.path"
            >
              <a class="text-xl" :href="route(menu.path)">{{ menu.label }}</a>
            </li>
          </ul>
        </div>
        <div class="grid-content h-full flex items-center justify-end">
          <template v-if="user !== null">
            <!-- <div class="app__head-user-name">{{ user.name }}</div> -->

            <!-- <el-dropdown @command="handleCommand" trigger="click">
              <span class="el-dropdown-link">
                <div class="flex justify-center items-center">
                  <div class="app__head-profile rounded">
                    <img
                      class="w-full h-full rounded"
                      :src="
                        getImage(user.avatar) || '/images/avatar/default.png'
                      "
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
                  <el-dropdown-item
                    command="profile"
                    class="custom-drop-user-first"
                  >
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
                  <el-dropdown-item
                    command="logout"
                    class="custom-drop-user-second"
                  >
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
            </el-dropdown> -->
          </template>
          <template v-else>
            <div class="mr-4 px-6 py-2 rounded border">
              <!-- <el-link
                :href="route('show_login')"
                :underline="false"
                type="primary"
              >
                <h3 class="text-yellowPrimary">Đăng nhập</h3> -->
              <!-- </el-link> -->
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
        <h1 class="text-center">Footer</h1>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import AlertNoticeMixin from "@/Mixins/alert-notice";
import { ArrowDown, ArrowRight } from "@element-plus/icons-vue";

export default defineComponent({
  components: {
    ArrowDown,
    ArrowRight,
  },
  mixins: [AlertNoticeMixin],

  data() {
    return {
      showingNavigationDropdown: false,
      expandMenuMobile: false,
      menus: [
        {
          label: "Phim đang chỉếu",
          path: "movies",
        },
        {
          label: "Phim sắp chiếu",
          path: "movies",
        },
        {
          label: "Vé của tôi",
          path: "your_ticket",
        },
        {
          label: "Thành viên",
          path: "member",
        },
      ],
    };
  },
  methods: {
    handleCommand(command) {
      switch (command) {
        case "logout":
          window.location.href = this.user.role === 1 ? route("#") : route("#");
          break;
        case "profile":
          window.location.href = this.user.role === 1 ? route("#") : route("#");
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
  height: 64px;
  width: 64px;
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
  font-weight: bold;
  color: #ff7777;
}

.menu-active {
  font-weight: bold;
}

.menu-active > a {
  color: #ff7777 !important;
}
</style>
