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
            <h2 class="text-center cursor-pointer" @click="detail(item)">
              PHC {{ item.name }}
            </h2>
            <p class="text-center">15 phòng</p>
            <p class="text-center">150 phim đang công chiếu</p>
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
            <!-- Tên rạp -->
            <el-form-item label="Tên rạp" prop="name">
              <el-input
                v-model="formData.name"
                autocomplete="off"
                placeholder="Nhập tên rạp"
              ></el-input>
            </el-form-item>
            <!-- Hotline -->
            <el-form-item label="Hotline" prop="hotline">
              <el-input
                v-model="formData.hotline"
                autocomplete="off"
                placeholder="Nhập số điện thoại"
              ></el-input>
            </el-form-item>
            <!-- Địa chỉ -->
            <el-form-item label="Địa chỉ" prop="hotline">
              <el-input
                v-model="formData.address"
                autocomplete="off"
                placeholder="Nhập địa chỉ"
              ></el-input>
            </el-form-item>

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
      selectedItem: null,
      loading: false,
      dialogFormVisible: false,
      total: "",
      perPage: "",
      formData: this.$inertia.form({
        name: "",
        hotline: "",
        address: "",
      }),
      rules: {
        name: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        hotline: [
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
        route("superadmin.cinema.index", this.filter),
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
      console.log(item);
      this.dialogFormVisible = true;
      this.selectedItem = item.id;

      this.formData.name = item.name;
      this.formData.hotline = item.hotline;
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
