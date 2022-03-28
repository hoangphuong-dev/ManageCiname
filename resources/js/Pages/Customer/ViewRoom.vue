<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <h2 class="pb-4">Chọn ghế xem</h2>

        <div class="flex">
          <div class="w-3/4 shadow-lg p-4 mr-6">
            <div class="w-full">
              <img style="width: 100%" src="/uploads/man_hinh_chieu.png" />
            </div>
            <!-- show seat of room -->
            <div
              class="w-full mt-16 grid gap-4"
              :style="{
                'grid-template-columns':
                  'repeat(' + showtime.room.column_number + ', minmax(0, 1fr))',
              }"
            >
              <div
                class="rounded border p-1 text-center cursor-pointer"
                v-for="(item, index) in showtime.room.seats"
                :key="index"
                :class="{ active: formData.seat_id[index] === item.id }"
                @click="chooseSeat(index)"
              >
                <div class="w-full m-auto text-center">
                  <img
                    style="height: 50px; display: inline-block"
                    :src="getImage(item.seat_type.image)"
                  />
                </div>
                <div class="text-base mt-2">
                  <!-- {{ item.row_name + item.columns_number }} -->
                  FFF
                </div>
              </div>
            </div>
          </div>
          <div class="w-1/4">
            <div class="w-full shadow-lg p-4">
              <h2 class="pb-4">Chú thích</h2>

              <div
                class="rounded border-b-2 mb-4 flex"
                v-for="item in 6"
                :key="item"
              >
                <div class="rounded border p-2 text-center w-16 mb-4">
                  <div class="w-1/2 m-auto">
                    <img style="height: 40px" />
                  </div>
                  <div class="text-base mt-2">A1</div>
                </div>
                <div>Ghế Thường</div>
              </div>
            </div>
            <div class="w-full shadow-lg p-4 mt-8">
              <h2 class="pb-4">Thông tin ghế vừa chọn</h2>
            </div>
          </div>
        </div>

        <!-- submit form -->
        <div class="text-center mt-10">
          <el-button size="small" @click="submit()" type="danger">
            Tiếp tục
          </el-button>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  components: { AppLayout },
  props: {
    showtime: Object,
  },

  data() {
    return {
      formData: {
        cinema_id: this.showtime.room.cinema.id,
        showtime_id: this.showtime.id,
        seat_id: [],
      },
    };
  },
  methods: {
    submit() {
      Inertia.get(route("get_info_customer", { ...this.formData }), {
        onBefore,
        onFinish,
      });
    },

    chooseSeat(id) {
      if (this.formData.seat_id.includes(id)) {
        console.log("Delete");
        const index = this.formData.seat_id.indexOf(id);
        if (index > -1) {
          this.formData.seat_id.splice(index, 1);
        }
      } else {
        console.log("Add");
        this.formData.seat_id.push(id);
      }
      console.log(`activeTag[i]: ${this.formData.seat_id}`);
    },

    videoId(row) {
      return getYoutubeId(row);
    },

    getImage(file) {
      if (!file) return;
      return `/uploads/${file}`;
    },
  },
};
</script>


<style lang="css">
.active {
  background: #0909ff;
}
</style>