<template>
  <div class="p-4">
    <div class="w-full flex relative my-4">
      <div class="w-3/4 flex items-end">
        <div class="search">
          <el-input
            ref="search"
            placeholder="Tìm tên phim ... "
            clearable
            v-model="rooms.keyword"
            @keyup.enter="searchChange()"
          />
        </div>
      </div>
      <div class="w-1/4 text-right">
        <el-button @click="openDialogShowTime">Thêm Suất Chiếu</el-button>
      </div>
    </div>
    <!-- <div v-if="rooms.data.length > 0" class="grid grid-cols-5 gap-4">
      <div
        class="border rounded-md p-4"
        v-for="item in rooms.data"
        :key="item.id"
      >
        <h2 class="text-center">{{ item.name }}</h2>
        <p class="text-center">
          {{ item.row_number * item.column_number }} ghế
        </p>
        <p class="text-center">
          <span class="mr-4">Trạng thái : </span>
          <el-switch
            v-model="item.status"
            active-color="#13ce66"
            inactive-color="#cccccc"
            active-value="1"
            inactive-value="0"
            @click="handleUpdateStatus(item, item.status)"
          />
        </p>

        <div class="mt-4 flex">
          <div class="text-left w-1/2"></div>
          <div class="text-right w-1/2 h-5">
            <el-icon
              v-if="item.status == 0"
              class="cursor-pointer"
              @click="confirmEventDelete(item)"
              ><delete
            /></el-icon>
          </div>
        </div>
      </div>
    </div> -->
    <!-- <div v-else><el-empty description="Không có dữ liệu"></el-empty></div> -->
    <!-- phan trang suất chiếu  -->
    <!-- <div
      v-if="rooms.total > rooms.perPage"
      class="w-full justify-center my-16 flex"
    >
      <pagination
        v-model="rooms.current_page"
        @current-change="handleCurrentPage"
        :page-size="Number(rooms.perPage)"
        :total="Number(rooms.total)"
      />
    </div> -->
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
            type="date"
            placeholder="Chọn một ngày"
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
            <span v-if="selectedItemShowTime === null">Xem toàn bộ</span>
          </el-button>
        </div>

        <!-- Lịch chiếu -->
        <div v-if="showTitle" class="my-5 p-2 text-center justify-items-center">
          <h2 class="my-2">Lịch chiếu</h2>
          <div class="flex w-full">
            <!-- Chọn phòng  -->
            <el-form-item label="Chọn phòng" prop="room">
              <el-select v-model="formData.room" clearable>
                <el-option
                  v-for="item in rooms"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item>

            <!-- chọn thời gian bắt đầu  -->
            <el-form-item class="ml-4" label="Giờ chiếu" prop="time_start">
              <el-time-select
                class="mr-4"
                v-model="formData.time_start"
                :max-time="endTime"
                placeholder="Giờ chiếu"
                start="09:00"
                step="00:30"
                end="23:59"
              >
              </el-time-select>
            </el-form-item>

            <!-- Thời gian kết thúc -->
            <el-form-item label="Giờ kết thúc">
              <el-time-select
                v-model="endTime"
                :min-time="startTime"
                placeholder="Kết thúc"
                start="08:30"
                step="00:15"
                end="18:30"
              >
              </el-time-select>
            </el-form-item>
          </div>
          <div class="text-center">
            <el-button @click="onSubmitRoom">Thêm</el-button>
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
import { listRoom, updateStatusRoom } from "@/API/main.js";
import { Edit, Delete } from "@element-plus/icons-vue";
export default {
  name: "ShowTime",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
    Edit,
    Delete,
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
    // this.fetchDataRoom();
  },
  data() {
    return {
      showTitle: false,
      selectedItemShowTime: null,
      dialogFormShowTime: false,
      Count: "",
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
        room: [],
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
    viewSchedule() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          this.showTitle = true;
          this.Count = this.formData.count;
        }
      });
    },
    handleCurrentPage(value) {
      this.rooms.filter.page = value;
      this.fetchDataRoom();
    },
    resetFormRoom() {
      this.formDataRoom.name = "";
      this.formDataRoom.row_number = "";
      this.formDataRoom.column_number = "";
      this.formDataRoom.seats = [];
    },

    openDialogShowTime() {
      this.selectedItemShowTime = null;
      this.dialogFormShowTime = !this.dialogFormShowTime;
    },
    createRoom() {
      Inertia.post(
        route("admin.rooms.store"),
        {
          ...this.formDataRoom,
          cinema_id: this.cinema.id,
        },
        {
          onBefore,
          onFinish,
          preserveScroll: true,
          onError: (e) => console.log(e),
          onSuccess: (_) => {
            this.resetFormRoom();
            this.fetchDataRoom();
            this.dialogFormShowTime = !this.dialogFormShowTime;
          },
        }
      );
    },
    searchChange() {
      this.rooms.filter.name = this.rooms.keyword;
      this.fetchDataRoom();
    },
    async onSubmitRoom() {
      this.$refs["formDataRoom"].validate((valid) => {
        if (valid) {
          if (this.selectedItemShowTime === null) {
            this.createRoom();
          } else {
            this.editCinema();
          }
        }
      });
    },
    confirmEventDelete({ id }) {
      this.$confirm(
        `Bạn có chắc xóa hết tất cả dữ liệu của suất này ?`,
        "Cảnh báo",
        {
          confirmButtonText: "Chắc chắn",
          cancelButtonText: "Hủy",
          type: "warning",
        }
      ).then(async () => {
        Inertia.delete(route("admin.rooms.delete", { id }), {
          onError: (e) => console.log(e),
        });
        this.fetchDataRoom();
      });
    },
    async handleUpdateStatus(item, status) {
      this.$confirm(`Bạn có chắc chắn thay đổi trạng thái suất `, "Cảnh báo", {
        confirmButtonText: "Chắc chắn",
        cancelButtonText: "Hủy",
        type: "warning",
      })
        .then(async () => {
          this.loading = true;
          await updateStatusRoom(item.id, status)
            .then(async (res) => {
              this.fetchDataRoom();
              this.$message.success("Cập nhật trạng thái thành công !");
            })
            .catch(() => {
              this.fetchDataRoom();
              this.$message.error("Có lỗi trong quá trình thực thi");
            });
          this.loading = false;
        })
        .catch(() => {
          this.fetchDataRoom();
        });
    },
    async fetchDataRoom() {
      this.loading = true;
      listRoom(this.rooms.filter)
        .then(({ status, data }) => {
          this.rooms.data = status === 200 ? data.data : this.rooms.data;
          this.rooms.total = data.meta.total;
          this.rooms.perPage = data.meta.per_page;
          this.rooms.current_page = data.meta.current_page;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>
