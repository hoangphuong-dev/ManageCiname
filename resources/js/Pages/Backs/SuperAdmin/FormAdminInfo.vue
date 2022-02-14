<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="text-center my-5">Thêm Chi nhánh</h2>
        <div class="w-1/2 m-auto">
          <el-form
            class="el-form--style"
            ref="contactForm"
            :model="formData"
            label-position="top"
            :rules="rules"
          >
            <!-- tên -->
            <el-form-item label="Chủ sở hữu" prop="name">
              <el-input v-model="formData.name"></el-input>
            </el-form-item>
            <!-- số điện thoại -->
            <el-form-item label="Số điện thoại" prop="phone">
              <el-input v-model="formData.phone"></el-input>
            </el-form-item>
            <!-- mail -->
            <el-form-item label="Email" prop="email">
              <el-input v-model="formData.email"></el-input>
            </el-form-item>
            <!-- khu vực quản lý -->
            <el-form-item label="Khu vực quản lý" prop="province">
              <el-select
                class="custom-el-form-item w-full"
                v-model="formData.province"
                placeholder="Chọn khu vực"
                clearable
              >
                <el-option
                  v-for="item in provinces"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
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
import { createAdmin } from "@/API/main.js";

export default {
  name: "FormAdminInfo",
  components: { AdminLayout },
  props: {
    provinces: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      formData: {
        name: "",
        email: "",
        phone: "",
        province: "",
      },

      rules: {
        name: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        province: {
          required: true,
          message: "Trường này không được trống ",
          trigger: "blur",
        },
        email: [
          {
            required: true,
            message: "Trường này không được trống ",
            trigger: "blur",
          },
          {
            type: "email",
            message: "Email không đúng định dạng",
            trigger: "blur",
          },
        ],
        phone: [
          {
            required: true,
            message: "Trường này không được bỏ trống",
            trigger: "blur",
          },
          {
            validator: function (err, value, callback) {
              let val = value.replace(/\s+/g, " ");
              if (!(val.length >= 9 && val.length <= 12) || value.includes(" ")) {
                return callback("Số điện thoại không đúng định dạng");
              }
              callback();
            },
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    async onSubmit() {
      this.$refs["contactForm"].validate(async (valid) => {
        if (valid) {
          await createAdmin(toFormData({ ...this.formData }, "", { indices: true }))
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
