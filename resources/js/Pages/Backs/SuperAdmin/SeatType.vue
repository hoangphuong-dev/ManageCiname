<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Quản lý loại ghế</h2>
        <div class="w-full flex relative">
          <div class="w-3/4"></div>
          <div class="w-1/4 text-right">
            <el-button @click="openDialogSeatType">Thêm Loại ghế</el-button>
          </div>
          <!-- dialog lọai ghế  -->
          <div class="customer_dialog">
            <el-dialog
              class="text-center"
              title="Thêm loại ghế"
              v-model="dialogFormVisibleSeatType"
            >
              <el-form
                class="text-center w-1/2 m-auto"
                ref="SeatTypeForm"
                :model="formData"
                label-position="top"
                :rules="rules"
              >
                <el-form-item label="Loại ghế" prop="name">
                  <el-input
                    v-model="formData.name"
                    autocomplete="off"
                    placeholder="Nhập tên"
                  ></el-input>
                </el-form-item>

                <el-form-item label="Giá tiền loại ghế" prop="price">
                  <el-input
                    v-model="formData.price"
                    autocomplete="off"
                    placeholder="Nhập giá tiền"
                  ></el-input>
                </el-form-item>

                <div class="w-1/6 mb-2">
                  <div
                    class="
                      w-48
                      h-60
                      flex
                      justify-center
                      items-center
                      border
                      rounded
                      hover:cursor-pointer
                    "
                    @click="$refs.inputUpload.click()"
                  >
                    <div
                      class="xl:flex flex-col justify-center items-center"
                      v-if="!imagePreview"
                    >
                      <el-empty description="Không có dữ liệu"></el-empty>
                      <p class="text-lightGreen">Chọn ảnh</p>
                    </div>
                    <img
                      v-else
                      :src="imagePreview"
                      class="rounded w-full h-full object-cover"
                    />
                    <input
                      class="hidden"
                      ref="inputUpload"
                      type="file"
                      @change="handleFileChange($event)"
                    />
                  </div>
                </div>
              </el-form>
              <!-- submit -->
              <div class="text-right">
                <span class="dialog-footer">
                  <el-button @click="dialogFormVisibleSeatType = false"
                    >Hủy</el-button
                  >
                  <el-button type="primary" @click="submitSeatType"
                    >Thêm</el-button
                  >
                </span>
              </div>
            </el-dialog>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-5">
          <div
            v-for="item in seatTypes"
            :key="item"
            class="border rounded-md p-4 cursor-pointer"
          >
            <div class="flex cursor-pointer" @click="edit(item)">
              <div class="w-1/2">
                <img
                  class="w-full h-full rounded"
                  :src="getImage(item.image)"
                />
              </div>
              <div class="w-1/2">{{ item.name }}</div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { listSeatType, createSeatType } from "@/API/main.js";
import { toFormData } from "@/libs/form";

export default {
  name: "SeatType",

  components: {
    AdminLayout,
    SearchInput,
    Pagination,
  },

  data() {
    return {
      imagePreview: "",
      loading: false,
      dialogFormVisibleSeatType: false,
      keyword: "",
      seatTypes: [],
      formData: {
        name: "",
        price: "",
        image: "",
      },
      rules: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        price: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
      },
    };
  },

  created() {
    this.fetchData();
  },

  methods: {
    handleFileChange(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        const image = files[0];
        if (!image.name.match(/.(jpg|jpeg|png)$/i)) {
          return this.$message.error("Error ...");
        }

        let reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        this.formData.image = image;
        reader.readAsDataURL(image);
      }
    },

    openDialogSeatType() {
      this.dialogFormVisibleSeatType = true;
      this.resetForm();
    },

    searchChange() {
      this.filter.name = this.keyword;
      this.$emit("handleFilter");
    },

    async submitSeatType() {
      this.$refs["SeatTypeForm"].validate(async (valid) => {
        if (valid) {
          await createSeatType(
            toFormData({ ...this.formData }, "", { indices: true })
          )
            .then(async (res) => {
              this.$message.success("Create success");
              this.dialogFormVisibleSeatType = false;
              this.resetForm();
              this.fetchData();
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
        }
      });
    },

    edit(item) {
      this.dialogFormVisibleSeatType = true;
      this.formData.name = item.name;
      this.formData.price = item.price;
    },

    resetForm() {
      this.formData.name =
        this.formData.price =
        this.formData.image =
        this.imagePreview =
          "";
    },

    async fetchData() {
      this.loading = true;
      listSeatType(this.filter)
        .then(({ status, data }) => {
          this.seatTypes = status === 200 ? data.data : this.seatTypes;
          this.total = data.data.meta.total;
          this.perPage = data.data.meta.per_page;
        })
        .catch(() => {});
      this.loading = false;
    },

    isValidHttpUrl(string) {
      let url;
      try {
        url = new URL(string);
      } catch (_) {
        return false;
      }
      return url.protocol === "http:" || url.protocol === "https:";
    },

    getImage(file) {
      if (!file) return;
      if (this.isValidHttpUrl(file)) return file;
      return `/storage/${file}`;
    },
  },
};
</script>
