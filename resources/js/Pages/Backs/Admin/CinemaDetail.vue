<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full relative my-10 bg-red-300">
          <h2>PHC {{cinema.name}}</h2>
          <p>Hotline : {{cinema.hotline}}</p>
          <p>Dia chi : {{cinema.address}}</p>
          <p>So phong : 12 phong</p>
          <p>Phim : 115 phim dang cong chieu</p>
        </div>
        <el-tabs>
          <!-- Tab Phòng chiếu  -->
          <el-tab-pane label="Phòng chiếu">
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
              <div class="grid grid-cols-6 gap-4">
                <div class="border rounded-md p-4" v-for="item in rooms.data" :key="item.id">
                  <h2 class="text-center cursor-pointer">{{ item.name }}</h2>
                  <p class="text-center">{{ item.row_number * item.column_number }} ghế</p>
                  <p class="text-center">Trạng thái {{item.status}}</p>
                  <div class="mt-4 flex">
                    <div class="text-left w-1/2">
                      <el-icon
                        class="cursor-pointer"
                        @click="edit(item)"
                        ><edit
                      /></el-icon>
                    </div>
                    <div class="text-right w-1/2">
                      <el-icon
                        class="cursor-pointer"
                        @click="confirmEventDelete(item)"
                        ><delete
                      /></el-icon>
                    </div>
                  </div>
                </div>
              </div>
              <!-- phan trang phòng chiếu  -->
              <!-- <div
                v-if="cinemas.meta.total > cinemas.meta.per_page"
                class="w-full justify-center my-10 flex"
              >
                <page-info
                  :total-page="cinemas.meta.total"
                  :current-page="cinemas.meta.current_page"
                  :per-page="cinemas.meta.per_page"
                />
                <pagination
                  v-model="cinemas.meta.current_page"
                  @current-change="handleCurrentPage"
                  :page-size="Number(cinemas.meta.per_page)"
                  :total="Number(cinemas.meta.total)"
                />
              </div> -->
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
                  <div class="bg-gray-700 my-5 p-2 text-center justify-items-center">
                    <div class="grid gap-4" :style="{'grid-template-columns': 'repeat('+ Column+', minmax(0, 1fr))'}">
                        <div class="border rounded-md p-4"
                            v-for="(seat, indexSeat) in formDataRoom.seats" :key="indexSeat">
                            <el-form-item>
                                <el-input
                                    v-model="seat.row"
                                ></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-input
                                    v-model="seat.column"
                                ></el-input>
                            </el-form-item>
                            <el-select
                                class="w-full"
                                clearable
                                v-model="seat.seat_type"
                            >
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
                  <div class="text-center">
                    <el-button v-if="showDiagram" @click="onSubmitRoom">Thêm phòng</el-button>
                  </div>
                </el-dialog>
              </div>
            </div>
          </el-tab-pane>
          <!-- Tab Suất chiếu -->
          <el-tab-pane label="Suat chieu">
            <div class="p-4">
              <div class="w-full flex relative my-4">
                <div class="w-3/4 flex items-end">
                  <div class="search">
                    <el-input
                        ref="search"
                        placeholder="Tìm suat chieu... "
                        clearable
                        v-model="showtimes.keyword"
                        @keyup.enter="searchChange()"
                    />
                  </div>
                </div>
                <div class="w-1/4 text-right">
                  <el-button @click="onOpenDialogShowTime">Thêm Suat chieu</el-button>
                </div>
              </div>
              <div class="grid grid-cols-6 gap-4">
                <!-- <div class="border rounded-md p-4" v-for="item in rooms.data" :key="item.id">
                  <h2 class="text-center cursor-pointer">{{ item.name }}</h2>
                  <p class="text-center">{{ item.row_number * item.column_number }} ghế</p>
                  <p class="text-center">Trạng thái {{item.status}}</p>
                  <div class="mt-4 flex">
                    <div class="text-left w-1/2">
                      <el-icon
                        class="hover:text-blue-500 cursor-pointer"
                        @click="edit(item)"
                        ><edit
                      /></el-icon>
                    </div>
                    <div class="text-right w-1/2">
                      <el-icon
                        class="hover:text-blue-500 cursor-pointer"
                        @click="confirmEventDelete(item)"
                        ><delete
                      /></el-icon>
                    </div>
                  </div>
                </div> -->
              </div>
              <!-- phan trang phòng chiếu  -->
              <!-- <div
                v-if="cinemas.meta.total > cinemas.meta.per_page"
                class="w-full justify-center my-10 flex"
              >
                <page-info
                  :total-page="cinemas.meta.total"
                  :current-page="cinemas.meta.current_page"
                  :per-page="cinemas.meta.per_page"
                />
                <pagination
                  v-model="cinemas.meta.current_page"
                  @current-change="handleCurrentPage"
                  :page-size="Number(cinemas.meta.per_page)"
                  :total="Number(cinemas.meta.total)"
                />
              </div> -->
              <!-- dialog suat chieu  -->
              <div class="customer_dialog">
                <el-dialog
                  class="text-center"
                  :title="
                    selectedItemShowTime === null ? 'Thêm suat chieu' : 'Sửa thông tin suat'
                  "
                  v-model="dialogFormVisibleShowTime"
                >
                  <el-form
                    class="text-center w-1/2 m-auto"
                    ref="formDataShowTime"
                    :model="formDataShowTime"
                    label-position="top"
                    :rules="rulesShowTime"
                  >
                    <!-- Tên rạp -->
                    <el-form-item label="Tên phòng" prop="name">
                      <el-input
                        v-model="formDataShowTime.name"
                        autocomplete="off"
                        placeholder="Nhập tên phòng"
                      ></el-input>
                    </el-form-item>

                  </el-form>
                  <!-- submit -->
                  <div class="text-right">
                    <span class="dialog-footer">
                      <el-button @click="dialogFormVisibleShowTime = false">Hủy</el-button>
                      <el-button type="primary" @click="viewDiagram">
                        <span v-if="selectedItemShowTime === null">Theem suat</span>
                      </el-button>
                    </span>
                  </div>
                </el-dialog>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import PageInfo from "@/Components/Control/PageInfo.vue";
