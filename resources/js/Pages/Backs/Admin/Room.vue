<template>
  <div class="p-4">
    <div class="w-full flex relative my-4">
      <div class="w-3/4 flex items-end">
        <div class="search">
          <el-input
            ref="search"
            placeholder="Tìm tên phòng ... "
            clearable
            v-model="rooms.keyword"
            @keyup.enter="searchChange()"
          />
        </div>
      </div>
      <div class="w-1/4 text-right">
        <el-button @click="onOpenDialogRoom">Thêm Phòng</el-button>
      </div>
    </div>
    <div v-if="rooms.data.length > 0" class="grid grid-cols-3 gap-6">
      <div
        class="border rounded-md p-4"
        v-for="item in rooms.data"
        :key="item.id"
      >
        <h2 class="text-center">{{ item.name }}</h2>
        <div class="w-full flex">
          <div class="w-1/3 border-dashed border-2 p-2 border-b-0">Số ghế</div>
          <div class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0">
            {{ item.row_number * item.column_number }} ghế
          </div>
        </div>
        <div class="w-full flex">
          <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
            Ngày tạo
          </div>
          <div class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0">
            14-04-2022
          </div>
        </div>
        <div class="w-full flex">
          <div class="w-1/3 border-dashed border-2 p-2">Trạng thái</div>
          <div class="w-2/3 border-dashed border-2 p-2 border-l-0">
            <el-switch
              v-model="item.status"
              active-color="#13ce66"
              inactive-color="#cccccc"
              active-value="1"
              inactive-value="0"
              @click="handleUpdateStatus(item, item.status)"
            />
          </div>
        </div>

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
    </div>
    <div v-else><el-empty description="Không có dữ liệu"></el-empty></div>
    <!-- phan trang phòng chiếu  -->
    <div
      v-if="rooms.total > rooms.perPage"
      class="w-full justify-center my-16 flex"
    >
      <pagination
        v-model="rooms.current_page"
        @current-change="handleCurrentPage"
        :page-size="Number(rooms.perPage)"
        :total="Number(rooms.total)"
      />
    </div>
    <!-- dialog phòng chiếu  -->
    <div class="customer_dialog">
      <el-dialog
        :title="
          selectedItemRoom === null ? 'Thêm phòng' : 'Sửa thông tin phòng'
        "
        v-model="dialogFormVisibleRoom"
      >
        <el-form
          class="text-center w-full"
          ref="formDataRoom"
          :model="formDataRoom"
          label-position="top"
          :rules="rulesRoom"
        >
          <!-- Tên rạp -->
          <el-form-item label="Tên phòng" prop="name">
            <el-input
              v-model="formDataRoom.name"
              autocomplete="off"
              placeholder="Nhập tên phòng"
            ></el-input>
          </el-form-item>

          <el-form-item label="Chọn định dạng" prop="format">
            <el-select
              class="w-full"
              v-model="formDataRoom.format"
              value-key="1"
              placeholder="Định dạng"
              clearable
            >
              <el-option
                v-for="item in movie_formats"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </el-form-item>

          <el-form-item class="text-left" label="Số hàng ghế">
            <el-input-number
              v-model="formDataRoom.row_number"
              :min="8"
              :max="20"
            />
          </el-form-item>

          <el-form-item class="text-left" label="Số dãy ghế">
            <el-input-number
              v-model="formDataRoom.column_number"
              :min="8"
              :max="20"
            />
          </el-form-item>

          <!-- submit -->
          <div class="text-right">
            <span class="dialog-footer">
              <el-button @click="dialogFormVisibleRoom = false">Hủy</el-button>
              <el-button type="primary" @click="viewDiagram">
                <span v-if="selectedItemRoom === null">Xem sơ đồ</span>
              </el-button>
            </span>
          </div>

          <!-- sơ đồ ghế -->
          <div class="my-5 p-2 text-center justify-items-center">
            <h2 class="my-2" v-if="showTitle">Sơ đồ ghế</h2>
            <div
              class="grid gap-2"
              :style="{
                'grid-template-columns':
                  'repeat(' + Column + ', minmax(0, 1fr))',
              }"
            >
              <div
                class="text-center"
                v-for="(seat, indexSeat) in formDataRoom.seats"
                :key="indexSeat"
              >
                <div class="flex w-full seat_customer option_seat_customer">
                  <el-form-item class="w-1/2 name_seat">
                    <el-input v-model="seat.row"></el-input>
                  </el-form-item>
                  <el-form-item class="w-1/2">
                    <el-input v-model="seat.column"></el-input>
                  </el-form-item>
                </div>
                <div class="-mt-6 w-full seat_customer">
                  <el-select class="w-full" clear-icon v-model="seat.seat_type">
                    <el-option
                      v-for="(item, index) in seat_types"
                      :key="index"
                      :label="item.name"
                      :value="item.id"
                    ></el-option>
                  </el-select>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <el-button v-if="showDiagram" @click="onSubmitRoom"
              >Thêm phòng</el-button
            >
          </div>
        </el-form>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { listRoom, updateStatusRoom } from "@/API/main.js";
