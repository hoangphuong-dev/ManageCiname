<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <h2 class="pb-4">Đặt vé</h2>
        <div class="w-full flex">
          <h3>Chọn rạp</h3>
          <div class="w-1/2 m-auto shadow-lg">
            <!-- <el-select v-model="value" class="m-2" placeholder="Chọn thành phố">
              <el-option
                v-for="item in provinces"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select> -->
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
    provinces: Array,
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
