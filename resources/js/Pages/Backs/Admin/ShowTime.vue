<template>
  <div class="p-4">
    <div class="w-full flex relative my-4">
      <div class="w-3/4 flex items-end">
        <div class="search">
          <el-input
            ref="search"
            placeholder="Tìm suat chieu... "
            clearable
            v-model="showtimes.keyword"
            @keyup.enter="searchChange()"
          />
        </div>
      </div>
      <div class="w-1/4 text-right">
        <el-button @click="onOpenDialogShowTime">Thêm Suat chieu</el-button>
      </div>
    </div>
    <div class="grid grid-cols-6 gap-4">
      <!-- <div class="border rounded-md p-4" v-for="item in rooms.data" :key="item.id">
                  <h2 class="text-center cursor-pointer">{{ item.name }}</h2>
                  <p class="text-center">{{ item.row_number * item.column_number }} ghế</p>
                  <p class="text-center">Trạng thái {{item.status}}</p>
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
                </div> -->
    </div>
    <!-- phan trang phòng chiếu  -->
    <!-- <div
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
              </div> -->
    <!-- dialog suat chieu  -->
    <div class="customer_dialog">
      <el-dialog
        class="text-center"
        :title="
          selectedItemShowTime === null
            ? 'Thêm suat chieu'
            : 'Sửa thông tin suat'
        "
        v-model="dialogFormVisibleShowTime"
      >
        <el-form
          class="text-center w-1/2 m-auto"
          ref="formDataShowTime"
          :model="formDataShowTime"
          label-position="top"
          :rules="rulesShowTime"
        >
          <!-- Tên rạp -->
          <el-form-item label="Tên phòng" prop="name">
            <el-input
              v-model="formDataShowTime.name"
              autocomplete="off"
              placeholder="Nhập tên phòng"
            ></el-input>
          </el-form-item>
        </el-form>
        <!-- submit -->
        <div class="text-right">
          <span class="dialog-footer">
            <el-button @click="dialogFormVisibleShowTime = false"
              >Hủy</el-button
            >
            <el-button type="primary" @click="viewDiagram">
              <span v-if="selectedItemShowTime === null">Thêm suất chiếu</span>
            </el-button>
          </span>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import PageInfo from "@/Components/Control/PageInfo.vue";
import { listShowTime } from "@/API/main.js";
export default {
  name: "HomeStaff",
  components: {
    AdminLayout,
    PageInfo,
    SearchInput,
    Pagination,
  },
  data() {
    return {
      showtimes: {
        data: [],
        total: "",
        keyword: "",
        perPage: "",
        filter: {
          page: 1,
          limit: 10,
          cinema_id: this.cinema.id,
        },
      },
      selectedItemShowTime: null,
      dialogFormVisibleShowTime: false,
      formDataShowTime: {
        name: "",
      },
      rulesShowTime: {
        name: [
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
    async fetchDataShowTime() {
      this.loading = true;
      listShowTime(this.rooms.filter)
        .then(({ status, data }) => {
          this.rooms.data = status === 200 ? data.data : this.rooms.data;
          this.rooms.total = data.meta.total;
          this.rooms.perPage = data.meta.per_page;
        })
        .catch(() => {});
      this.loading = false;
    },
    onOpenDialogShowTime() {
      this.selectedItemShowTime = null;
      this.dialogFormVisibleShowTime = !this.dialogFormVisibleShowTime;
    },
  },
};
</script>
