<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Quản lý loại phim</h2>
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
        </div>

        <div class="mt-5">
          <data-table
            :fields="fields"
            :items="movie_genres.data"
            :paginate="movie_genres.meta"
            :current-page="filter.page || 1"
            disable-table-info
            footer-center
            paginate-background
            enable-select-box
            @page="handleCurrentPage"
          >
            <template #created_at="{ row }">
              <p>{{ formatDateTime(row?.created_at) }}</p>
            </template>
            <!-- <template #actions="{ row }">
              <div  class="flex items-center">
                <button
                  class="py-2 px-4 rounded bg-blackPrimary-100"
                  @click="handleDelete(row)"
                >
                  delete
                </button>
                <button
                  class="ml-4 py-2 px-4 rounded bg-yellowPrimary"
                  @click="$inertia.get(route('back.contacts.detail', row?.id))"
                >
                  詳細
                </button>
              </div>
            </template> -->
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
import { listMovieGenre, deleteMovieGenre } from "@/API/movie_genre.js";

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
      movie_genres: [],
      filter: {
        page: 1,
        limit: 10,
      },
      fields: [
        { key: "id", label: "ID", width: 100 },
        { key: "name", label: "Tên thể loại", width: 250 },
        { key: "price", label: "Giá tiền", width: 200 },
        { key: "create_at", label: "Ngày tạo", width: 500 },
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
      listMovieGenre(this.filter)
        .then(({ status, data }) => {
          this.movie_genres = status === 200 ? data : this.movie_genres;
        })
        .catch(() => {
          this.$message.error("Server Error");
        });
      this.loading = false;
    },

    formatDateTime,

    async handleDelete(item) {
      this.$confirm("Are you sure to delete this contact?", "Warning", {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "warning",
      }).then(async () => {
        this.loading = true;
        await deleteContact(item.id)
          .then(async (res) => {
            this.fetchData();
            this.$message.success("Delete completed");
          })
          .catch(() => {
            this.$message.error("Server Error");
          });
        this.loading = false;
      });
    },
  },
};
</script>
