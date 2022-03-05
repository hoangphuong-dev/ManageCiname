<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full mb-10 flex text-red-400">
          <h2 class="">PHC {{ cinema.name }}</h2>
          <p class="ml-32">
            <el-icon><phone /></el-icon> {{ cinema.hotline }}
          </p>
          <p class="mx-32">
            <el-icon><location-information /></el-icon>
            {{ cinema.address }}
          </p>
          <p class="mr-32">
            <el-icon><video-camera-filled /></el-icon> 115 phim công chiếu
          </p>
          <p>
            <el-icon><school /></el-icon> 115 phòng
          </p>
        </div>

        <hr />
        <h2 class="text-center my-4">Lịch chiếu {{ day }}</h2>
        <div class="w-full rounded border-dashed border-2 mt-4 mb-6">
          <h3 class="text-center my-4">Thông tin phim chiếu</h3>
          <div class="flex p-4">
            <div class="w-3/4">
              <h3 class="my-3">Tên phim : {{ movie.name }}</h3>
              <p class="my-3">Thời lượng : {{ movie.movie_length }} phút</p>
              <p class="my-3">Đạo diễn : {{ movie.director }}</p>
              <p class="my-3">Giới hạn độ tuổi : {{ movie.rated }}</p>
            </div>
            <div class="w-1/4">
              <img
                :src="
                  'https://i3.ytimg.com/vi/' +
                  videoId(movie) +
                  '/maxresdefault.jpg'
                "
              />
            </div>
          </div>
        </div>

        <h3 class="text-center my-4">Danh sách suất chiếu</h3>
        <div class="grid grid-cols-6 gap-8">
          <div
            class="border rounded-md p-4 cursor-pointer"
            @click="detailShowTimeById(item)"
            v-for="item in showtimes"
            :key="item.id"
          >
            <h2 class="text-center">{{ item.time }}</h2>
            <p class="text-center">{{ item.name }}</p>
            <p class="text-center">100 ghế trống</p>
          </div>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { getYoutubeId } from "@/Helpers/youtube.js";
import {
  Phone,
  LocationInformation,
  VideoCameraFilled,
  School,
} from "@element-plus/icons-vue";
export default {
  name: "CinemaDetail",
  components: {
    AdminLayout,
    Phone,
    LocationInformation,
    VideoCameraFilled,
    School,
  },
  props: {
    day: String,
    movie: Object,
    cinema: {
      type: Object,
      required: true,
    },
    showtimes: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    detailShowTimeById(item) {
      Inertia.get(
        route("admin.view-showtime-by-id", {
          cinema_id: this.cinema.id,
          showtime_id: item.id,
        })
      );
    },
    videoId(row) {
      return getYoutubeId(row);
    },
  },
};
</script>