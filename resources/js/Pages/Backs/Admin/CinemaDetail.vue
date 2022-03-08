<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full mb-10 flex text-red-400">
          <h2 class="">PHC {{ cinema.name }}</h2>
          <p class="ml-16">
            <el-icon><phone /></el-icon> {{ cinema.hotline }}
          </p>
          <p class="mx-16">
            <el-icon><location-information /></el-icon>
            {{ cinema.address }}
          </p>
          <p class="mr-16">
            <el-icon><video-camera-filled /></el-icon> 115 phim công chiếu
          </p>
          <p>
            <el-icon><school /></el-icon> 115 phòng
          </p>
        </div>

        <el-tabs>
          <!-- Tab Suất chiếu -->
          <el-tab-pane label="Suất chiếu">
            <show-time :rooms="rooms" :cinema="cinema"></show-time>
          </el-tab-pane>
          <!-- Tab Phòng chiếu  -->
          <el-tab-pane label="Phòng chiếu">
            <room :seat_types="seat_types" :cinema="cinema"></room>
          </el-tab-pane>
        </el-tabs>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import {
  Phone,
  LocationInformation,
  VideoCameraFilled,
  School,
} from "@element-plus/icons-vue";
import Room from "./Room.vue";
import ShowTime from "./ShowTime.vue";
export default {
  name: "CinemaDetail",
  components: {
    AdminLayout,
    Room,
    ShowTime,
    Phone,
    LocationInformation,
    VideoCameraFilled,
    School,
  },
  props: {
    cinema: {
      type: Object,
      required: true,
    },
    seat_types: {
      type: Object,
      required: true,
    },
    rooms: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
    };
  },
};
</script>
<style>
.customer_dialog .el-overlay .el-overlay-dialog .el-dialog {
  width: 90%;
}
</style>
