<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full flex relative my-10 bg-red-300">
          Thong tin chi tiet cua rap
        </div>
        <el-tabs class="demo-tabs">
          <!-- Tab Phòng chiếu  -->
          <el-tab-pane label="Phòng chiếu">
            <div class="p-4">
              <div class="w-full flex relative my-4">
                <div class="w-3/4 flex items-end">
                  <div class="search">
                    <search-input label="Tìm tên phòng ... "></search-input>
                  </div>
                </div>
                <div class="w-1/4 text-right">
                  <el-button @click="onOpenDialogRoom">Thêm Phòng</el-button>
                </div>
              </div>
              <div class="grid grid-cols-6 gap-4">
                <div class="border rounded-md p-4">
                  <h2 class="text-center cursor-pointer">Phòng 201</h2>
                  <p class="text-center">256 ghế</p>
                  <p class="text-center">Trạng thái</p>
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
                    :rules="rules"
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
                  <div class="bg-gray-700 my-5 p-2 grid grid-cols-12 gap-4">
                    <div
                      class="w-16 bg-red-400 rounded-sm"
                      v-for="item in 100"
                      :key="item"
                    >
                      {{ Row }}
                    </div>
                  </div>
                </el-dialog>
              </div>
            </div>
          </el-tab-pane>
          <!-- Tab Suất chiếu -->
          <el-tab-pane label="Suất chiếu">
            <div class="p-4">
              <div class="w-full flex relative my-4">
                <div class="w-3/4 flex items-end">
                  <div class="search">
                    <search-input label="Chọn ngày  ... "></search-input>
                  </div>
                  <div class="search">
                    <search-input label="chọn thể loại... "></search-input>
                  </div>
                  <div class="search">
                    <search-input label="Tìm Tên phim... "></search-input>
                  </div>
                </div>
                <div class="w-1/4 text-right">
                  <el-button @click="onOpenDialogRoom">Thêm Suất chiếu</el-button>
                </div>
              </div>
              <div class="grid grid-cols-6 gap-4">
                <div class="border rounded-md p-4">
                  <h2 class="text-center cursor-pointer">Ảnh</h2>
                  <h2 class="text-center cursor-pointer">Bố già</h2>
                  <p class="text-center">111 suất chiếu</p>
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
                    :rules="rules"
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
                  <div class="bg-gray-700 my-5 p-2 grid grid-cols-12 gap-4">
                    <div
                      class="w-16 bg-red-400 rounded-sm"
                      v-for="item in 100"
                      :key="item"
                    >
                      {{ Row }}
                    </div>
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
export default {
  name: "Cinema",
  components: {
    AdminLayout,
    PageInfo,
    SearchInput,
    Pagination,
    Edit,
    Delete,
  },
  props: {
    cinemas: {
      required: true,
    },
    filtersBE: {
      type: Object,
      required: true,
    },
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
      Row: "",
      Column: "",
      selectedItemRoom: null,
      loading: false,
      dialogFormVisibleRoom: false,
      total: "",
      perPage: "",
      formDataRoom: this.$inertia.form({
        name: "",
        row_number: "",
        column_number: "",
      }),
      rules: {
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
        ],
        column_number: [
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
    inertiaRoom() {
      Inertia.get(
        route("admin.cinema.index", this.filter),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
    },
    handleCurrentPage(value) {
      this.filter.page = value;
      this.inertiaRoom();
    },
    searchChange() {
      this.filter.page = 1;
      this.inertiaRoom();
    },

    // method inertia
    onOpenDialogRoom() {
      this.formDataRoom.reset();
      this.selectedItemRoom = null;
      this.dialogFormVisibleRoom = !this.dialogFormVisibleRoom;
    },
    createRoom() {
      Inertia.post(route("admin.cinemas.store"), this.formDataRoom, {
        onBefore,
        onFinish,
        preserveScroll: true,
        onError: (e) => console.log(e),
        onSuccess: (_) => {
          this.formDataRoom.reset();
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
    viewDiagram() {
      this.$refs["formDataRoom"].validate((valid) => {
        if (valid) {
          this.Row = this.formDataRoom.row_number;
          this.Column = this.formDataRoom.column_number;
        }
      });
    },
    async onSubmitRoom() {
      this.$refs["formDataRoom"].validate((valid) => {
        if (valid) {
          if (this.selectedItem === null) {
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
