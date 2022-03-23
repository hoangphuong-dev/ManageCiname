<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <h2 class="pb-4">Chọn suất chiếu</h2>
        <div class="w-full flex">
          <div
            @click="activate(item)"
            style="grid-template-columns: repeat(14, minmax(0, 1fr))"
            class="
              border-2
              rounded
              cursor-pointer
              grid
              p-2
              mr-4
              hover:border-red-200
            "
            :class="{ active: active_day == item }"
            v-for="item in arr_day"
            :key="item"
          >
            {{ item.getDate() }}
          </div>

          <div></div>
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
      today: new Date(),
      end_day: new Date(),
      arr_day: [],
      active_day: 0,
      loading: false,
    };
  },

  created() {
    this.getFourteenDay();
  },

  methods: {
    getFourteenDay() {
      const date = new Date();
      let time = new Date();
      for (let i = 1; i <= 3; i++) {
        time += date.setDate(date.getDate() + i);

        this.arr_day.push(time);
      }
    },

    activate: function (el) {
      //   console.log(this.end_day);

      //   this.end_day.setDate(this.today.getDate() + 1);

      //   console.log(
      //     this.end_day.getFullYear() +
      //       "-" +
      //       (this.end_day.getMonth() + 1) +
      //       "-" +
      //       this.end_day.getDate()
      //   );
      //   console.log(this.end_day.getDate());
      //   console.log(this.end_day.getFullYear());

      //   for (let i = 1; i <= 14; i++) {
      //     this.arr_day.push(this.end_day.setDate(this.today.getDate() + i));
      //   }

      //   console.log("FFFFF", this.arr_day);
      this.active_day = el;
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


<style lang="css">
.active {
  background: #ff7777;
}
</style>