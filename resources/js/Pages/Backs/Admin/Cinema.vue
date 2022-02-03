<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full flex relative my-10">
          <div class="w-3/4 flex items-end">
            <div class="search">
              <el-input
                ref="search"
                placeholder="Tìm kiếm"
                clearable
                v-model="keyword"
                @keyup.enter="searchChange()"
              />
            </div>
          </div>
          <div class="w-1/4 text-right">
            <el-button @click="dialogFormVisible = true">Thêm Admin</el-button>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
          <div
            v-for="item in admins"
            :key="item"
            class="border rounded-md p-4 cursor-pointer"
          >
            <h2 class="text-center">vsvsvsvsvs</h2>
            <div class="flex">
              <h3 class="w-1/2">Người quản lý :</h3>
              <div>{{ item.user.name }}</div>
            </div>
            <div class="flex">
              <h3 class="w-1/2">Rạp :</h3>
              <div>10 rạp</div>
            </div>
            <div class="flex">
              <h3 class="w-1/2">Phòng :</h3>
              <div>105 phòng</div>
              <div>{{ Number(perPage) }}</div>
              <div>{{ Number(total) }}</div>
            </div>
          </div>
        </div>
        <!-- phan trang  -->
        <div class="w-full justify-center my-10">
          <pagination :page-size="Number(perPage)" :total="Number(total)" />
        </div>
        <!-- open dialog -->
        <el-dialog title="Thêm rạp" v-model="dialogFormVisible">
          <el-form :model="form">
            <el-form-item label="Tên rạp" :label-width="formLabelWidth">
              <el-input v-model="form.name" autocomplete="off"></el-input>
            </el-form-item>
          </el-form>
          <span class="dialog-footer text-right">
            <el-button @click="dialogFormVisible = false">Hủy</el-button>
            <el-button type="primary" @click="dialogFormVisible = false">Thêm</el-button>
          </span>
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
import dialogFormVisible from "element-plus";

export default {
  name: "Cinema",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
    dialogFormVisible,
  },
  data() {
    return {
      loading: false,
      dialogFormVisible: false,
      total: "",
      perPage: "",
      keyword: "",
      admins: [],
      filter: {
        page: 1,
        limit: 10,
      },
      form: {
        name: "",
        region: "",
        date1: "",
        date2: "",
        delivery: false,
        type: [],
        resource: "",
        desc: "",
      },
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    handleCurrentPage(value) {
      this.filter.page = value;
      this.fetchData();
    },
    searchChange() {
      this.filter.name = this.keyword;
      this.$emit("handleFilter");
    },
    async fetchData() {
      this.loading = true;
      listAdmin(this.filter)
        .then(({ status, data }) => {
          this.admins = status === 200 ? data.data : this.admins;
          this.total = data.data.meta.total;
          this.perPage = data.data.meta.per_page;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>
