<template>
  <div class="MenuAdmin h-screen flex overflow-hidden">
    <el-aside class="AsideMenu bg-white flex-shrink-0">
      <div class="h-16 justify-items-center">
        <a class="m-auto">
          <!-- <img class="h-16" src="/images/logo.png" /> -->
          <el-icon><watch /></el-icon>
        </a>
      </div>

      <div class="menu-vertical">
        <div
          v-for="menu in menus"
          :key="menu.path"
          class="MenuItem min-h-64 py-3 flex text-base hover:cursor-pointer"
          :class="{ IsActive: activeMenu(menu) }"
          @click="onMenuClick(menu)"
        >
          <div class="flex items-center">
            <el-icon class="mx-4"><right /></el-icon>
            <div class="text-base">{{ menu.label }}</div>
          </div>
        </div>
      </div>
    </el-aside>
    <el-container>
      <el-header class="h-16 border border-gray-200 flex items-center bg-white">
        <div class="ml-auto flex items-center mr-5">
          <h3>{{ user?.name || "" }}</h3>
          <el-dropdown trigger="click" @command="handleCommand">
            <span class="el-dropdown-link flex items-center justify-center">
              <el-image
                class="rounded-full w-10 h-10 ml-2"
                :src="user?.avatar || ''"
              ></el-image
              ><el-icon class="el-icon--right"><arrow-down /></el-icon>
            </span>
            <template #dropdown>
              <el-dropdown-menu>
                <el-dropdown-item command="profile" class="custom-drop-user-first">
                  <div class="w-36 flex justify-between">
                    <div class="flex items-center justify-center">
                      <span class="whitespace-nowrap mt-1-5">Hồ sơ</span>
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

export default {
  name: "AdminLayout",
  components: { Menu, ArrowDown, ArrowRight, Right, Watch },
  mixins: [AlertNoticeMixin],
  computed: {
    user() {
      return this.$page.props.user;
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
          path: "home_super",
        },
        {
          label: "Quản lý phim",
          path: "movie.index",
        },
        {
          label: "Hệ thống rạp",
          path: "admin_info.index",
        },
        {
          label: "Quản lý loại phim",
          path: "movie_genre.index",
        },
        {
          label: "Quản lý loại ghế",
          path: "seat_type.index",
        },
      ],
      menuAdmin: [
        {
          label: "Trang chủ",
          path: "home_admin",
        },
        {
          label: "Quản lý rạp",
          path: "cinema.index",
        },
        {
          label: "Quản lý phòng",
          path: "room.index",
        },
        {
          label: "Quản lý suất chiếu",
          path: "showtime.index",
        },
        {
          label: "Quản lý hóa đơn",
          path: "bill.index",
        },
        {
          label: "Quản lý nhân viên",
          path: "staff.index",
        },
      ],
      menuStaff: [],
    };
  },
  methods: {
    onMenuClick(menu) {
      this.$inertia.visit(route(menu.path));
    },
    activeMenu(menu) {
      return (
        route().current(menu.path) || (menu?.other || []).includes(route().current())
      );
    },
    handleCommand(command) {
      switch (command) {
        case "logout":
          let key = "";
          if (this.user.role === 0) {
            key = route("logout_super");
          } else if (this.user.role == 1) {
            key = route("logout_admin");
          } else {
            key = route("logout_staff");
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
  background: lightpink;
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
  background: #a5c242;
  color: white;
  font-size: 1.25rem;
  line-height: 1.25rem;
  font-weight: 700;
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
