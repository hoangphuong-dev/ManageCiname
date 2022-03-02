<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full relative my-10">
          <h2>PHC {{ cinema.name }}</h2>
          <p>Hotline : {{ cinema.hotline }}</p>
          <p>Dia chi : {{ cinema.address }}</p>
          <p>So phong : 12 phong</p>
          <p>Phim : 115 phim dang cong chieu</p>
        </div>
        <el-tabs>
          <!-- Tab Phòng chiếu  -->
          <el-tab-pane label="Phòng chiếu">
            <room :seat_types="seat_types" :cinema="cinema"></room>
          </el-tab-pane>
          <!-- Tab Suất chiếu -->
          <el-tab-pane label="Suất chiếu">
            <show-time :rooms="rooms" :cinema="cinema"></show-time>
          </el-tab-pane>
        </el-tabs>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import Room from "./Room.vue";
import ShowTime from "./ShowTime.vue";
export default {
  name: "CinemaDetail",
  components: {
    AdminLayout,
    Room,
    ShowTime,
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
