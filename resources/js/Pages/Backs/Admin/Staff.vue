<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Quản lý Nhân viên</h2>
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
            <el-button @click="openDialog()"> Thêm nhân viên </el-button>
          </div>
        </div>

        <!-- Dialog add -->
        <div class="customer_dialog">
          <el-dialog title="Thêm nhân viên" v-model="dialogForm"> </el-dialog>
        </div>

        <div class="mt-5">
          <data-table
            :fields="fields"
            :items="staffs.data"
            :paginate="staffs.meta"
            :current-page="filter.page || 1"
            disable-table-info
            footer-center
            paginate-background
            enable-select-box
            @page="handleCurrentPage"
          >
            <template #status="{ row }">
              <el-tag
                @click="updateStatus(row, row?.status)"
                v-if="row?.status == 0"
                class="ml-2 cursor-pointer"
                type="warning"
              >
                Đang chờ duyệt
              </el-tag>
              <el-tag v-if="row?.status == 1" class="ml-2" type="success">
                Đang làm việc
              </el-tag>
              <el-tag v-if="row?.status == 2" class="ml-2" type="error"
                >Nghỉ việc</el-tag
              >
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
              </div>
            </template>

            <template #type_of_work="{ row }">
              <el-tag v-if="row?.type_of_work == 0" class="ml-2" type="warning">
                Partime
              </el-tag>
              <el-tag v-else class="ml-2" type="success">Fulltime</el-tag>
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
import { listStaff, updateStatusMovie } from "@/API/main.js";
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
      loading: true,
      dialogForm: false,
      staffs: [],
      filter: {
        page: 1,
        limit: 12,
      },
      fields: [
        { key: "image", label: "Ảnh" },
        { key: "name", label: "Tên nhân viên" },
        { key: "email", label: "Email", width: "300" },
        { key: "phone", label: "Số điện thoại" },
        { key: "status", label: "Trạng thái" },
        { key: "type_of_work", label: "Loại công việc" },
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
      listStaff(this.filter)
        .then((res) => {
          this.staffs = res.status === 200 ? res.data : [];
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
      this.$confirm(
        `Bạn có chắc chắn thay đổi trạng thái nhân viên `,
        "Cảnh báo",
        {
          confirmButtonText: "Chắc chắn",
          cancelButtonText: "Hủy",
          type: "warning",
        }
      )
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
