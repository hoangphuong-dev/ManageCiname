<template>
  <div class="w-3/4 p-2 shadow-xl">
    <div class="flex">
      <div class="w-1/2">
        <img
          class="rounded-md"
          :src="
            'https://i3.ytimg.com/vi/' + videoId(movie) + '/maxresdefault.jpg'
          "
        />
      </div>
      <div class="w-1/2 pl-4">
        <h2 class="text-center">{{ movie.name }}</h2>
        <p class="pb-2">Đạo diễn : {{ movie.director }}</p>
        <p class="pb-2">Thể loại phim : Bom tấn, Hài hước</p>
        <p class="pb-2">Diễn viên : Hoàng Phi Hồng , Thanh Vân</p>
        <p class="pb-2">
          Rated : Cấm trẻ em dưới
          <span class="text-red-500">{{ movie.rated }}</span>
          tuổi
        </p>
        <h3 v-if="movie.showtimes.length > 0">
          Ngày khởi chiếu:
          {{ formatDate(movie.showtimes[0].time_start) }}
        </h3>
        <div class="text-center mt-4">
          <div v-if="movie.showtimes.length > 0">
            <el-button @click="openDialog(movie.id)" type="danger">
              Đặt vé
            </el-button>
          </div>
          <div v-else class="text-red-200">
            <el-alert title="Phim đang chưa khởi chiếu !" type="warning" />
          </div>
          <el-dialog title="Chọn rạp" v-model="dialogForm">
            <el-form
              class="text-center w-full"
              ref="formData"
              :model="formData"
              label-position="top"
              :rules="rules"
            >
              <!-- Chọn tỉnh  -->
              <el-form-item label="Chọn thành phố" prop="province_id">
                <el-select
                  class="w-full"
                  v-model="formData.province_id"
                  clearable
                >
                  <el-option
                    v-for="item in provinces"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                    @click="getCineme(item.id)"
                  ></el-option>
                </el-select>
              </el-form-item>

              <!-- Chọn rạp  -->
              <el-form-item label="Chọn rạp" prop="cinema_id">
                <el-select
                  v-model="formData.cinema_id"
                  class="w-full"
                  clearable
                >
                  <el-option
                    v-for="item in cinemas"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  ></el-option>
                </el-select>
              </el-form-item>

              <el-button @click="viewShowTime()">Xem suất chiếu</el-button>
            </el-form>
          </el-dialog>
        </div>
      </div>
    </div>
    <div class="mt-10">
      <el-tabs>
        <!-- Tab chi tiết -->
        <el-tab-pane label="Mô tả chi tiết">
          <div class="p-4" v-html="movie.description"></div>
        </el-tab-pane>
        <!-- Tab Phòng chiếu  -->

        <el-tab-pane label="Trailler">
          <div class="w-full p-8">
            <iframe
              class="rounded"
              width="100%"
              height="500"
              :src="'https://www.youtube.com/embed/' + videoId(movie)"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { listProvince, getCinemaByProvince } from "@/API/main.js";

export default {
  components: { AppLayout },
  props: {
    movie: Object,
  },

  data: function () {
    return {
      loading: false,
      dialogForm: false,
      province: "",
      provinces: [],
      cinemas: [],
      formData: {
        movie_id: "",
        province_id: "",
        cinema_id: "",
      },
      rules: {
        movie_id: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        province_id: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        cinema_id: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    formatDate(day) {
      var now = new Date(day);
      return now.toLocaleDateString();
    },
    videoId(row) {
      return getYoutubeId(row);
    },

    openDialog(id) {
      this.formData.movie_id = id;
      this.dialogForm = !this.dialogForm;
      this.loading = true;
      this.fetchDataProvince();
    },

    async fetchDataProvince() {
      listProvince()
        .then(({ status, data }) => {
          this.provinces = data;
        })
        .catch(() => {});
    },

    getCineme(id) {
      this.fetchDataCinema(id);
    },

    async fetchDataCinema(id) {
      getCinemaByProvince(id)
        .then(({ status, data }) => {
          this.cinemas = data;
        })
        .catch(() => {});
    },

    async viewShowTime() {
      this.$refs["formData"].validate(async (valid) => {
        if (valid) {
          Inertia.get(route("order.ticket", { ...this.formData }), {
            onBefore,
            onFinish,
          });
        }
      });
    },
  },
};
</script>

<style lang="css">
.el-dialog__header {
  background: #f56c6c;
}
</style>


