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
          <!-- end danh sách liên quan  -->
        </div>

        <!-- comment  -->
        <div class="w-full shadow-xl my-6 p-4 border-t-2">
          <form-comment :movie="movie" :user="user"></form-comment>
        </div>

        <!-- end comment  -->
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import MovieDetail from "@/Components/MovieDetail.vue";
import FormComment from "@/Components/FormComment.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  components: { AppLayout, MovieDetail, FormComment },
  props: {
    movie: Object,
    movie_relates: Object,
  },

  computed: {
    user() {
      return this.$page.props.user;
    },
  },

  data: function () {
    return {
      loading: false,
    };
  },
  methods: {
    isValidHttpUrl(string) {
      let url;
      try {
        url = new URL(string);
      } catch (_) {
        return false;
      }
      return url.protocol === "http:" || url.protocol === "https:";
    },

    getImage(file) {
      console.log(file);
      if (!file) return;
      if (this.isValidHttpUrl(file)) return file;
      return `/uploads/${file}`;
    },

    detail(id) {
      Inertia.get(route("movie.detail", id), { onBefore, onFinish });
    },
    videoId(row) {
      return getYoutubeId(row);
    },
  },
};
</script>
