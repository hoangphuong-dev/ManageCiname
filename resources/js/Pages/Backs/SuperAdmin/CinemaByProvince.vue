<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full flex relative my-10">
          <div class="w-3/4 flex items-end">
            <div class="search">
              <search-input
                :filter="filter"
                v-model="filter.name"
                label="Tên rạp, địa chỉ ... "
                @submit="searchChange()"
              ></search-input>
            </div>
          </div>
          <div class="w-1/4 text-right">
            <el-button @click="onOpenDialog">Thêm Rạp</el-button>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
          <div
            v-for="item in cinemas.data"
            :key="item.id"
            class="border rounded-md p-4"
          >
            <h2 class="text-center mb-2">{{ item.name }}</h2>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                Quản lý
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
              >
                {{ item.user.name }}
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                Hotline
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
              >
                {{ item.user.phone }}
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                Số phòng
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
              >
                5555
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2">
                Phim đang chiếu
              </div>
              <div class="w-2/3 border-dashed border-2 p-2 border-l-0">
                11 phim
              </div>
            </div>

            <div class="mt-4 flex">
              <div class="text-left w-1/3">
                <el-tooltip content="Sửa thông tin rạp">
                  <el-icon
                    class="hover:text-red-500 cursor-pointer"
                    @click="edit(item)"
                    ><edit
                  /></el-icon>
                </el-tooltip>
              </div>
              <div class="w-1/3 text-center">
                <el-tooltip content="Xem chi tiết rạp">
                  <el-icon
                    class="hover:text-red-500 cursor-pointer"
                    @click="detail(item)"
                    ><zoom-in
                  /></el-icon>
                </el-tooltip>
              </div>
              <div class="text-right w-1/3">
                <el-tooltip content="Xóa rạp">
                  <el-icon
                    class="hover:text-red-500 cursor-pointer"
                    @click="confirmEventDelete(item)"
                    ><delete
                  /></el-icon>
                </el-tooltip>
              </div>
            </div>
          </div>
        </div>

        <!-- phan trang  -->
        <div
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
        </div>

        <!-- open dialog -->
        <el-dialog
          :title="selectedItem === null ? 'Thêm rạp' : 'Sửa thông tin rạp'"
          v-model="dialogFormVisible"
        >
          <el-form
            ref="formData"
            :model="formData"
            label-position="top"
            :rules="rules"
          >
            <div class="flex w-full">
              <div class="w-1/2 mr-4">
                <!-- Tên admin -->
                <el-form-item label="Tên người quản lý" prop="name">
                  <el-input
                    v-model="formData.name"
                    autocomplete="off"
                    placeholder="Nhập tên"
                  ></el-input>
                </el-form-item>

                <!-- Số điện thoại -->
                <el-form-item label="Số điện thoại" prop="phone">
                  <el-input
                    v-model="formData.phone"
                    autocomplete="off"
                    placeholder="Nhập số điện thoại"
                  ></el-input>
                </el-form-item>

                <!-- Email -->
                <div v-if="selectedItem == null">
                  <el-form-item label="Email" prop="email">
                    <el-input
                      v-model="formData.email"
                      autocomplete="off"
                      placeholder="Nhập email"
                    ></el-input>
                  </el-form-item>
                </div>
              </div>

              <div class="w-1/2">
                <!-- Tên rạp -->
                <el-form-item label="Tên rạp" prop="cinema_name">
                  <el-input
                    v-model="formData.cinema_name"
                    autocomplete="off"
                    placeholder="Nhập tên rạp"
                  ></el-input>
                </el-form-item>

                <!-- Địa chỉ -->
                <el-form-item label="Địa chỉ" prop="address">
                  <el-input
                    v-model="formData.address"
                    autocomplete="off"
                    placeholder="Nhập email"
                  ></el-input>
                </el-form-item>
              </div>
            </div>

            <!-- submit -->
            <div class="text-right">
              <span class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Hủy</el-button>
                <el-button type="primary" @click="onSubmit">
                  <span v-if="selectedItem === null">Thêm</span>
                  <span v-else>Cập nhật</span>
                </el-button>
              </span>
            </div>
          </el-form>
        </el-dialog>
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
import { Edit, Delete, ZoomIn } from "@element-plus/icons-vue";

