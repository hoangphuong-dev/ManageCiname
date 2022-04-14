<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="flex">
          <div class="w-1/2"><h2>Chi tiết rạp</h2></div>
          <div class="w-1/2 text-right">
            <el-tag type="success">
              {{ cinema.name }}
            </el-tag>
          </div>
        </div>

        <div class="w-full flex mb-10">
          <div class="w-1/2">
            <p class="my-2">
              <el-icon><video-camera-filled /></el-icon>
              <span class="text-red-400 font-bold">{{
                " " + cinema.movies.length
              }}</span>
              phim công chiếu
            </p>
            <p>
              <el-icon><school /></el-icon>
              <span class="text-red-400 font-bold">{{
                " " + rooms.length
              }}</span>
              phòng
            </p>
          </div>

          <div class="w-1/2">
            <p class="my-2">
              <el-icon><phone /></el-icon>
              <span> Hotline : {{ cinema.user.phone }}</span>
            </p>
            <p>
              <el-icon><location-information /></el-icon>
              <span> Địa chỉ : {{ cinema.address }}</span>
            </p>
          </div>
        </div>

        <el-tabs>
          <!-- Tab Suất chiếu -->
          <el-tab-pane label="Suất chiếu">
            <show-time :rooms="rooms" :cinema="cinema"></show-time>
          </el-tab-pane>
          <!-- Tab Phòng chiếu  -->
          <el-tab-pane label="Phòng chiếu">
            <room
              :movie_formats="movie_formats"
              :seat_types="seat_types"
              :cinema_id="cinema.id"
            ></room>
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
    movie_formats: {
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
  width: 95%;
}
</style>
