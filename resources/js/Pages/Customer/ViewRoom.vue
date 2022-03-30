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
                :class="{ seat_order: seat_ordered[index] === item.id }"
                @click="chooseSeat(index)"
              >
                <div class="w-full m-auto text-center">
                  <img
                    style="height: 50px; display: inline-block"
                    :src="getImage(item.seat_type.image)"
                  />
                </div>
                <div class="text-base mt-2">
                  {{ item.row_name + item.columns_number }}
                </div>
              </div>
            </div>
          </div>
          <div class="w-1/4">
            <div class="w-full shadow-lg p-4">
              <h2 class="pb-4">Chú thích</h2>
              <div
                class="rounded border-b-2 mb-4 flex"
                v-for="item in seat_types.data"
                :key="item"
              >
                <div class="rounded border text-center mb-4 w-32">
                  <div class="w-3/4 m-auto p-2">
                    <img style="height: 40px" :src="getImage(item.image)" />
                  </div>
                  <div class="text-base mt-2">A1</div>
                </div>
                <div class="ml-3 mt-8">
                  <h3>{{ item.name }}</h3>
                </div>
              </div>

              <!-- Chú thích màu  -->
              <div
                class="rounded border-b-2 mb-4 flex"
                v-for="item in notes"
                :key="item.name"
              >
                <div
                  class="rounded border text-center mb-4 w-32"
                  :class="item.color"
                >
                  <div class="w-3/4 m-auto p-2">
                    <img
                      style="height: 40px"
                      :src="getImage(seat_types.data[0].image)"
                    />
                  </div>
                  <div class="text-base mt-2">A1</div>
                </div>
                <div class="ml-3 mt-8">
                  <h3>{{ item.name }}</h3>
                </div>
              </div>

              <!-- end chú thích  -->
            </div>

            <!-- Thông tin ghế -->
            <div class="w-full shadow-lg p-4 mt-8">
              <h2 class="pb-4 text-center">Thông tin vừa chọn</h2>
              <h3 class="text-right text-lg">Phòng 202</h3>

              <div class="w-full flex">
                <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                  Ghế
                </div>
                <div
                  class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                >
                  A1, A2, A3
                </div>
              </div>
              <div class="w-full flex">
                <div class="w-1/3 border-dashed border-2 p-2">Tổng tiền</div>
                <div class="w-2/3 border-dashed border-2 p-2 border-l-0">
                  1000.000 VNĐ
                </div>
              </div>
            </div>
            <!-- end thông tin Ghế -->

            <!-- Count down  -->
            <div class="w-full shadow-lg p-4 mt-8">
              <h2 class="pb-4 text-center">Count down</h2>

              <div class="w-full flex">{{ countDown }}</div>
            </div>
            <!-- end count down -->
          </div>
        </div>

        <!-- submit form -->
        <div class="text-center mt-10">
          <el-button @click="submit()" type="danger"> Tiếp tục </el-button>
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
    seat_ordered: Object,
    seat_types: Object,
  },
  created() {
    this.countDownTimer();
  },

  data() {
    return {
      countDown: 1000,
      formData: {
        cinema_id: this.showtime.room.cinema.id,
        showtime_id: this.showtime.id,
        seat_id: [],
      },
      notes: [
        {
          name: "Ghế đã bán",
          color: "bg-red-400",
        },
        {
          name: "Ghế trống",
          color: "",
        },
        {
          name: "Ghế đang chọn",
          color: "bg-blue-400",
        },
      ],
    };
  },

  methods: {
    submit() {
      Inertia.get(route("get_info_customer", { ...this.formData }), {
        onBefore,
        onFinish,
      });
    },
    countDownTimer() {
      console.log("FFFFFFFF");

      if (this.countDown > 0) {
        setTimeout(() => {
          this.countDown -= 1;
          this.countDownTimer();
        }, 1000);
      }
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
.seat_order {
  background: red;
}
</style>