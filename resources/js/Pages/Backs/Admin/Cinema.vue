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
            :key="item"
            class="border rounded-md p-4 cursor-pointer"
          >
            <h2 class="text-center">PHC {{ item.name }}</h2>
            <div class="flex">
              <h3 class="w-1/2">Người quản lý :</h3>
              <div>vsvsvsv</div>
            </div>
            <div class="flex">
              <h3 class="w-1/2">aaaa :</h3>
              <div>aaaa aaaa</div>
            </div>
            <div class="flex">
              <h3 class="w-1/2">Phòng :</h3>
              <div>105 phòng</div>
            </div>
          </div>
        </div>
        <!-- phan trang  -->
        <div class="w-full justify-center my-10">
          <pagination
            v-model="cinemas.meta.current_page"
            @current-change="handleCurrentPage"
            :page-size="Number(cinemas.meta.per_page)"
            :total="Number(cinemas.meta.total)"
          />
        </div>
        <!-- open dialog -->
        <el-dialog class="text-center" title="Thêm rạp" v-model="dialogFormVisible">
          <el-form ref="formData" :model="formData" label-position="top" :rules="rules">
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
          </el-form>
          <!-- submit -->
          <div class="text-right">
            <span class="dialog-footer">
              <el-button @click="dialogFormVisible = false">Hủy</el-button>
              <el-button type="primary" @click="onSubmit">Thêm</el-button>
            </span>
          </div>
        </el-dialog>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { listAdmin } from "@/API/main.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  name: "Cinema",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
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
        route("admin.cinema.index", this.filter),
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
      Inertia.post(route("admin.cimemas.store"), this.formData, {
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
    async onSubmit() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          if (this.selectedItem === null) {
            this.createCinema();
          } else {
            this.editNotification();
          }
        }
      });
    },
  },
};
</script>
