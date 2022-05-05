<template>
  <div>
    <el-popover placement="bottom-end" :width="400" trigger="click">
      <template #reference>
        <div @click="showNotification()" class="icon-notice flex relative">
          <el-image
            class="cursor-pointer w-8 lg:w-10 logo-global hover-animation"
            src="/images/noti.svg"
          ></el-image>
          <span
            v-if="countNotificationUser > 0"
            class="absolute notification-count cursor-pointer"
          >
            {{ countNotificationUser }}
          </span>
        </div>
      </template>

      <!-- danh sach thong bao -->
      <div class="height-500">
        <div class="header flex justify-between items-center h-7">
          <div class="p-4">Danh sách thông báo</div>
          <div></div>
        </div>
        <hr />
        <div
          class="notification overflow-y-auto custom-scroll"
          style="height: 400px"
          id="bx-nt"
        >
          <ul v-if="notifications.length > 0">
            <li
              class="flex cursor-pointer border-cs notice justify-between px-1"
              v-for="(item, index) in notifications"
              :key="index"
              @click="viewNotification(item.id)"
            >
              <div class="flex flex-1 overflow-hidden">
                <div class="w-2 h-1"></div>
                <div class="content flex-1" style="width: calc(100% - 52px)">
                  <h2 class="text-center py-4">
                    {{ item.content }}
                  </h2>
                </div>
              </div>
              <div class="flex items-center justify-center w-4"></div>
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
// import {
//   getNotificationUserExpire,
//   viewDatailNotification,
// } from "@/Api/Notification";
export default {
  props: {
    countNotificationUser: {
      type: Number,
      required: false,
    },
  },
  data() {
    return {
      notifications: [],
    };
  },
  methods: {
    async viewNotification(id) {
      await viewDatailNotification(id)
        .then(async (res) => {
          this.$inertia.get(route("admin.page_update_plan"));
        })
        .catch(() => {});
    },

    async showNotification() {
      await getNotificationUserExpire()
        .then(async (res) => {
          this.notifications = res.data;
        })
        .catch(() => {});
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