import { Edit, Delete } from "@element-plus/icons-vue";
import { listRoom, listShowTime} from "@/API/main.js";
export default {
  name: "CinemaDetail",
  components: {
    AdminLayout,
    PageInfo,
    SearchInput,
    Pagination,
    Edit,
    Delete,
  },
  props: {
    cinema: {
        type:Array,
        required: true,
    },
    filtersBE: {
      type: Object,
      required: true,
    },
    seat_types: Array,
  },
  computed: {
    filter() {
      return {
        page: this.filtersBE.page?.toInt() || 1,
        limit: this.filtersBE.limit?.toInt() || 10,
        status: this.filtersBE?.status?.toInt(),
        name: this.filtersBE?.name || "",
      };
    },
  },
  data() {
    return {
        showtimes: {
            data: [],
            total: '',
            keyword: '',
            perPage: '',
            filter: {
                page: 1,
                limit: 10,
                cinema_id: this.cinema.id,
            },
        },
        rooms: {
            data: [],
            total: '',
            keyword: '',
            perPage: '',
            filter: {
                page: 1,
                limit: 10,
                cinema_id: this.cinema.id,
            },
        },
      showDiagram: false,
      Row: "",
      Column: "",
      selectedItemRoom: null,
      selectedItemShowTime: null,
      loading: false,
      dialogFormVisibleRoom: false,
      dialogFormVisibleShowTime: false,
      formDataRoom: {
        name: "",
        row_number: "",
        column_number: "",
        seats: [],
      },

      formDataShowTime: {
        name: "",

      },
      rulesRoom: {
        name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
      },
      rulesShowTime: {
        name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
      },
    };
  },
    created() {
    this.fetchDataRoom();
    this.fetchDataShowTime();
  },
  methods: {
    viewDiagram() {
        this.$refs["formDataRoom"].validate((valid) => {
        if (valid) {
            this.Row = this.formDataRoom.row_number;
            this.Column = this.formDataRoom.column_number;
            this.showDiagram = true
            this.formDataRoom.seats = []
            for (let i = 0; i < this.Row; i++) {
                for (let j = 0; j < this.Column; j++) {
                    this.formDataRoom.seats.push({
                        row: String.fromCharCode(i + 65),
                        column: Number(j + 1),
                    })
                }
            }
        }
        });
    },
    // lay du lieu cho phong chieu
    // handleCurrentPage(value) {
    //   this.filter.page = value;
    //   this.fetchData();
    // },
    searchChange() {
      this.rooms.filter.name = this.rooms.keyword;
      this.fetchDataRoom();
    },
    async fetchDataRoom() {
      this.loading = true;
      listRoom(this.rooms.filter)
        .then(({ status, data }) => {
          this.rooms.data = status === 200 ? data.data : this.rooms.data;
          this.rooms.total = data.meta.total;
          this.rooms.perPage = data.meta.per_page;
        })
        .catch(() => {});
      this.loading = false;
    },
    async fetchDataShowTime() {
      this.loading = true;
      listShowTime(this.rooms.filter)
        .then(({ status, data }) => {
          this.rooms.data = status === 200 ? data.data : this.rooms.data;
          this.rooms.total = data.meta.total;
          this.rooms.perPage = data.meta.per_page;
        })
        .catch(() => {});
      this.loading = false;
    },
    // method inertia

    resetFormRoom() {
        this.formDataRoom.name = '';
        this.formDataRoom.row_number = '';
        this.formDataRoom.column_number = '';
        this.formDataRoom.seats =  [];
    },

    onOpenDialogRoom() {
      this.selectedItemRoom = null;
      this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
    },
    onOpenDialogShowTime() {
      this.selectedItemShowTime = null;
      this.dialogFormVisibleShowTime = !this.dialogFormVisibleShowTime;
    },
    createRoom() {
      Inertia.post(route("admin.rooms.store"), {
          ...this.formDataRoom,
          cinema_id : this.cinema.id

      }, {
        onBefore,
        onFinish,
        preserveScroll: true,
        onError: (e) => console.log(e),
        onSuccess: (_) => {
            // this.resetFormRoom();
          this.fetchDataRoom();
          this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
        },
      });
    },
    edit(item) {
      console.log(item);
      this.dialogFormVisibleRoom = true;
      this.selectedItemRoom = item.id;

      this.formDataRoom.name = item.name;
      this.formDataRoom.hotline = item.hotline;
      this.formDataRoom.address = item.address;
    },
    editCinema() {
      Inertia.post(
        route("admin.cinemas.edit", { id: this.selectedItemRoom }),
        this.formDataRoom,
        {
          onBefore,
          onFinish,
          preserveScroll: true,
          onError: (e) => console.log(e),
          onSuccess: (_) => {
            this.formDataRoom.reset();
            this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
            this.selectedItemRoom = null;
          },
        }
      );
    },
    detail(id) {
      Inertia.get(
        route("admin.cinemas.show", { id: id }),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
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
      this.$confirm(`Bạn có chắc chắc muốn xóa ?`, "Cảnh báo", {
        confirmButtonText: "Chắc chắn",
        cancelButtonText: "Hủy",
        type: "warning",
      }).then(async () => {
        Inertia.delete(route("admin.cinemas.delete", { id }), {
          onBefore,
          onFinish,
          preserveScroll: true,
          onError: (e) => console.log(e),
        });
      });
    },
  },
};
</script>
<style>
.customer_dialog .el-overlay .el-overlay-dialog .el-dialog {
  width: 90%;
}
</style>
