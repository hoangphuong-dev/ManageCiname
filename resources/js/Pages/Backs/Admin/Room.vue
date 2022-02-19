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
    <div v-if="rooms.data.length > 0" class="grid grid-cols-5 gap-4">
      <div
        class="border rounded-md p-4"
        v-for="item in rooms.data"
        :key="item.id"
      >
        <h2 class="text-center">{{ item.name }}</h2>
        <p class="text-center">
          {{ item.row_number * item.column_number }} ghế
        </p>
        <p class="text-center">Trạng thái {{ item.status }}</p>
        <div class="mt-4 flex">
          <div class="text-left w-1/2">
            <!-- <el-icon class="cursor-pointer" @click="edit(item)"
              ><edit
            /></el-icon> -->
          </div>
          <div class="text-right w-1/2">
            <!-- <el-icon class="cursor-pointer" @click="confirmEventDelete(item)"
              ><delete
            /></el-icon> -->
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
        class="text-center"
        :title="
          selectedItemRoom === null ? 'Thêm phòng' : 'Sửa thông tin phòng'
        "
        v-model="dialogFormVisibleRoom"
      >
        <el-form
          class="text-center w-1/2 m-auto"
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

          <el-form-item label="Số hàng" prop="row_number">
            <el-input
              v-model="formDataRoom.row_number"
              autocomplete="off"
              placeholder="Nhập số hàng"
            ></el-input>
          </el-form-item>

          <el-form-item label="Số dãy" prop="column_number">
            <el-input
              v-model="formDataRoom.column_number"
              autocomplete="off"
              placeholder="Nhập số dãy"
            ></el-input>
          </el-form-item>
        </el-form>
        <!-- submit -->
        <div class="text-right">
          <span class="dialog-footer">
            <el-button @click="dialogFormVisibleRoom = false">Hủy</el-button>
            <el-button type="primary" @click="viewDiagram">
              <span v-if="selectedItemRoom === null">Xem sơ đồ</span>
            </el-button>
          </span>
        </div>
        <div class="my-5 p-2 text-center justify-items-center">
          <h2 class="my-2" v-if="showTitle">Sơ đồ ghế</h2>
          <div
            class="grid gap-4"
            :style="{
              'grid-template-columns': 'repeat(' + Column + ', minmax(0, 1fr))',
            }"
          >
            <div
              class="border rounded-md p-1 text-center bg-green-100"
              v-for="(seat, indexSeat) in formDataRoom.seats"
              :key="indexSeat"
            >
              <div class="flex min-w-124 w-full">
                <el-form-item class="w-1/2">
                  <el-input v-model="seat.row"></el-input>
                </el-form-item>
                <el-form-item class="w-1/2">
                  <el-input v-model="seat.column"></el-input>
                </el-form-item>
              </div>
              <div class="-mt-6 min-w-124 w-full">
                <el-select class="w-full" clearable v-model="seat.seat_type">
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
import { listRoom } from "@/API/main.js";
export default {
  name: "Room",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
  },
  props: {
    cinema: {
      type: Object,
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
          limit: 10,
          cinema_id: this.cinema.id,
        },
      },
      formDataRoom: {
        name: "",
        row_number: "",
        column_number: "",
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
        row_number: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
          {
            pattern: /^\d+$/,
            message: "Trường thông tin này phải là số nguyên",
            trigger: "blur",
          },
          {
            max: 2,
            number: true,
            message: "Số hàng không lớn hơn 100",
            trigger: "blur",
          },
        ],
        column_number: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
          {
            pattern: /^\d+$/,
            message: "Trường thông tin này phải là số nguyên",
            trigger: "blur",
          },
          {
            max: 2,
            number: true,
            message: "Số dãy không lớn hơn 100",
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
              });
            }
          }
        }
      });
    },
    // lay du lieu cho phong chieu
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
    onOpenDialogRoom() {
      this.selectedItemRoom = null;
      this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
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
            // this.resetFormRoom();
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
