<template>
  <app-layout>
    <div class="pb-12 pt-6">
      <div class="mx-auto">
        <h2 class="pb-4">Chon ghe xem</h2>
        <div class="w-full shadow-lg p-4">
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
              class="rounded border p-2 text-center cursor-pointer"
              v-for="(item, index) in showtime.room.seats"
              :key="index"
              @click="chooseSeat(item.id)"
              :class="{ active: active_seat[index] === item.id }"
            >
              <div class="w-1/2 m-auto">
                <img
                  style="height: 60px"
                  :src="getImage(item.seat_type.image)"
                />
              </div>
              <div class="text-base mt-2">
                <!-- {{ item.row_name + item.columns_number }} -->
                {{ index }}
              </div>
            </div>
          </div>
        </div>

        <!-- submit form -->
        <div class="text-center mt-10">
          <el-button size="small" @click="submit()" type="danger">
            Tiep tuc
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
      active_seat: [],
      formData: {
        showtime_id: this.showtime.id,
        seat_id: [],
      },
    };
  },
  methods: {
    submit() {
      Inertia.get(route("confirm_order", { ...this.formData }), {
        onBefore,
        onFinish,
      });
    },

    chooseSeat(id) {
      if (this.active_seat.includes(id)) {
        console.log("Delete");
        const index = this.active_seat.indexOf(id);
        if (index > -1) {
          this.active_seat.splice(index, 1);
        }
      } else {
        console.log("Add");
        this.active_seat.push(id);
      }

      // this.active_seat = id;
      this.formData.seat_id = this.active_seat;
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