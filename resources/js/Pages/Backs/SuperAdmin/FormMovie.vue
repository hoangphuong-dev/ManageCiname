<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="text-center my-5">Thêm Phim</h2>
        <div class="w-1/2 m-auto">
          <el-form
            class="el-form--style"
            ref="contactForm"
            :model="formData"
            label-position="top"
            :rules="rules"
          >
            <!-- tên -->
            <el-form-item label="Tên phim" prop="name">
              <el-input v-model="formData.name"></el-input>
            </el-form-item>
            <!-- Đạo diễn -->
            <el-form-item label="Đạo diễn" prop="director">
              <el-input v-model="formData.director"></el-input>
            </el-form-item>
            <!-- Mô tả chi tiết phim -->
            <el-form-item label="Mô tả chi tiết" prop="description">
              <el-input v-model="formData.description"></el-input>
            </el-form-item>
            <!-- Trailler -->
            <el-form-item label="Trailler" prop="trailler">
              <el-input v-model="formData.trailler"></el-input>
            </el-form-item>
            <!-- Thời lượng -->
            <el-form-item label="Thời lượng" prop="movie_length">
              <el-input v-model="formData.movie_length"></el-input>
            </el-form-item>
            <!-- Giới hạn độ tuổi -->
            <el-form-item label="Giới hạn độ tuổi" prop="rated">
              <el-input v-model="formData.rated"></el-input>
            </el-form-item>
            <!-- Khu vực chiếu phim -->
            <el-form-item label="Thành phố được phép chiếu phim" prop="province">
              <el-select
                class="custom-el-form-item w-full"
                v-model="formData.province"
                placeholder="Chọn khu vực"
                clearable
                multiple
              >
                <el-option
                  v-for="item in adminInfo"
                  :key="item.province.id"
                  :label="item.province.name"
                  :value="item.province.id"
                ></el-option>
              </el-select>
            </el-form-item>

            <!-- submit -->
            <div class="flex justify-center mt-8">
              <el-form-item>
                <el-button class="btn-submit--style" @click="onSubmit">Thêm</el-button>
              </el-form-item>
            </div>
          </el-form>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { toFormData } from "@/libs/form";
import { createMovie } from "@/API/main.js";

export default {
  name: "FormAdminInfo",
  components: { AdminLayout },
  props: {
    adminInfo: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      formData: {
        name: "",
        director: "",
        description: "",
        trailler: "",
        movie_length: "",
        rated: "",
        province: [],
      },

      rules: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        director: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        description: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        trailler: [
          {
            required: true,
            message: "Trường này không được trống ",
            trigger: "blur",
          },
          {
            pattern: /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/,
            message: "Đường link không phải của youtube",
            trigger: "blur",
          },
        ],
        movie_length: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        rated: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        province: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
      },
    };
  },
  methods: {
    async onSubmit() {
      this.$refs["contactForm"].validate(async (valid) => {
        if (valid) {
          await createMovie(toFormData({ ...this.formData }, "", { indices: true }))
            .then(async (res) => {
              this.$message.success("Create success");
            })
            .catch(() => {
              this.$message.error("Server Error");
            });
        }
      });
    },
  },
};
</script>
