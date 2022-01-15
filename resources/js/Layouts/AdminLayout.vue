<template>
  <div class="MenuAdmin h-screen flex overflow-hidden">
    <el-aside class="AsideMenu bg-white flex-shrink-0">
      <div class="hidden lg:block">
        <a :href="route('back.cinemas')" class="h-20">
          <img class="pl-4 py-3" src="/images/logo.svg" />
        </a>
      </div>
      <div class="menu-vertical">
        <div
          v-for="menu in menus"
          :key="menu.path"
          class="MenuItem min-h-64 py-3 flex text-base hover:cursor-pointer"
          :class="[menu.path == activeMenuItem ? 'IsActive' : '']"
          @click="onMenuClick(menu)"
        >
          <div class="flex items-center">
            <img class="IconMenuItem mx-4" :src="menu.icon" alt="" />
            <div class="text-base">{{ menu.label }}</div>
          </div>
        </div>
      </div>
    </el-aside>
    <el-container class="w-full">
      <el-header class="h-16 border border-gray-200 flex items-center bg-white">
        <div class="ml-auto flex items-center mr-5">
          <h3>{{ user?.name || "No name" }}</h3>
          <!-- <el-dropdown trigger="click" @command="handleCommand">
            <span class="el-dropdown-link flex items-center justify-center">
              <el-image
                class="rounded-full w-10 h-10 ml-2"
                :src="user?.avatar || ''"
              ></el-image
              ><el-icon class="el-icon--right"><arrow-down /></el-icon>
            </span> -->

            <!-- <template #dropdown>
              <el-dropdown-menu>
                <el-dropdown-item command="profile" class="custom-drop-user-first">
                  <div class="w-36 flex justify-between">
                    <div class="flex items-center justify-center">
                      <img width="12" src="/images/svg/user.svg" alt="" />
                      &nbsp;&nbsp;
                      <span class="whitespace-nowrap mt-1-5">Thong tin</span>
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
                      <span class="whitespace-nowrap mt-1">Dang cuat</span>
                    </div>
                    <div class="flex items-center">
                      <el-icon><arrow-right /></el-icon>
                    </div>
                  </div>
                </el-dropdown-item>
              </el-dropdown-menu>
            </template> -->
          <!-- </el-dropdown> -->
        </div>
      </el-header>

      <el-main class="relative bg-slate-500">
        <slot name="main"></slot>
      </el-main>
    </el-container>
  </div>
</template>

<script>
import {Menu} from "@element-plus/icons-vue";
// import AlertNoticeMixin from "@/Mixins/alert-notice";
import { ArrowDown, ArrowRight } from "@element-plus/icons-vue";

export default {
  name: "AdminLayout",
  components: { Menu, ArrowDown, ArrowRight },
  // mixins: [AlertNoticeMixin],
  // computed: {
  //     user() {
  //         return this.$page.props.userAdmin;
  //     },
  // },
  data() {
    return {
      menus: [
        {
          label: "rap",
          icon: "/images/svg/account.svg",
          path: "back.cinemas",
        },
        {
          label: "phong",
          icon: "/images/svg/profile.svg",
          path: "back.rooms",
        },
        {
          label: "Showtime",
          icon: "/images/svg/money.svg",
          path: "back.showtimes",
        },
        {
          label: "bills",
          icon: "/images/svg/jop_posting.svg",
          path: "back.bills",
        },
        {
          label: "Staff",
          icon: "/images/svg/contact.svg",
          path: "back.staffs",
        },
      ],
      activeMenuItem: "home",
    };
  },
  created() {
      this.getCurrentUrl();
  },
  methods: {
    getCurrentUrl() {
        const pathname = window.location.pathname.split("/");
        const menu = [
            "rooms",
            "showtimes",
            "bills",
            "staffs",
        ];
        const current_url = pathname
            .filter((element) => menu.includes(element))
            .toString();
        this.activeMenuItem = !current_url
            ? "back.home"
            : "back." + current_url;
    },
    onMenuClick(menu) {
        this.$inertia.visit(route(menu.path));
    },
    // handleCommand(command) {
    //     switch (command) {
    //         case "logout":
    //             window.location.href = route("back.logout");
    //             break;
    //         default:
    //             break;
    //     }
    // },
  },
};
</script>

<style>
.MenuAdmin .AsideMenu {
  width: 16.25rem;
  border-right: 1px solid #d8d8d8;
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
  background: #a5c242;
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
