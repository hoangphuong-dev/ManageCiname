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
            <el-button @click="$inertia.visit(route('superadmin.create_movie'))"
              >Thêm phim FFFFF</el-button
            >
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
            <!-- <template #trailler="{ row }">
              <iframe
                width="300"
                height="150"
                :src="'https://www.youtube.com/embed/' + videoId(row)"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>
            </template> -->
            <template #image="{ row }">
              <img
                :src="
                  'https://i3.ytimg.com/vi/' +
                  videoId(row) +
                  '/maxresdefault.jpg'
                "
                alt="ảnh từ youtube"
              />
            </template>
            <template #status="{ row }">
              <div v-if="row" class="flex items-center">
                <el-switch
                  v-model="row.status_switch"
                  active-color="#13ce66"
                  inactive-color="#cccccc"
                  :active-value="MOVIE_ACTIVE"
                  :inactive-value="MOVIE_DEACTIVE"
                  @click="updateStatus(row, row.status_switch)"
                />
              </div>
            </template>
            <template #action="{ row }">
              <div class="flex">
                <div class="mx-4">Sửa</div>
                <div
                  v-if="row?.status_switch == MOVIE_DEACTIVE"
                  @click="confirmEventDelete(row)"
                  class="cursor-pointer btn-danger p-1 w-8 flex justify-center"
                >
                  <img src="/images/trash_white.svg" />
                </div>
              </div>
            </template>
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
import { listMovie, updateStatusMovie } from "@/API/main.js";
import { MOVIE_ACTIVE, MOVIE_DEACTIVE } from "@/store/const.js";
import { Inertia } from "@inertiajs/inertia";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Edit, Delete } from "@element-plus/icons-vue";

export default {
  name: "Movie",
  components: {
    AdminLayout,
    SearchInput,
    DataTable,
    Edit,
    Delete,
  },

  data() {
    return {
      MOVIE_ACTIVE: MOVIE_ACTIVE,
      MOVIE_DEACTIVE: MOVIE_DEACTIVE,
      loading: false,
      dialogVisible: false,
      url: "",
      movies: [],
      filter: {
        page: 1,
        limit: 10,
      },
      fields: [
        { key: "image", label: "Ảnh", width: "300" },
        { key: "name", label: "Tên phim" },
        // { key: "trailler", label: "Trailler", width: "300" },
        { key: "director", label: "Đạo diễn" },
        { key: "rated", label: "Giới hạn độ tuổi" },
        { key: "status", label: "Trạng thái" },
        { key: "action", label: "Thao tác" },
      ],
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    videoId(row) {
      return getYoutubeId(row);
    },
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
    confirmEventDelete({ id }) {
      this.$confirm(
        `Bạn có chắc xóa hết tất cả dữ liệu của phim này ?`,
        "Cảnh báo",
        {
          confirmButtonText: "Chắc chắn",
          cancelButtonText: "Hủy",
          type: "warning",
        }
      ).then(async () => {
        Inertia.delete(route("superadmin.movies.delete", { id }), {
          onError: (e) => console.log(e),
        });
        this.fetchData();
        this.$message.success("Cập nhật trạng thái thành công !");
      });
    },

    async updateStatus(row, status) {
      this.$confirm(`Bạn có chắc chắn thay đổi trạng thái phim `, "Cảnh báo", {
        confirmButtonText: "Chắc chắn",
        cancelButtonText: "Hủy",
        type: "warning",
      })
        .then(async () => {
          this.loading = true;
          await updateStatusMovie(row.id, status)
            .then(async (res) => {
              this.fetchData();
              this.$message.success("Cập nhật trạng thái thành công !");
            })
            .catch(() => {
              this.fetchData();
              this.$message.error("Có lỗi trong quá trình thực thi");
            });
          this.loading = false;
        })
        .catch(() => {
          this.fetchData();
        });
    },
  },
};
</script>