export default {
  name: "CinemaByProvince",
  components: {
    AdminLayout,
    PageInfo,
    SearchInput,
    Pagination,
    Edit,
    Delete,
    ZoomIn,
  },
  props: {
    province_id: String,
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
        limit: this.filtersBE.limit?.toInt() || 12,
        status: this.filtersBE?.status?.toInt(),
        name: this.filtersBE?.name || "",
        province_id: this.filtersBE?.province_id || "",
      };
    },
  },
  data() {
    return {
      selectedItem: null,
      loading: false,
      dialogFormVisible: false,
      total: "",
      perPage: "",
      formData: this.$inertia.form({
        name: "",
        phone: "",
        email: "",
        cinema_name: "",
        address: "",
        province_id: this.province_id,
      }),
      rules: {
        name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        phone: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "change",
          },
          {
            validator: function (err, value, callback) {
              let val = value.replace(/\s+/g, " ");
              if (
                !(val.length >= 9 && val.length <= 12) ||
                value.includes(" ")
              ) {
                return callback("Số điện thoại không đúng định dạng");
              }
              callback();
            },
            trigger: "change",
          },
        ],
        email: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
          {
            type: "email",
            message: "Email không đúng định dạng",
            trigger: "change",
          },
        ],
        cinema_name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        address: [
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
    inertia() {
      Inertia.get(
        route("superadmin.cinema.province", this.filter),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
    },
    handleCurrentPage(value) {
      this.filter.page = value;
      this.inertia();
    },
    searchChange() {
      this.filter.page = 1;
      this.inertia();
    },

    // method inertia
    onOpenDialog() {
      this.formData.reset();
      this.selectedItem = null;
      this.dialogFormVisible = !this.dialogFormVisible;
    },
    createCinema() {
      Inertia.post(route("superadmin.cinemas.store"), this.formData, {
        onBefore,
        onFinish,
        preserveScroll: true,
        onError: (e) => console.log(e),
        onSuccess: (_) => {
          this.formData.reset();
          this.dialogFormVisible = !this.dialogFormVisible;
        },
      });
    },
    edit(item) {
      this.dialogFormVisible = true;
      this.selectedItem = item.id;

      this.formData.user_id = item.user.id;
      this.formData.name = item.user.name;
      this.formData.phone = item.user.phone;
      this.formData.email = item.user.email;
      this.formData.cinema_name = item.name;
      this.formData.address = item.address;
    },
    editCinema() {
      Inertia.post(
        route("superadmin.cinemas.edit", { id: this.selectedItem }),
        this.formData,
        {
          onBefore,
          onFinish,
          preserveScroll: true,
          onError: (e) => console.log(e),
          onSuccess: (_) => {
            this.formData.reset();
            this.dialogFormVisible = !this.dialogFormVisible;
            this.selectedItem = null;
          },
        }
      );
    },

    detail(id) {
      Inertia.get(
        route("superadmin.cinemas.show", { id: id }),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
    },
    async onSubmit() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          if (this.selectedItem === null) {
            this.createCinema();
          } else {
            this.editCinema();
          }
        }
      });
    },
    confirmEventDelete({ id }) {
      this.$confirm(
        `Bạn có chắc xóa hết tất cả dữ liệu của rạp này ?`,
        "Cảnh báo",
        {
          confirmButtonText: "Chắc chắn",
          cancelButtonText: "Hủy",
          type: "warning",
        }
      ).then(async () => {
        Inertia.delete(route("superadmin.cinemas.delete", { id }), {
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
