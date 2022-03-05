<template>
  <div class="p-4">
    <div class="w-full flex relative my-4">
      <div class="w-3/4 flex items-end">
        <div class="search">
          <el-input
            ref="search"
            placeholder="Tìm tên phim ... "
            clearable
            v-model="showtime.keyword"
            @keyup.enter="searchChange()"
          />
        </div>
      </div>
      <div class="w-1/4 text-right">
        <el-button @click="openDialogShowTime">Thêm Suất Chiếu</el-button>
      </div>
    </div>

    <div v-if="showtime.data.length > 0" class="grid grid-cols-4 gap-4">
      <div
        class="border rounded-md p-4"
        v-for="item in showtime.data"
        :key="item.id"
      >
        <h2
          @click="detailShowTime(item)"
          class="text-center mb-2 cursor-pointer"
        >
          {{ item.name }}
        </h2>
        <img
          :src="
            'https://i3.ytimg.com/vi/' + videoId(item) + '/maxresdefault.jpg'
          "
        />

        <div class="w-full flex my-4">
          <div class="w-2/3">{{ item.day }}</div>
          <div class="w-1/3 flex text-right">
            <h3 class="text-red-400 mr-2">{{ item.sum_show_time }}</h3>
            suất chiếu
          </div>
        </div>
      </div>
    </div>
    <div v-else><el-empty description="Không có dữ liệu"></el-empty></div>
    <!-- phan trang suất chiếu  -->
    <div
      v-if="showtime.total > showtime.perPage"
      class="w-full justify-center my-16 flex"
    >
      <pagination
        v-model="showtime.current_page"
        @current-change="handleCurrentPage"
        :page-size="Number(showtime.perPage)"
        :total="Number(showtime.total)"
      />
    </div>

    <!-- dialog suất chiếu  -->
    <el-dialog
      :title="
        selectedItemShowTime === null
          ? 'Thêm suất chiếu'
          : 'Sửa thông tin suất chiếu'
      "
      v-model="dialogFormShowTime"
    >
      <el-form
        class="w-11/12 m-auto"
        ref="formData"
        :model="formData"
        label-position="top"
        :rules="rules"
      >
        <!-- Chọn phim -->
        <el-form-item label="Chọn phim" prop="movie">
          <el-select class="w-full" v-model="formData.movie" clearable>
            <el-option
              v-for="item in listMovie"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            ></el-option>
          </el-select>
        </el-form-item>

        <!-- Chọn ngày  -->
        <el-form-item label="Chọn ngày" prop="date">
          <el-date-picker
            v-model="formData.date"
            placeholder="Chọn một ngày"
            type="date"
            format="YYYY/MM/DD"
            value-format="YYYY-MM-DD"
          >
          </el-date-picker>
        </el-form-item>

        <!-- Số lượng  -->
        <el-form-item label="Số lượng suất chiếu" prop="count">
          <el-input-number
            class="text-left"
            v-model="formData.count"
            :min="1"
            :max="20"
          />
        </el-form-item>

        <!-- submit -->
        <div class="text-right">
          <el-button @click="dialogFormShowTime = false">Hủy</el-button>
          <el-button type="primary" @click="viewSchedule">
            <span v-if="selectedItemShowTime === null">Xem lịch chiếu</span>
          </el-button>
        </div>

        <!-- Lịch chiếu -->
        <div v-if="showTitle" class="my-5 p-2 text-center justify-items-center">
          <h2 class="my-2">Lịch chiếu</h2>
          <div
            class="flex w-full"
            v-for="(row, indexSchedule) in formData.schedule"
            :key="indexSchedule"
          >
            <!-- Chọn phòng  -->
            <el-form-item label="Chọn phòng">
              <el-select v-model="row.room" clearable>
                <el-option
                  v-for="item in rooms"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item>

            <!-- chọn thời gian bắt đầu -->
            <el-form-item class="ml-4" label="Giờ chiếu">
              <el-time-select
                class="mr-4"
                v-model="row.time_start"
                :max-time="endTime"
                placeholder="Giờ chiếu"
                start="09:00"
                step="00:30"
                end="23:59"
              >
              </el-time-select>
            </el-form-item>

            <!-- Thời gian kết thúc -->
            <!-- <el-form-item label="Giờ kết thúc">
              <el-time-select
                v-model="endTime"
                :min-time="startTime"
                placeholder="Kết thúc"
                start="08:30"
                step="00:15"
                end="18:30"
              >
              </el-time-select>
            </el-form-item> -->
          </div>
          <div class="text-center">
            <el-button @click="onSubmitShowTime">Thêm lịch chiếu</el-button>
          </div>
        </div>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { listScheduleByDay } from "@/API/main.js";
import { Edit } from "@element-plus/icons-vue";
export default {
  name: "ShowTime",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
    Edit,
  },
  props: {
    cinema: {
      type: Object,
      required: true,
    },
    rooms: {
      type: Array,
      required: true,
    },
  },
  computed: {
    listMovie() {
      return this.cinema.movies;
    },
  },
  created() {
    this.fetchData();
  },
  data() {
    return {
      showTitle: false,
      selectedItemShowTime: null,
      dialogFormShowTime: false,

      showtime: {
        data: [],
        total: "",
        current_page: "",
        keyword: "",
        perPage: "",
        filter: {
          page: 1,
          limit: 10,
          cinema_id: this.cinema.id,
        },
      },

      formData: {
        count: "",
        movie: "",
        date: "",
        schedule: [],
      },

      rules: {
        movie: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "change",
          },
        ],
        date: [
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
    detailShowTime(item) {
      Inertia.get(
        route("admin.view_detail_showtimes", {
          cinema_id: item.cinema_id,
          movie_id: item.movie_id,
          day: item.day,
        }),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
    },

    viewSchedule() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          this.showTitle = true;
          for (let i = 0; i < this.formData.count; i++) {
            this.formData.schedule.push({
              room: "",
            });
          }
        }
      });
    },

    videoId(row) {
      return getYoutubeId(row);
    },

    handleCurrentPage(value) {
      this.showtime.filter.page = value;
      this.fetchData();
    },

    searchChange() {
      this.showtime.filter.name = this.showtime.keyword;
      this.fetchData();
    },

    resetFormData() {
      this.formData.count = "";
      this.formData.movie = "";
      this.formData.date = "";
      this.formData.schedule = [];
      this.showTitle = false;
    },

    openDialogShowTime() {
      this.selectedItemShowTime = null;
      this.dialogFormShowTime = !this.dialogFormShowTime;
    },

    createShowTime() {
      Inertia.post(
        route("admin.showtimes.store"),
        {
          ...this.formData,
          cinema_id: this.cinema.id,
        },
        {
          onBefore,
          onFinish,
          preserveScroll: true,
          onError: (e) => console.log(e),
          onSuccess: (_) => {
            this.resetFormData();
            this.dialogFormShowTime = !this.dialogFormShowTime;
            this.fetchData();
          },
        }
      );
    },

    async onSubmitShowTime() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          if (this.selectedItemShowTime === null) {
            this.createShowTime();
          } else {
            this.editCinema();
          }
        }
      });
    },

    async fetchData() {
      this.loading = true;
      listScheduleByDay(this.showtime.filter)
        .then(({ status, data }) => {
          this.showtime.data = status === 200 ? data.data : this.showtime.data;
          this.showtime.total = data.meta.total;
          this.showtime.perPage = data.meta.per_page;
          this.showtime.current_page = data.meta.current_page;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>
