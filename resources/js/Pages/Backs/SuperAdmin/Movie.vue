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
            <el-button @click="openDialog()"> Import CSV </el-button>
            <el-button
              @click="$inertia.visit(route('superadmin.create_movie'))"
            >
              Thêm phim
            </el-button>
          </div>
        </div>

        <!-- Dialog csv -->
        <div class="customer_dialog">
          <el-dialog title="Hướng dẫn import file csv" v-model="dialogForm">
            <div class="text-bold">
              <h3>
                Để quá trình import không bị lỗi . Bạn phải thực hiện đúng các
                nguyên tắc sau :
              </h3>
              <p>
                - Các thứ tự cột và các thông tin của phim phải được sắp xếp
                theo 1 thứ tự nhất định
              </p>
              <p>- Vui lòng không chọn file có định dạng quá lớn .</p>
              <p>
                - Nếu import quá nhiều bản ghi => Nên chia nhỏ file để chương
                trình làm việc thuận lợi hơn
              </p>
              <p>
                - Bạn có thể export template mẫu và trình bày theo mẫu để việc
                import diễn ra thuận lợi
              </p>
            </div>
            <div>
              <h3 class="my-4">Chọn file import</h3>
              <form
                :action="route('superadmin.movies.import')"
                method="POST"
                enctype="multipart/form-data"
              >
                <input type="hidden" name="_token" :value="csrf" />
                <input type="file" name="file" class="form-control" />
                <br />
                <button class="btn btn-success p-2 my-4">
                  Import Movie Data
                </button>
              </form>
              <h3 class="my-4">
                Hoặc download file excel mẫu và điền thông tin của các cột giống
                như file mẫu
                <a
                  class="text-red-400 hover:underline"
                  href="/uploads/movies-model.xlsx"
                  >Export Movie Data</a
                >
              </h3>
            </div>
          </el-dialog>
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
          >Import thành công !Import thành công !Import thành công !
            <!-- <template #trailer="{ row }">
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
                <div class="mx-4">
                  <el-button size="small" type="info">Xem</el-button>
                </div>
                <div
                  class="mx-4"
                  @click="
                    $inertia.get(route('superadmin.movies.edit', row?.id))
                  "
                >
                  <el-button size="small" type="warning">Sửa</el-button>
                </div>
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
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      MOVIE_ACTIVE: MOVIE_ACTIVE,
      MOVIE_DEACTIVE: MOVIE_DEACTIVE,
      loading: false,
      dialogForm: false,
      movies: [],
      filter: {
        page: 1,
        limit: 12,
      },
      fields: [
        { key: "image", label: "Ảnh", width: "300" },
        { key: "name", label: "Tên phim" },
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
    openDialog() {
      this.dialogForm = true;
    },
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
          onSuccess: (_) => {
            this.fetchData();
          },
        });
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
