<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Quản lý Phim</h2>
        <div class="w-full flex relative">
          <div class="w-3/4 flex items-end">
            <div class="search">
              <search-input
                :filter="filter"
                @submit="fetchData"
                label="Tìm kiếm"
              ></search-input>
            </div>
          </div>
          <div class="w-1/4 text-right">
            <el-button>Thêm phim</el-button>
          </div>
        </div>

        <div class="mt-5">
          <data-table
            :fields="fields"
            :items="movies.data"
            :paginate="movies.meta"
            :current-page="filter.page || 1"
            disable-table-info
            footer-center
            paginate-background
            enable-select-box
            @page="handleCurrentPage"
          >
          </data-table>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import { formatDateTime } from "@/libs/datetime";

import { ref } from "vue";
import { listMovie, deleteMovie } from "@/API/movie.js";

export default {
  name: "Contact",
  components: {
    AdminLayout,
    SearchInput,
    DataTable,
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      movies: [],
      filter: {
        page: 1,
        limit: 10,
      },
      fields: [
        { key: "name", label: "Tên phim" },
        { key: "image", label: "Ảnh" },
        { key: "director", label: "Đạo diễn" },
        { key: "rated", label: "Giới hạn độ tuổi" },
        { key: "status", label: "Trạng thái" },
      ],
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
    async fetchData() {
      this.loading = true;
      listMovie(this.filter)
        .then(({ status, data }) => {
          this.movies = status === 200 ? data : this.movies;
        })
        .catch(() => {
          this.$message.error("Server Error");
        });
      this.loading = false;
    },
    // async handleDelete(item) {
    //   this.$confirm("Are you sure to delete this contact?", "Warning", {
    //     confirmButtonText: "OK",
    //     cancelButtonText: "Cancel",
    //     type: "warning",
    //   }).then(async () => {
    //     this.loading = true;
    //     await deleteContact(item.id)
    //       .then(async (res) => {
    //         this.fetchData();
    //         this.$message.success("Delete completed");
    //       })
    //       .catch(() => {
    //         this.$message.error("Server Error");
    //       });
    //     this.loading = false;
    //   });
    // },
  },
};
</script>
