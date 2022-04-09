<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <h2 class="pb-4">Xem chi tiết phim</h2>
        <div class="w-full flex">
          <!-- component chi tiết phim  -->
          <movie-detail :movie="movie"></movie-detail>

          <!-- Danh sách phim liên quan  -->
          <div class="w-1/4 shadow-xl ml-6">
            <h2 class="text-center mb-6">Phim cùng thể loại đang chiếu</h2>
            <div
              class="p-2 w-11/12 m-auto mb-6 border-b-2 cursor-pointer"
              v-for="item in movie_relates.data"
              :key="item.id"
              @click="detail(item.id)"
            >
              <img
                class="rounded"
                :src="
                  'https://i3.ytimg.com/vi/' +
                  videoId(item) +
                  '/maxresdefault.jpg'
                "
              />
              <h2 class="text-center my-2">{{ item.name }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import MovieDetail from "@/Components/MovieDetail.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  components: { AppLayout, MovieDetail },
  props: {
    movie: Object,
    movie_relates: Object,
  },

  data: function () {
    return {
      loading: false,
    };
  },
  methods: {
    detail(id) {
      Inertia.get(route("movie.detail", id), { onBefore, onFinish });
    },
    videoId(row) {
      return getYoutubeId(row);
    },
  },
};
</script>
