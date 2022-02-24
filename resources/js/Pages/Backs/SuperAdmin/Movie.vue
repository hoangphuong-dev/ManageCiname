<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Quản lý Phim</h2>
        <div class="w-full flex relative">
          <div class="w-3/4 flex items-end">
            <div class="search">
              <search-input :filter="filter" @submit="fetchData" label="Tìm kiếm"></search-input>
            </div>
          </div>
          <div class="w-1/4 text-right">
            <el-button @click="$inertia.visit(route('superadmin.create_movie'))">Thêm phim FFFFF</el-button>
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
            <template #question_content="{ row }">
              <iframe
                width="200"
                height="315"
                src="https://www.youtube.com/embed/s4ObxcdXoFE"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>
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
import { listMovie } from "@/API/main.js";
import Embed from "v-video-embed";
export default {
  name: "Contact",
  components: {
    AdminLayout,
    SearchInput,
    Embed,
    DataTable
  },
  data() {
    return {
      videoId: "",
      startTime: "",
      loading: false,
      dialogVisible: false,
      movies: [],
      filter: {
        page: 1,
        limit: 10
      },
      fields: [
        { key: "name", label: "Tên phim" },
        { key: "image", label: "Ảnh" },
        { key: "director", label: "Đạo diễn" },
        { key: "rated", label: "Giới hạn độ tuổi" },
        { key: "status", label: "Trạng thái" },
        { key: "question_content", label: "Youtube" }
      ]
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    showVideo(url) {
      console.log("FFFF", this.$youtube);
      //   this.videoId = this.$youtube.getIdFromURL(url.trailler);
      //   this.startTime = this.$youtube.getTimeFromURL(url.trailler);
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
    }
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
  }
};
</script>