import { ref } from "vue";
import { Edit, Delete } from "@element-plus/icons-vue";
export default {
  name: "Room",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
    Edit,
    Delete,
  },
  props: {
    cinema_id: Number,
    movie_formats: {
      type: Array,
      required: true,
    },
    seat_types: {
      type: Object,
      required: true,
    },
  },
  created() {
    this.fetchDataRoom();
  },
  data() {
    return {
      showTitle: false,
      showDiagram: false,
      selectedItemRoom: null,
      dialogFormVisibleRoom: false,
      Row: "",
      Column: "",
      rooms: {
        data: [],
        total: "",
        current_page: "",
        keyword: "",
        perPage: "",
        filter: {
          page: 1,
          limit: 12,
          cinema_id: this.cinema_id,
        },
      },
      formDataRoom: {
        name: "",
        row_number: ref(8),
        column_number: ref(8),
        format: "",
        seats: [],
      },
      rulesRoom: {
        name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        format: [
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
    viewDiagram() {
      this.$refs["formDataRoom"].validate((valid) => {
        if (valid) {
          this.showTitle = true;
          this.Row = this.formDataRoom.row_number;
          this.Column = this.formDataRoom.column_number;
          this.showDiagram = true;
          this.formDataRoom.seats = [];
          for (let i = 0; i < this.Row; i++) {
            for (let j = 0; j < this.Column; j++) {
              this.formDataRoom.seats.push({
                row: String.fromCharCode(i + 65),
                column: Number(j + 1),
                seat_type: this.seat_types[0].id,
              });
            }
          }
        }
      });
    },

    handleCurrentPage(value) {
      this.rooms.filter.page = value;
      this.fetchDataRoom();
    },

    resetFormRoom() {
      this.formDataRoom.name = "";
      this.formDataRoom.row_number = ref(8);
      this.formDataRoom.column_number = ref(8);
      this.formDataRoom.seats = [];
    },

    onOpenDialogRoom() {
      this.selectedItemRoom = null;
      this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
    },

    createRoom() {
      Inertia.post(
        route("admin.rooms.store"),
        {
          ...this.formDataRoom,
          cinema_id: this.cinema_id,
        },
        {
          onBefore,
          onFinish,
          preserveScroll: true,
          onError: (e) => console.log(e),
          onSuccess: (_) => {
            this.resetFormRoom();
            this.fetchDataRoom();
            this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
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
          if (this.selectedItemRoom === null) {
            this.createRoom();
          } else {
            this.editCinema();
          }
        }
      });
    },

    confirmEventDelete({ id }) {
      this.$confirm(
        `Bạn có chắc xóa hết tất cả dữ liệu của phòng này ?`,
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
      this.$confirm(`Bạn có chắc chắn thay đổi trạng thái phòng `, "Cảnh báo", {
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


<style>
.seat_customer .el-input__inner {
  line-height: 0px;
  height: 30px;
  text-align: center;
  padding: 0px;
  border-radius: 0px;
}
.seat_customer .el-form-item__content {
  height: 30px;
}
.option_seat_customer .el-input__inner {
  border-bottom: none;
}
.name_seat {
  margin-bottom: 30px;
}
</style>