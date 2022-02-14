<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
      <h2 class="mb-5">Hệ thống rạp</h2>
        <div class="w-full flex relative">
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
            <el-button @click="$inertia.visit(route('superadmin.create_admin'))"
              >Thêm Admin</el-button
            >
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-5">
          <div
            v-for="item in admins"
            :key="item"
            class="border rounded-md p-4 cursor-pointer"
          >
            <h2 class="text-center">{{ item.province.name }}</h2>
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
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { listAdmin } from "@/API/main.js";

export default {
  name: "AdminInfo",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      total: "",
      perPage: "",
      keyword: "",
      admins: [],
      filter: {
        page: 1,
        limit: 10,
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
